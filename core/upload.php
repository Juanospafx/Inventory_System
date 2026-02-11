<?php
class Media
{

    public $imageInfo;
    public $fileName;
    public $fileType;
    public $fileTempPath;

    // Rutas de destino
    public $userPath = SITE_ROOT . DS . '..' . DS . 'uploads/users';
    public $productPath = SITE_ROOT . DS . '..' . DS . 'uploads/products';

    public $errors = [];
    public $upload_errors = [
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'Ningún archivo fue subido',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.'
    ];

    // Extensiones permitidas
    public $upload_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    // Para guardar el ID insertado
    public $id;

    /**
     * Comprueba si la extensión es válida
     */
    public function file_ext($filename)
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, $this->upload_extensions);
    }

    /**
     * Valida y prepara un solo archivo de $_FILES
     */
    public function upload($file)
    {
        $this->errors = [];
        if (!$file || !is_array($file) || $file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = $this->upload_errors[$file['error']] ?? "Ningún archivo subido.";
            return false;
        }
        if (!$this->file_ext($file['name'])) {
            $this->errors[] = 'Formato de archivo incorrecto';
            return false;
        }
        $this->imageInfo = getimagesize($file['tmp_name']);
        $this->fileName = basename($file['name']);
        $this->fileType = $this->imageInfo['mime'];
        $this->fileTempPath = $file['tmp_name'];
        return true;
    }

    /**
     * Comprobaciones antes de mover un solo archivo a products
     */
    public function process()
    {
        if (!empty($this->errors)) {
            return false;
        } elseif (empty($this->fileName) || empty($this->fileTempPath)) {
            $this->errors[] = "La ubicación del archivo no está disponible.";
            return false;
        } elseif (!is_writable($this->productPath)) {
            $this->errors[] = "{$this->productPath} debe tener permisos de escritura.";
            return false;
        } elseif (file_exists("{$this->productPath}/{$this->fileName}")) {
            $this->errors[] = "El archivo {$this->fileName} ya existe.";
            return false;
        }
        return true;
    }

    /**
     * Procesa una sola imagen (legacy)
     */
    public function process_media()
    {
        if (
            !empty($this->errors) ||
            empty($this->fileName) ||
            empty($this->fileTempPath) ||
            !is_writable($this->productPath)
        ) {
            $this->errors[] = "Error previo al mover el archivo.";
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
            $this->errors[] = "Error al insertar la imagen en la base de datos.";
        } else {
            $this->errors[] = "Error al mover el archivo a la carpeta de destino.";
        }
        return false;
    }

    /**
     * Inserta registro en media (con descripción opcional)
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
     * Procesa una sola imagen para múltiple subida,
     * permite conservar nombre original y añadir descripción.
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
            $this->errors[] = "Error al insertar la imagen en la base de datos.";
        } else {
            $this->errors[] = "Error al mover el archivo a la carpeta de destino.";
        }
        return false;
    }

    /**
     * Sube múltiples imágenes de $_FILES['campo']
     *
     * @param array $files Estructura de $_FILES['campo']
     * @param array $descriptions Descripciones opcionales
     * @param bool $preserveOriginalName Conservar nombre original
     * @return array Resultados por cada índice: ['id'=>..., 'fileName'=>...] o ['error'=>[...] ]
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
     * Procesa imagen de usuario (similar a legacy process_user)
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
            $this->errors[] = "Error en datos o permisos.";
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
        $this->errors[] = "Error al actualizar la imagen de usuario.";
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
     * Elimina imagen anterior de usuario
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
     * Elimina media de tabla y fichero físico
     */
    public function media_destroy($id, $file_name)
    {
        $this->fileName = $file_name;
        if (!$id || empty($this->fileName)) {
            $this->errors[] = "Faltan datos para eliminación.";
            return false;
        }
        if (delete_by_id('media', $id)) {
            $path = "{$this->productPath}/{$this->fileName}";
            if (file_exists($path))
                unlink($path);
            return true;
        }
        $this->errors[] = "Error al eliminar la entrada de media.";
        return false;
    }

}
?>