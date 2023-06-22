<?php

require_once __DIR__ . '/../src/bootstrap.php';

view('header', ['title' => 'Create Post']);
flash();
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form">
        <div class="form__image">
            <input type="file" name="file[]" id="" multiple>
        </div>
        <div class="form__input">
            <div class="form__input-employer">
                <h3 class="p-10">Employer information</h3>
                <div class="p-10">
                    <p class="fz-11">You are <span class="text-danger">*</span> </p>

                    <label for="individual">Individual</label>
                    <input type="radio" name="youare" value="1" id="individual">

                    <label for="company">Company</label>
                    <input type="radio" name="youare" value="2" id="company">
                </div>
                <div class="p-10">
                    <input type="text" name="company_name" id="company_name" placeholder="Company name" class="border_style w-input company_name">
                </div>
                <div class="p-10">
                    <select name="city" class="form-select form-select-sm mb-3" id="city" aria-label=".form-select-sm">
                        <option value="" selected>Chọn tỉnh thành</option>
                    </select>

                    <select name="district" class="form-select form-select-sm mb-3" id="district" aria-label=".form-select-sm">
                        <option value="" selected>Chọn quận huyện</option>
                    </select>

                    <select name="wards" class="form-select form-select-sm" id="ward" aria-label=".form-select-sm">
                        <option value="" selected>Chọn phường xã</option>
                    </select>
                    <input type="text" name="address_detail" value="">
                </div>
            </div>
            <div class="form__input-job-content">
                <h3>Job posting content</h3>
                <div class="p-10">
                    <input type="text" class="border_style w-input" name="title" placeholder="Title">
                </div>
                <div class="p-10">
                    <input type="number" class="border_style w-input" name="quantity" value="" placeholder="Number of recruitments">
                </div>
                <div class="p-10">
                    <select name="career" id="">
                        <option value="">CNTT</option>
                        <option value="">OTO</option>
                    </select>
                </div>
                <div class="p-10">
                    <select name="type_of_work" id="">
                        <option value="0">Full-time</option>
                        <option value="1">Part-time</option>
                        <option value="2">By product/work from home</option>
                        <option value="3">Shift-work</option>
                        <option value="4">Collaborators</option>
                    </select>
                </div>
                <div class="p-10">
                    <select name="payment" id="">
                        <option value="">Hour</option>
                        <option value="">Date</option>
                        <option value="">Month</option>
                        <option value="">contract salary</option>
                    </select>
                </div>
                <div class="g-col p-10">
                    <input type="number" name="salary_min" value="" placeholder="Min salary" class="border_style w45-input">
                    <input type="number" name="salary_max" value="" placeholder="Max salary" class="border_style w45-input">
                </div>
                <div class="p-10">
                    <textarea name="content" id="" cols="30" rows="10" class="w-input border-textarea" placeholder="Job description"></textarea>
                </div>
            </div>
            <div class="form__input-info-more">
                <h3>More information</h3>
                <div class="g-col p-10">
                    <input type="number" name="age_min" value="" placeholder="Min age" class="border_style w45-input">
                    <input type="number" name="age_max" value="" placeholder="Max age" class="border_style w45-input">
                </div>
                <div class="p-10">
                    <p class="fz-11">Gender <span class="text-danger">*</span> </p>

                    <label for="male">Male</label>
                    <input type="radio" name="gender" value="1" id="male">

                    <label for="female">Female</label>
                    <input type="radio" name="gender" value="2" id="female">

                    <label for="other">Not require</label>
                    <input type="radio" name="gender" value="3" id="other">
                </div>
                <div class="p-10">
                    <select name="educate" id="">
                        <option value="0">No require</option>
                        <option value="1">Graduated from elementary school</option>
                        <option value="2">Graduated from secondary school</option>
                        <option value="3">High School Graduation</option>
                        <option value="4">Vocational</option>
                        <option value="5">College</option>
                        <option value="6">University</option>
                        <option value="7">Khác</option>
                    </select>
                </div>
                <div class="p-10">
                    <select name="experience" id="">
                        <option value="0">No require</option>
                        <option value="1">
                            < 1 year</option>
                        <option value="2">1 - 2 year</option>
                        <option value="3">3 - 5 year</option>
                        <option value="4">6 - 10 year</option>
                        <option value="5">> 10 year</option>
                    </select>
                </div>
                <div class="p-10">
                    <input type="text" name="skill" placeholder="Certificate/Skills" class="border_style w-input">
                </div>
                <div class="p-10">
                    <input type="text" name="benefit" id="benefit" placeholder="Benefit" class="border_style w-input">
                </div>
            </div>
            <button type="submit" class="btn">Create</button>
        </div>
    </div>
</form>
<?php view('footer'); ?>