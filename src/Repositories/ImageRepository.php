<?php

/**
 * Insert data image
 * @param array $datas
 * @param int $post_id
 * @return 
 */
function insert_image(\PDO $pdo, string $pathImage, int $post_id)
{
    $sql = "INSERT INTO images(path_image, post_id) 
            VALUES (:path_image, :post_id)";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':path_image', $pathImage);
    $statement->bindValue(':post_id', $post_id);

    $statement->execute();
}

/**
 * Get list image by id post
 * @param int $post_id
 * @return array
 */
function get_image_by_post_id(\PDO $pdo, int $post_id): array
{
    $sql = "SELECT path_image
            FROM images
            WHERE post_id=:post_id";
    
    $statement = $pdo->prepare($sql);

    $statement->bindValue(':post_id', $post_id);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}