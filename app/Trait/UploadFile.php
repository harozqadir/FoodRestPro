<?php

namespace App\Trait;
trait UploadFile{
    public function Uploadfile($request,$name,$folder_name){
        $name_of_file = $request->file($name)->hashName();
       $request->file($name)->move($folder_name,$name_of_file);
        return $name_of_file;
    }
}