<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Menampilkan halaman Terms of Service.
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('legal.terms_of_service');
    }
    public function policy()
    {
        return view('legal.privacy_policy');
    }
}