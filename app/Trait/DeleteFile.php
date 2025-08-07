<?php


namespace App\Trait;

trait DeleteFile{
public function DeleteFile($file_path)
{
    if(is_file($file_path) && file_exists($file_path)){
    unlink($file_path);
}
  
}
}
