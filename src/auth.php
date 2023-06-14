<?php

/**
 * Insert infomation user to database
 * 
 * @param string $email
 * @param string $username
 * @param string $password
 * @param bool $is_admin
 * @return bool
 */
function register_user(string $username, string $email, string $password, bool $is_admin = false): bool
{
    $sql = "INSERT INTO users(username, email, password, is_admin) VALUES (:username, :email, :password, :is_admin)";

    $statement = db()->prepare($sql);

    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);

    return $statement->execute();
}

/**
 * Find user by username
 * @param string $username
 * @return array | bool
 */
function find_user_by_username(string $username): array | bool
{
    $sql = "SELECT username, password 
            FROM users 
            WHERE username=:username";

    $statement = db()->prepare($sql);
    $statement->bindValue(":username", $username, PDO::PARAM_STR);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Login user
 * @param string $string
 * @param string $username
 * @return bool
 */
function login(string $username, string $password): bool
{
    $user = find_user_by_username($username);

    // if user found, check the password
    if ($user && password_verify($password, $user['password'])) {
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
