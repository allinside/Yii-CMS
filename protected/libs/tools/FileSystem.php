<?php


class FileSystem
{

    public static function getUniqFileName($file_name, $file_dir)
    {
        $file_dir  = str_replace("//", "/", $file_dir);
        $path_info = pathinfo($file_name);
        $file_path = tempnam($file_dir, "");

        unlink($file_path);

        $file_path = $file_path . "." . $path_info["extension"];
        $file_name = str_replace($file_dir, "", $file_path);

        return $file_name;
    }


    public static function getFileExtension($file_name)
    {
        $path_info = pathinfo($file_name);
        return strtolower($path_info['extension']);
    }


    public static function deleteDirRecursive($dir_name)
    {
        if (!is_dir($dir_name)) return false;

        $dir_handle = opendir($dir_name);
        
        if (!$dir_handle) return false;

        while(($file = readdir($dir_handle)) !== false)
        {
            if ($file == "." or $file == "..") continue;
           
            if (!is_dir($dir_name."/".$file))
            {
                unlink($dir_name."/".$file);
            } 
            else
            {
                self::deleteDirRecursive($dir_name.'/'.$file);
            }
        }

        rmdir($dir_name);
        closedir($dir_handle);
        return true;
    }


    public static function findSimilarFiles($dir, $file)
    {
        $dir_files     = scandir($dir);
        $similar_files = array();

        foreach ($dir_files as $dir_file)
        {
            if ($dir_file == '.' || $dir_file == '..' || $dir_file == $file) continue;
         
            if (strpos($dir_file, $file) !== false) $similar_files[] = $dir_file;
        }

        return $similar_files;
    }


    public static function isImageExtension($file_path)
    {
        $path_info = pathinfo($file_path);
        $extension = strtolower($path_info['extension']);

        $images_extensions = self::getImagesExtensions();

        return in_array($extension, $images_extensions);
    }


    public static function isImageType($type)
    {
        return in_array($type, self::getImageTypes());
    }


    public static function getImageTypes()
    {
        return array(
            "image/jpeg",
            "image/jpg",
            "image/gif",
            "image/png"
        );
    }


    public static function deleteFileWithSimilarNames($dir, $file)
    {
        $files = array_merge(
            array($file),
            self::findSimilarFiles($dir, $file)
        );

        self::unlinkFiles($dir, $files);
    }


    public static function unlinkFiles($dir, $files)
    {
        foreach ($files as $file)
        {
            $file_path  = $dir . $file;

            if (file_exists($file_path))
            {	
                unlink($file_path);
            }
        }
    }


    public static function getImagesExtensions()
    {
        return array('jpg', 'jpeg', 'png' , 'gif', 'bmp');
    }


    public static function downloadFile($file_path, $orig_file_name)
    {
        if (!file_exists($file_path)) return;

        $path_info = pathinfo($file_path);
        $extension = strtolower($path_info["extension"]);

        $allowed_file_type = self::getAllowedFileTypes();
        if (!isset($allowed_file_type[$extension]))
        {
            return false;
        }

        $mime_type = $allowed_file_type[$extension];
        $file_size = filesize($file_path);

        ob_end_clean();
        ob_end_clean();

        header("Content-Type: {$mime_type}");
        header("Content-Disposition: attachment; filename={$orig_file_name}");
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');
        header("Content-Length: {$file_size}");
        readfile($file_path);
    }


    public static function getAllowedFileTypes()
    {
        return array(
            "pdf"  => "application/pdf",
            "txt"  => "text/plain",
            "html" => "text/html",
            "htm"  => "text/html",
            "exe"  => "application/octet-stream",
            "zip"  => "application/zip",
            "doc"  => "application/msword",
            "xls"  => "application/vnd.ms-excel",
            "ppt"  => "application/vnd.ms-powerpoint",
            "gif"  => "image/gif",
            "png"  => "image/png",
            "jpeg" => "image/jpeg",
            "jpg"  => "image/jpg"
        );
    }
}
