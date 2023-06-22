<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/responsive.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title><?= $title ?? 'Home' ?></title>
</head>

<body>
    <header>
        <div class="header-wrapper">
            <div class="site-branding">
                <a href="http://localhost/tb/ca">
                    <img src="./image/f_logo.png" width="70%" height="70%" alt="Logo" class="logo">
                </a>
            </div>
            <nav class="site-navigation">

                <div class="dropdown">
                    <div>
                        <span class="text-white fz-18">Welcome <?php echo ucfirst('username') ?> !</span>
                        <i id="dropbtn" class=" dropbtn fa-sharp fa-solid fa-caret-down"></i>
                    </div>
                    <div class="dropdown-content" id="myDropdown">
                        <ul class="nav__pc-list">
                            <li>
                                <a href="#" class="nav__pc-link">
                                    <i class="fa-solid fa-gear"></i>
                                    Setting
                                </a>
                            </li>
                            <li>
                                <a href="./logout.php" class="nav__pc-link">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- icon bar show display mobile -->
                <label for="nav-mobile-input" class="nav__bars-btn">
                    <i class="fa-solid fa-bars"></i>
                </label>

                <input type="checkbox" class="nav__input" id="nav-mobile-input">

                <label for="nav-mobile-input" class="nav__overlay"></label>

                <nav class="nav__mobile">
                    <label for="nav-mobile-input">
                        <i class="nav__mobile-close fa-solid fa-xmark"></i>
                    </label>
                    <ul class="nav__mobile-list">
                        <li>
                            <a href="#" class="nav__mobile-link">
                                <i class="fa-solid fa-gear"></i>
                                Setting
                            </a>
                        </li>
                        <li>
                            <a href="./logout.php" class="nav__mobile-link">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </nav>
        </div>
    </header>
    <main>