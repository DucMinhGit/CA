<?php

/**
 *  Messages associated with the upload error code
 */
const MESSAGES = [
    UPLOAD_ERR_OK => 'File uploaded successfully',
    UPLOAD_ERR_INI_SIZE => 'File is too big to upload',
    UPLOAD_ERR_FORM_SIZE => 'File is too big to upload',
    UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
    UPLOAD_ERR_NO_FILE => 'No file was uploaded',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder on the server',
    UPLOAD_ERR_CANT_WRITE => 'File is failed to save to disk.',
    UPLOAD_ERR_EXTENSION => 'File is not allowed to upload to this server',
    /**
     * Message error upload image
     */
    'file_not_exist' => 'Invalid file upload operation',
    'mime_type' => "The image is allowed to upload",
    'move_file' => "The image was failed to move.",
    'err_salary' => 'The minimum salary must be lower than the maximum salary',
    'err_age' => 'The minimum age must be lower than the maximum age',
    'create_error' => 'Created post failed, Please come back in a few minutes, or contact the administrator for assistance!',
    'warning_form' => 'Request is not allowed, you need to reload the page to continue!',
];

/**
 * Return a mime type of file or false if an error occurred
 *
 * @param string $filename
 * @return string | bool
 */
function get_mime_type(string $filename)
{
    $info = finfo_open(FILEINFO_MIME_TYPE);
    if (!$info) {
        return false;
    }

    $mime_type = finfo_file($info, $filename);
    finfo_close($info);

    return $mime_type;
}

/**
 * Return a human-readable file size
 *
 * @param int $bytes
 * @param int $decimals
 * @return string
 */
function format_filesize(int $bytes, int $decimals = 2): string
{
    $units = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $units[(int)$factor];
}
