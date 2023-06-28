<?php

/**
 * Insert data post
 * @return bool
 */
function insert_post(
    \PDO $pdo,
    string $company_name,
    string $title,
    string $address,
    string $content,
    int $payment,
    int $career,
    string $gender,
    int $hiring_quantity,
    int $minimal_education,
    int $minimal_age,
    int $maximum_age,
    int $type_of_work,
    int $user_id,
    int $experience,
    string $benefit,
    string $certificate_skill = NULL,
    int $min_salary = 0,
    int $max_salary = 0,
    int $negotiate = 0,
) {
    $sql = "INSERT INTO posts(company_name, title, address, content, 
                            payment, career, gender, hiring_quantity,
                            minimal_education, minimal_age, maximum_age, 
                            type_of_work, user_id, experience, benefit, certificate_skill, 
                            min_salary, max_salary, negotiate)
            VALUES (:company_name, :title, :address, :content, 
                    :payment, :career, :gender, :hiring_quantity,
                    :minimal_education, :minimal_age, :maximum_age, 
                    :type_of_work, :user_id, :experience, :benefit, :certificate_skill, 
                    :min_salary, :max_salary, :negotiate)";

    $fields = [
        'company_name', 'title', 'address', 'content',
        'payment', 'career', 'gender', 'hiring_quantity',
        'minimal_education', 'minimal_age', 'maximum_age',
        'type_of_work', 'user_id', 'experience', 'benefit', 'certificate_skill',
        'min_salary', 'max_salary', 'negotiate'
    ];

    $statement = $pdo->prepare($sql);

    foreach ($fields as $field) {
        $statement->bindParam(':' . $field, $$field);
    }

    $statement->execute();

    return $pdo->lastInsertId();
}
