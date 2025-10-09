<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Kamar;

class LandingController extends Controller
{
    public function index()
    {
        $facilities = Fasilitas::all();
        $kamars = Kamar::all();

        return view('landing', [
            'facilities' => $facilities,
            'kamars' => $kamars,
        ]);
    }
    public function allrooms()
    {
        $kamars = Kamar::all();

        return view('allroom', [
            'kamars' => $kamars,
        ]);
    }
}
