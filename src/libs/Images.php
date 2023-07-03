<?php

const ALLOWED_FILES = [
    'image/png' => 'png',
    'image/jpeg' => 'jpg'
];

const MAX_SIZE = 5 * 1024 * 1024; // 5MB

/**
 * validate image
 * @param array $file
 * @param array $allowed_files
 * @param string $upload_dir
 * @param int $max_size
 * @return array
 */
function validation_image(
    array $files,
    array $allowed_files = ALLOWED_FILES,
    int $max_size = MAX_SIZE
): array | bool {
    $errors = [];

    $file_count = count($files['name']);

    // validation
    for ($i = 0; $i < $file_count; $i++) {
        // get the upload file info
        $status = $files['error'][$i];
        $filename = $files['name'][$i];
        $tmp = $files['tmp_name'][$i];

        if ($status !== UPLOAD_ERR_OK) {
            if ($status === UPLOAD_ERR_NO_FILE) {
                return false;
            } else {
                $errors[$filename] = MESSAGES[$status];
                continue;
            }
        }

        // validate the file size
        $filesize = filesize($tmp);

        if ($filesize > MAX_SIZE) {
            // construct an error message
            $message = sprintf(
                "The file %s is %s which is greater than the allowed size %s",
                $filename,
                format_filesize($filesize),
                format_filesize(MAX_SIZE)
            );

            $errors[$filename] = $message;
            continue;
        }

        // validate the file type
        if (!in_array(get_mime_type($tmp), array_keys(ALLOWED_FILES))) {
            $errors[$filename] = MESSAGES['mime_type'];
        }
    }

    return $errors;
}

/**
 * move file upload 
 * @param array $files
 */
function move_file_image(array $files, string $upload_dir = __DIR__): bool
{
    $file_count = count($files['name']);

    for ($i = 0; $i < $file_count; $i++) {
        $filename = $files['name'][$i];
        $tmp = $files['tmp_name'][$i];
        $file_type = get_mime_type($tmp);

        $upload_file = time() . '-' . pathinfo($filename, PATHINFO_FILENAME) . '.' . ALLOWED_FILES[$file_type];

        $filepath = $upload_dir . '/' . $upload_file;

        $pathImage[] = $filepath;
        $success = move_uploaded_file($tmp, $filepath);

        if ($success) {
            $_SESSION['pathImage'][] = '/uploads/' . $upload_file;
        } else {
            return false;
        }
    }

    return true;
}
