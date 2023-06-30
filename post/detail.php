<?php

require_once __DIR__ . '/../src/bootstrap.php';
$pdo = require_once __DIR__ . '/../config/connect.php';

if (!isset($_GET['id'])) {
    redirect_to('404.php');
}

$fields = ['id' => 'int | config_numeric'];

[$inputs, $errors] = filter($_GET, $fields);

$title = get_title_post_by_id($pdo, $inputs['id']);

view('header', ['title' => $title]);
?>
<div class="">
    <p>Home page > Technology</p>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="slider">
        <i class="fa fa-angle-left slider-prev"></i>
        <ul class="slider-dots">
            <li class="slider-dot-item active" data-index="0"></li>
            <li class="slider-dot-item" data-index="1"></li>
            <li class="slider-dot-item" data-index="2"></li>
            <li class="slider-dot-item" data-index="3"></li>
        </ul>
        <div class="slider-wrapper">
            <div class="slider-main">
                <div class="slider-item">
                    <img
                    src="https://images.unsplash.com/photo-1463501810073-6e31c827a9bc?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                    alt=""
                    />
                </div>
                <div class="slider-item">
                    <img
                    src="https://images.unsplash.com/photo-1497752531616-c3afd9760a11?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                    alt=""
                    />
                </div>
                <div class="slider-item">
                    <img
                    src="https://images.unsplash.com/photo-1425082661705-1834bfd09dca?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1355&q=80"
                    alt=""
                    />
                </div>
                <div class="slider-item">
                    <img
                    src="https://images.unsplash.com/photo-1470093851219-69951fcbb533?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                    alt=""
                    />
                </div>
            </div>
        </div>
        <i class="fa fa-angle-right slider-next"></i>
        </div>
    </div>
    <div class="col-lg-4"></div>
</div>

<script src="../public/assets/js/slider.js"></script>
<?php view('footer'); ?>