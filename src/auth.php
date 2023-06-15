<?php

/**
 * Insert infomation user to database
 * 
 * @param string $email
 * @param string $username
 * @param string $password
 * @param bool $is_admin
 * @param string $activation_code
 * @param int $expiry
 * @return bool
 */
function register_user(
    string $username,
    string $email,
    string $password,
    string $activation_code,
    int $expiry = 1 * 24 * 60 * 60,
    bool $is_admin = false
): bool {

    $sql = "INSERT INTO users(username, email, password, is_admin, activation_code, activation_expiry) 
            VALUES (:username, :email, :password, :is_admin, :activation_code, :activation_expiry)";

    $statement = db()->prepare($sql);

    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);
    $statement->bindValue(':activation_code', password_hash($activation_code, PASSWORD_DEFAULT));
    $statement->bindValue(':activation_expiry', date('Y-m-d H:i:s',  time() + $expiry));

    return $statement->execute();
}

/**
 * Find user by username
 * @param string $username
 * @return array | bool
 */
function find_user_by_username(string $username): array | bool
{
    $sql = "SELECT username, password, active, email 
            FROM users 
            WHERE username=:username";

    $statement = db()->prepare($sql);
    $statement->bindValue(":username", $username, PDO::PARAM_STR);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Login user
 * @param string $username
 * @param string $password
 * @return bool
 */
function login(string $username, string $password): bool
{
    $user = find_user_by_username($username);

    // if user found, check the password
    if ($user && is_user_active($user) && password_verify($password, $user['password'])) {
        // prevent session fixation attack
        session_regenerate_id();

        // set username in the session
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];

        return true;
    }

    return false;
}

/**
 * Returns true if a user is currently logged
 * @return bool
 */
function is_user_logged(): bool
{
    return isset($_SESSION['username']);
}

/**
 * Check user logged, if user not logged redirect to login page
 * @return void
 */
function require_login(): void
{
    if (!is_user_logged()) {
        redirect_to('login.php');
    }
}

/**
 * Logout user
 * @return void
 */
function logout(): void
{
    if (is_user_logged()) {
        unset($_SESSION['username'], $_SESSION['user_id']);
        session_destroy();
        redirect_to('login.php');
    }
}

/**
 * Get current user logged
 */
function current_user()
{
    if (is_user_logged()) {
        return $_SESSION['username'];
    }

    return null;
}

/**
 * Get current user id
 */
function user_id()
{
    if (is_user_logged()) {
        return $_SESSION['user_id'];
    }

    return null;
}

/**
 * Return user active
 * @param array $user;
 * @return bool
 */
function is_user_active($user): bool
{
    return (int)$user['active'] === 1;
}

/**
 * Delete user by id
 * @param int $id
 * @param int $active
 * @return bool
 */
function delete_user_by_id(int $id, int $active = 0)
{
    $sql = "DELETE FROM users WHERE id=:id AND active=:active";

    $statement = db()->prepare($sql);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->bindValue(":active", $active, PDO::PARAM_INT);

    return $statement->execute();
}

/**
 * Find unverified user
 * @param string $activation_code
 * @param string $email
 * @return 
 */
function find_unverified_user(string $activation_code, string $email)
{
    $sql = "SELECT id, activation_code, activation_expiry < now() as expired 
            FROM users
            WHERE active = 0 and email=:email";

    $statement = db()->prepare($sql);

    $statement->bindValue(":email", $email, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // already expired, delete the in active user with expired activation code
        if ((int)$user['expired'] === 1) {
            delete_user_by_id($user['id']);
            return null;
        }

        // verify the password
        if (password_verify($activation_code, $user['activation_code'])) {
            return $user;
        }
    }

    return false;
}

/**
 * Activate user
 * @param int $user_id
 * @return bool
 */
function activate_user(int $user_id): bool
{
    $sql = "UPDATE users SET active = 1, activated_at = CURRENT_TIMESTAMP WHERE id=:id";

    $statement = db()->prepare($sql);
    $statement->bindValue(":id", $user_id, PDO::PARAM_INT);

    return $statement->execute();
}
