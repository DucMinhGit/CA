<?php

require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/Controller/PostController.php';

view('header', ['title' => 'Create Post']);
flash();

?>
<form action="" method="post" enctype="multipart/form-data">
    <!-- CSRF TOKEN -->
    <input id="token" type="hidden" name="_token" value="<?php echo $_SESSION['token'] ?? '' ?>">
    <div class="form">
        <div class="form__image">
            <input type="file" name="files[]" id="" multiple> <br>
            <?php if(isset($errors['files'])): ?>
                <?php display_error_message_image($errors['files']); ?>
            <?php endif ?>
        </div>
        <div class="form__input">
            <div class="form__input-employer">
                <h3 class="p-10">Employer information</h3>
                <div class="p-10">
                    <p class="fz-11">You are <span class="text-danger">*</span> </p>
                    <div>
                        <?php foreach ($youares as $key => $value) : ?>
                            <label for="<?= $value ?>"><?= ucfirst($value) ?></label>
                            <input type="radio" name="youare" value="<?= $key ?>" id="<?= $value ?>" <?= isset($inputs['youare']) && $inputs['youare'] === $key ? 'checked' : '' ?>>
                        <?php endforeach ?>
                    </div>
                    <small class="error"><?= $errors['youare'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <input type="text" name="company_name" id="company_name" placeholder="Company name" class="border_style w-input company_name" value="<?= $inputs['company_name'] ?? '' ?>">
                    <small class="error"><?= $errors['company_name'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <select name="city" class="form-select form-select-sm mb-3 choose_location" id="city">
                        <option value="">--- Choose a city ---</option>
                        <?php foreach ($cities as $city_code => $name) : ?>
                            <option value="<?= $city_code ?>" <?= isset($inputs['city']) && $inputs['city'] == $city_code ? 'selected' : '' ?>><?= $name ?></option>
                        <?php endforeach ?>
                    </select>

                    <select name="district" class="form-select form-select-sm mb-3 choose_location" id="district">
                        <option value="">--- Choose a district ---</option>
                        <?php if (isset($inputs['district'])) : ?>
                            <?php foreach ($districts as $district_code => $name) : ?>
                                <option value="<?= $district_code ?>" <?= $inputs['district'] == $district_code ? 'selected' : '' ?>><?= $name ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>

                    <select name="ward" class="form-select form-select-sm" id="ward">
                        <option value="">--- Choose a ward ---</option>
                        <?php if (isset($inputs['ward'])) : ?>
                            <?php foreach ($wards as $ward_code => $name) : ?>
                                <option value="<?= $ward_code ?>" <?= $inputs['ward'] == $ward_code ? 'selected' : '' ?>><?= $name ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                    <input type="text" name="address_detail" value="<?= $inputs['address_detail'] ?? ''?>">
                    <small class="error"><?= $errors['address_detail'] ?? '' ?></small>
                </div>
            </div>
            <div class="form__input-job-content">
                <h3>Job posting content</h3>
                <div class="p-10">
                    <input type="text" class="border_style w-input" name="title" placeholder="Title" value="<?= $inputs['title'] ?? '' ?>">
                    <small class="error"><?= $errors['title'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <input type="number" class="border_style w-input" name="hiring_quantity" value="<?= $inputs['hiring_quantity'] ?? '' ?>" placeholder="Number of recruitments">
                    <small class="error"><?= $errors['hiring_quantity'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <select name="career" id="">
                        <option value="">--- Choose a Career ---</option>
                        <?php foreach ($careers as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= isset($inputs['career']) && $inputs['career'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="error"><?= $errors['career'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <select name="type_of_work" id="">
                        <option value="">--- Choose a Type Of Work ---</option>
                        <?php foreach ($typeOfWork as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= isset($inputs['type_of_work']) && $inputs['type_of_work'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="error"><?= $errors['type_of_work'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <select name="payment" id="">
                        <option value="">--- Choose a Payment ---</option>
                        <?php foreach ($payments as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= isset($inputs['payment']) && $inputs['payment'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="error"><?= $errors['payment'] ?? '' ?></small>
                </div>
                <div class="g-col p-10">
                    <input type="number" name="min_salary" value="<?= $inputs['min_salary'] ?? 0 ?>" placeholder="Min salary" class="border_style w45-input">
                    <small class="error"><?= $errors['min_salary'] ?? '' ?></small>
                    <input type="number" name="max_salary" value="<?= $inputs['max_salary'] ?? 0 ?>" placeholder="Max salary" class="border_style w45-input">
                    <small class="error"><?= $errors['max_salary'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <textarea name="content" id="" cols="30" rows="10" class="w-input border-textarea" placeholder="Job description">
                        <?= $inputs['content'] ?? '' ?>
                    </textarea>
                    <small class="error"><?= $errors['content'] ?? '' ?></small>
                </div>
            </div>
            <div class="form__input-info-more">
                <h3>More information</h3>
                <div class="g-col p-10">
                    <input type="number" name="minimal_age" value="<?= $inputs['minimal_age'] ?? '' ?>" placeholder="Min age" class="border_style w45-input">
                    <small class="error"><?= $errors['minimal_age'] ?? '' ?></small>
                    <input type="number" name="maximum_age" value="<?= $inputs['minimal_age'] ?? '' ?>" placeholder="Max age" class="border_style w45-input">
                    <small class="error"><?= $errors['maximum_age'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <p class="fz-11">Gender <span class="text-danger">*</span> </p>
                    <?php foreach ($genders as $key => $value) : ?>
                        <label for="<?= $key ?>"><?= $value ?></label>
                        <input type="radio" name="gender" value="<?= $key ?>" id="<?= $key ?>" <?= isset($inputs['gender']) && $inputs['gender'] === $key ? 'checked' : '' ?>>
                    <?php endforeach ?>
                    <small class="error"><?= $errors['gender'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <select name="minimal_education" id="">
                        <option value="">--- Choose a Minimal Education ---</option>
                        <?php foreach ($levelEducates as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= isset($inputs['minimal_education']) && $inputs['minimal_education'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="error"><?= $errors['minimal_education'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <select name="experience" id="">
                        <option value="">--- Choose a Experience ---</option>
                        <?php foreach ($experiences as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= isset($inputs['experience']) && $inputs['experience'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="error"><?= $errors['experience'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <input type="text" name="certificate_skill" value="<?= $inputs['certificate_skill'] ?? '' ?>" placeholder="Certificate/Skills" class="border_style w-input">
                    <small class="error"><?= $errors['certificate_skill'] ?? '' ?></small>
                </div>
                <div class="p-10">
                    <input type="text" name="benefit" id="benefit" value="<?= $inputs['benefit'] ?? '' ?>" placeholder="Benefit" class="border_style w-input">
                    <small class="error"><?= $errors['benefit'] ?? '' ?></small>
                </div>
            </div>
            <button type="submit" class="btn">Create</button>
        </div>
    </div>
</form>
<script src="http://localhost/tb/ca/assets/js/location.js"></script>
<?php view('footer'); ?>