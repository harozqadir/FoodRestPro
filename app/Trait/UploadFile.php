<?php

namespace App\Trait;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

trait UploadFile{
    public function Uploadfile(Request $request, $field, $folder)
{
    if ($request->hasFile($field)) {
        $file = $request->file($field);
        $name = $file->hashName();
        $file->move(public_path($folder), $name); // ✅ Ensure 'public_path' used!
        return $name;
    }
    return null;
}
}