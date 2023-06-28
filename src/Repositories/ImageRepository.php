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
