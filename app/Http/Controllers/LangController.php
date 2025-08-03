<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['en', 'ar', 'ckb'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
