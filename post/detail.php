<?php

require_once __DIR__ . '/../src/bootstrap.php';

$pdo = require_once __DIR__ . '/../config/connect.php';

require_once __DIR__ . '/../src/Controller/detail.php';

view('header', ['title' => $title]);
?>

<div class="row">
    <div class="col-md-8">
        <div class="slider">
            <i class="fa fa-angle-left slider-prev"></i>
            <ul class="slider-dots">
                <?php if($images !== []) : ?>
                    <li class="slider-dot-item active" data-index="0"></li>
                    <?php for($i = 1; $i < count($images); $i++): ?>
                        <li class="slider-dot-item" data-index="<?=$i?>"></li>
                    <?php endfor ?>
                <?php endif ?>
            </ul>
            <div class="slider-wrapper">
                <div class="slider-main">
                <?php if($images !== []) : ?>
                    <?php foreach($images as $image): ?>
                        <div class="slider-item">
                            <img src="<?= $image['path_image'] ?>" alt="" />
                        </div>
                    <?php endforeach ?>
                <?php endif; ?>
                </div>
            </div>
            <i class="fa fa-angle-right slider-next"></i>
        </div>
        <div class="title">
            <h3><?= $title ?></h3>
        </div>
        <div class="red_block_line">
            <div class="salary">
                <?php if($post['negotiate'] == 1): ?>
                    <div>Negotiate</div>
                <?php elseif ($post['min_salary'] != 0 && $post['max_salary'] != 0): ?>
                    <div class="salary_min"> <?= number_format($post['min_salary']) ?> </div>
                    <div class="salary_horizontal"> - </div>
                    <div class="salary_max"><?= number_format($post['max_salary']) ?> </div>
                    <div class="salary_unit"> đ/tháng</div>
                <?php else: ?>
                    <div class="salary_max"><?= number_format($post['max_salary']) ?> </div>
                    <div class="salary_unit"> đ/tháng</div>
                <?php endif ?>
            </div>
            <div class="save_post">
                <span class="btn_save">Save
                    <i class="fa-regular fa-heart"></i>
                </span>
            </div>
        </div>
        <div class="user">
            <div class="user-img">
                <img src="../public/image/worker.png" alt="">
            </div>
            <div class="user_info">
                <div>
                    <i class="fa-solid fa-briefcase info-icon"></i> <span><?= $post['company_name'] ?></span>
                </div>
                <div>
                    <i class="fa-solid fa-location-dot info-icon p-10"></i> <span><?= $address ?></span>
                </div>
            </div>
        </div>
        <div class="content">
            <?= $post['content'] ?>
        </div>
        <div class="required">
            <div class="required_left">
                <p class="m-20"><i class="fa-solid fa-money-check-dollar info-icon"></i> Payment: <?=$payments[$post['payment']]?></p>
                <p class="m-20"><i class="fa-solid fa-briefcase info-icon info-icon"></i>Carrer: <?=$careers[$post['career']] ?></p>
                <p class="m-20"><i class="fa-solid fa-signature info-icon"></i>Comapny name: <?= $post['company_name'] ?></p>
                <p class="m-20"><i class="fa-solid fa-graduation-cap info-icon"></i>Minimal educate: <?=$levelEducates[$post['minimal_education']]?></p>
                <p class="m-20"><i class="fa-solid fa-angle-left info-icon"></i>Minimal age: <?=$post['minimal_age']?></p>
                <p class="m-20"><i class="fa-solid fa-chevron-right info-icon"></i>Maximum age: <?=$post['maximum_age']?></p>
            </div>
            <div class="required_right">
                <p class="m-20"><i class="fa-sharp fa-solid fa-clock info-icon"></i>Type of work: <?=$typeOfWork[$post['type_of_work']]?></p>
                <p class="m-20"><i class="fa-solid fa-venus-mars info-icon"></i>Gender: <?=$genders[$post['gender']] ?></p>
                <p class="m-20"><i class="fa-solid fa-people-group info-icon"></i>Hiring quantity: <?=$post['hiring_quantity']?></p>
                <?php if(!is_null($post['benefit'])): ?>
                    <p class="m-20"><i class="fa-regular fa-star info-icon"></i>Benefit: <?=$post['benefit']?></p>
                <?php endif ?>
                <?php if(!is_null($post['certificate_skill'])): ?>
                    <p class="m-20"><i class="fa-solid fa-certificate info-icon"></i>Certificate/Skill: <?=$post['certificate_skill']?></p>
                <?php endif ?>

            </div>
        </div>
        <div class="place">
            <p><b>Workplace</b></p>
            <div>
                <i class="fa-solid fa-location-dot info-icon m-20"></i> <span><?= $address ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="wrap-right">
            <div class="info-shop">
                <div class="info_detail">
                    <div class="logo">
                        <img src="../public/image/worker.png" alt="">
                    </div>
                    <div class="name_company">
                        <b><?=$post['company_name']?></b>
                    </div>
                </div>
                <div>
                    <span class="btn-view">
                        View Shop
                    </span>
                </div>
            </div>
            <div class="youare">
                <p class="pb-10">Company</p>
                <p><i class="fa-solid fa-briefcase info-icon"></i></p>
            </div>
            <div class="contact">
                <div class="recruitment">
                    <div class="recruitment_icon"><i class="fa-solid fa-address-card"></i></div>
                    <div><b><?= strtoupper('Recruitment') ?></b></div>
                </div>
                <div class="phone">
                    <div class="phone_icon">
                        <i class="fa-solid fa-phone-volume"></i> <span>0961828889</span>
                    </div>
                    <div>
                        <b><?= strtoupper('Click show phone') ?></b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../public/assets/js/slider.js"></script>
<?php view('footer'); ?>