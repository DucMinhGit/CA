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
    $sql = "SELECT id, username, password, active, email 
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
function login(string $username, string $password, bool $remember = true): bool
{
    $user = find_user_by_username($username);

    // if user found, check the password
    if ($user && is_user_active($user) && password_verify($password, $user['password'])) {

        log_user_in($user);

        if ($remember) {
            remember_me($user['id']);
        }

        return true;
    }

    return false;
}

/**
 * Log a user in
 * @param array $user
 * @return bool
 */
function log_user_in(array $user): bool
{
    // prevent session fixation attack
    if (session_regenerate_id()) {
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
// function is_user_logged(): bool
// {
//     return isset($_SESSION['username']);
// }

/**
 * Check user logged, if user not logged redirect to login page
 * @return void
 */
function require_login(): void
{
    if (!is_user_logged_in()) {
        redirect_to('http://localhost/tb/ca/login.php');
    }
}

/**
 * Logout user
 * @return void
 */
function logout(): void
{
    if (is_user_logged_in()) {

        // Delete the user token
        delete_user_token($_SESSION['user_id']);

        // Delete session
        unset($_SESSION['usersname'], $_SESSION['user_id']);

        // remove the remember_me cookie
        if (isset($_COOKIE['remember_me'])) {
            unset($_COOKIE['remember_me']);
            setcookie('remember_user', null, -1);
        }

        // remove all session data
        session_destroy();

        // redirect to the login page
        redirect_to('login.php');
    }
}

/**
 * Get current user logged
 */
function current_user()
{
    if (is_user_logged_in()) {
        return $_SESSION['username'];
    }

    return null;
}

/**
 * Get current user id
 */
function user_id()
{
    if (is_user_logged_in()) {
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

/**
 * Insert a new user token
 * @param int $user_id
 * @param int $selector
 * @param int $hash_validator
 * @param int $expiry
 * @return bool
 */
function insert_user_token(int $user_id, string $selector, string $hash_validator, string $expiry): bool
{
    $sql = 'INSERT INTO user_tokens(user_id, selector, hashed_validator, expiry)
            VALUES (:user_id, :selector, :hashed_validator, :expiry)';

    $statement = db()->prepare($sql);
    $statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $statement->bindValue(":selector", $selector, PDO::PARAM_STR);
    $statement->bindValue(":hashed_validator", $hash_validator, PDO::PARAM_STR);
    $statement->bindValue(":expiry", $expiry, PDO::PARAM_STR);

    return $statement->execute();
}

/**
 * Find token by a selector
 * @param string $selector
 * @return 
 */
function find_user_token_by_selector(?string $selector)
{
    $sql = "SELECT id, selector, hashed_validator, user_id, expiry
            FROM user_tokens
            WHERE selector=:selector AND expiry >= now()
            LIMIT 1";

    $statement = db()->prepare($sql);
    $statement->bindValue(':selector', $selector, PDO::PARAM_STR);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Deletes all tokens associated with a user
 * @param int $user_id
 * @return bool
 */
function delete_user_token(int $user_id): bool
{
    $sql = "DELETE FROM user_tokens WHERE user_id=:user_id";

    $statement = db()->prepare($sql);
    $statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);

    return $statement->execute();
}

/**
 * Find a user by a token
 * @param string $token
 * @return ?array
 */
function find_user_by_token(string $token): ?array
{
    $tokens = parse_token($token);

    if (!$tokens) {
        return null;
    }

    $sql = "SELECT users.id, username
            FROM users
            INNER JOIN user_tokens
            ON users.id = user_tokens.user_id
            WHERE user_tokens.selector=:selector";

    $statement = db()->prepare($sql);
    $statement->bindValue(":selector", $tokens[0]);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Check if token is valid
 * @param string $token
 * @return bool
 */
function token_is_valid(string $token): bool
{
    // parse the token to get the selector and validator
    [$selector, $validator] = parse_token($token);

    $tokens = find_user_token_by_selector($selector);

    if (!$tokens) {
        return false;
    }

    return password_verify($validator, $tokens['hashed_validator']);
}

/**
 * Is return logged in
 * @return bool
 */
function is_user_logged_in(): bool
{
    // check the session
    if (isset($_SESSION['username'])) {
        return true;
    }

    // check the remember_me in cookie
    $token = filter_input(INPUT_COOKIE, 'remember_me', FILTER_SANITIZE_STRING);

    if ($token && token_is_valid($token)) {
        $user = find_user_by_token($token);

        if ($user) {
            return log_user_in($user);
        }
    }

    return false;
}
