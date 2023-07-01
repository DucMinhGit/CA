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
    ?string $benefit,
    ?string $certificate_skill,
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

/**
 * Get title post by id
 * @param object PDO
 * @param int $post_id
 * @return string
 * 
 */
function get_title_post_by_id(\PDO $pdo, string $post_id) 
{
    $sql = "SELECT title
            FROM posts
            WHERE id=:id";
    
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $post_id);
    $statement->execute();

    return $statement->fetchColumn();
}

/**
 * Get post by id
 * @param \PDO $pdo
 * @param int $post_id
 * @return array 
 */
function get_post_by_id(\PDO $pdo, int $post_id): array
{
    $sql = "SELECT company_name, title, address, content, 
                    payment, career, gender, hiring_quantity,
                    minimal_education, minimal_age, maximum_age, 
                    type_of_work, user_id, experience, benefit, certificate_skill, 
                    min_salary, max_salary, negotiate
            FROM posts
            WHERE id=:post_id";
    
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':post_id', $post_id);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}