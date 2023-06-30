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

<div class="row">
    <div class="col-md-8">
        <div class="slider">
            <i class="fa fa-angle-left slider-prev"></i>
            <ul class="slider-dots">
                <!-- <li class="slider-dot-item active" data-index="0"></li> -->
            </ul>
            <div class="slider-wrapper">
                <div class="slider-main">
                    <div class="slider-item">
                        <img src="" alt="" />
                    </div>
                </div>
            </div>
            <i class="fa fa-angle-right slider-next"></i>
        </div>
        <div class="title">
            <h3><?= $title ?></h3>
        </div>
        <div class="red_block_line">
            <div class="salary">
                <div class="salary_min"> 12.000.000 </div>
                <div class="salary_horizontal"> - </div>
                <div class="salary_max">15.000.000 </div>
                <div class="salary_unit"> đ/tháng</div>
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
                    <i class="fa-solid fa-briefcase info-icon"></i> <span>Duc Minh Company</span>
                </div>
                <div>
                    <i class="fa-solid fa-location-dot info-icon p-10"></i> <span>address</span>
                </div>
            </div>
        </div>
        <div class="content">
            <!--content -->
        </div>
        <div class="required">
            <div class="required_left">
                <p class="m-20"><i class="fa-solid fa-money-check-dollar info-icon"></i> Hình thức trả lương: Theo tháng</p>
                <p class="m-20"><i class="fa-solid fa-briefcase info-icon info-icon"></i>Ngành nghề: Bán hàng</p>
                <p class="m-20"><i class="fa-solid fa-signature info-icon"></i>Tên công ty: Duc Minh Company</p>
                <p class="m-20"><i class="fa-solid fa-graduation-cap info-icon"></i>Học vấn tối thiểu: Cấp 3</p>
                <p class="m-20"><i class="fa-solid fa-chevron-right info-icon"></i>Tuổi tối đa: 26</p>
            </div>
            <div class="required_right">
                <p class="m-20"><i class="fa-sharp fa-solid fa-clock info-icon"></i>Loại công việc: Toàn thời gian</p>
                <p class="m-20"><i class="fa-solid fa-venus-mars info-icon"></i>Giới tính: Không yêu cầu</p>
                <p class="m-20"><i class="fa-solid fa-people-group info-icon"></i>Số lượng tuyển dụng: 300</p>
                <p class="m-20"><i class="fa-solid fa-angle-left info-icon"></i>Tuổi tối thiểu: 18</p>
            </div>
        </div>
        <div class="place">
            <p><b>Workplace</b></p>
            <div>
                <i class="fa-solid fa-location-dot info-icon m-20"></i> <span>Nơi làm việc: address</span>
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
                        <b>Duc Minh Company</b>
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