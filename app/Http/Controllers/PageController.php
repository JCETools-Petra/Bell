<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function terms()
    {
        return view('frontend.pages.terms');
    }

    // TAMBAHKAN METODE BARU INI
    public function affiliateInfo()
    {
        return view('frontend.pages.affiliate_info');
    }
}