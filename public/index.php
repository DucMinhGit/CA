<?php

require_once __DIR__ . '/../src/bootstrap.php';

require_login();

view('header', ['title' => 'Dashboard']);
?>

<p>Welcome <?= current_user() ?> <a href="logout.php">Logout</a></p>

<?php
view('footer');
?>