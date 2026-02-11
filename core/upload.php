<?php
class Media
{

    public $imageInfo;
    public $fileName;
    public $fileType;
    public $fileTempPath;

    // Destination paths
    public $userPath = SITE_ROOT . DS . '..' . DS . 'uploads/users';
    public $productPath = SITE_ROOT . DS . '..' . DS . 'uploads/products';

    public $errors = [];
    public $upload_errors = [
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.'
    ];

    // Allowed extensions
    public $upload_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    // Store the inserted ID
    public $id;

    /**
     * Check if the extension is valid
     */
    public function file_ext($filename)
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, $this->upload_extensions);
    }

    /**
     * Validate and prepare a single file from $_FILES
     */
    public function upload($file)
    {
        $this->errors = [];
        if (!$file || !is_array($file) || $file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = $this->upload_errors[$file['error']] ?? "No file uploaded.";
            return false;
        }
        if (!$this->file_ext($file['name'])) {
            $this->errors[] = 'Invalid file format';
            return false;
        }
        $this->imageInfo = getimagesize($file['tmp_name']);
        $this->fileName = basename($file['name']);
        $this->fileType = $this->imageInfo['mime'];
        $this->fileTempPath = $file['tmp_name'];
        return true;
    }

    /**
     * Checks before moving a single file to products
     */
    public function process()
    {
        if (!empty($this->errors)) {
            return false;
        } elseif (empty($this->fileName) || empty($this->fileTempPath)) {
            $this->errors[] = "File location is not available.";
            return false;
        } elseif (!is_writable($this->productPath)) {
            $this->errors[] = "{$this->productPath} must have write permissions.";
            return false;
        } elseif (file_exists("{$this->productPath}/{$this->fileName}")) {
            $this->errors[] = "The file {$this->fileName} already exists.";
            return false;
        }
        return true;
    }

    /**
     * Process a single image (legacy)
     */
    public function process_media()
    {
        if (
            !empty($this->errors) ||
            empty($this->fileName) ||
            empty($this->fileTempPath) ||
            !is_writable($this->productPath)
        ) {
            $this->errors[] = "Error before moving the file.";
            return false;
        }
        $ext = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
        $uniqueName = uniqid("prod_", true) . ".{$ext}";
        $target = "{$this->productPath}/{$uniqueName}";

        if (move_uploaded_file($this->fileTempPath, $target)) {
            $this->fileName = $uniqueName;
            if ($this->insert_media()) {
                global $db;
                $this->id = $db->insert_id();
                unset($this->fileTempPath);
                return true;
            }
            $this->errors[] = "Error inserting image into the database.";
        } else {
            $this->errors[] = "Error moving the file to the destination folder.";
        }
        return false;
    }

    /**
     * Insert media record (with optional description)
     */
    private function insert_media($description = null)
    {
        global $db;
        $fields = "file_name, file_type";
        $values = "'{$db->escape($this->fileName)}', '{$db->escape($this->fileType)}'";
        if ($description !== null) {
            $fields .= ", description";
            $values .= ", '{$db->escape($description)}'";
        }
        $sql = "INSERT INTO media ({$fields}) VALUES ({$values})";
        return ($db->query($sql) && $db->affected_rows() === 1);
    }

    /**
     * Process a single image for multiple upload,
     * allows keeping the original name and adding a description.
     */
    protected function process_media_multi($description, $preserveOriginalName = false)
    {
        if (!empty($this->errors)) {
            return false;
        }
        $ext = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
        $newName = $preserveOriginalName
            ? basename($this->fileName)
            : uniqid("prod_", true) . ".{$ext}";
        $target = "{$this->productPath}/{$newName}";

        if (move_uploaded_file($this->fileTempPath, $target)) {
            $this->fileName = $newName;
            if ($this->insert_media($description)) {
                global $db;
                $this->id = $db->insert_id();
                unset($this->fileTempPath);
                return true;
            }
            $this->errors[] = "Error inserting image into the database.";
        } else {
            $this->errors[] = "Error moving the file to the destination folder.";
        }
        return false;
    }

    /**
     * Upload multiple images from $_FILES['field']
     *
     * @param array $files Structure of $_FILES['field']
     * @param array $descriptions Optional descriptions
     * @param bool $preserveOriginalName Preserve original name
     * @return array Results per index: ['id'=>..., 'fileName'=>...] or ['error'=>[...] ]
     */
    public function uploadMultiple($files, $descriptions = [], $preserveOriginalName = false)
    {
        $results = [];
        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            $fileArr = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            ];
            if ($this->upload($fileArr)) {
                $desc = $descriptions[$i]
                    ?? pathinfo($fileArr['name'], PATHINFO_FILENAME);
                if ($this->process_media_multi($desc, $preserveOriginalName)) {
                    $results[] = ['id' => $this->id, 'fileName' => $this->fileName];
                } else {
                    $results[] = ['error' => $this->errors];
                }
            } else {
                $results[] = ['error' => $this->errors];
            }
        }
        return $results;
    }

    /**
     * Process user image (similar to legacy process_user)
     */
    public function process_user($id)
    {
        if (
            !empty($this->errors) ||
            empty($this->fileName) ||
            empty($this->fileTempPath) ||
            !is_writable($this->userPath) ||
            !$id
        ) {
            $this->errors[] = "Invalid data or permissions.";
            return false;
        }
        $ext = pathinfo($this->fileName, PATHINFO_EXTENSION);
        $newName = randString(8) . $id . '.' . $ext;
        $this->fileName = $newName;

        if (
            $this->user_image_destroy($id)
            && move_uploaded_file($this->fileTempPath, "{$this->userPath}/{$newName}")
            && $this->update_userImg($id)
        ) {
            unset($this->fileTempPath);
            return true;
        }
        $this->errors[] = "Error updating user image.";
        return false;
    }

    /**
     * Actualiza campo image en tabla users
     */
    private function update_userImg($id)
    {
        global $db;
        $sql = "UPDATE users SET image='{$db->escape($this->fileName)}' WHERE id='{$db->escape($id)}'";
        $db->query($sql);
        return ($db->affected_rows() === 1);
    }

    /**
     * Delete previous user image
     */
    public function user_image_destroy($id)
    {
        $image = find_by_id('users', $id);
        if (empty($image['image']) || $image['image'] === 'no_image.jpg') {
            return true;
        }
        $path = "{$this->userPath}/{$image['image']}";
        if (file_exists($path))
            unlink($path);
        return true;
    }

    /**
     * Delete media record and physical file
     */
    public function media_destroy($id, $file_name)
    {
        $this->fileName = $file_name;
        if (!$id || empty($this->fileName)) {
            $this->errors[] = "Missing data for deletion.";
            return false;
        }
        if (delete_by_id('media', $id)) {
            $path = "{$this->productPath}/{$this->fileName}";
            if (file_exists($path))
                unlink($path);
            return true;
        }
        $this->errors[] = "Error deleting media record.";
        return false;
    }

}
?>
