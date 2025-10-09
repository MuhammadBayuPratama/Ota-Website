<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\product;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class SortingController extends Controller
{
    public function index()
{
    $totalProduct = Kamar::count();
    $totalPengguna = User::count();
    // $totalPeminjamanAktif = Peminjaman::where('status', 'aktif')->count(); // asumsinya status ada
    $statusSistem = 'Aktif'; // bisa juga diambil dari DB jika dinamis

    return view('Pages.Dashboard', compact('totalProduct', 'totalPengguna', 'totalPeminjamanAktif', 'statusSistem'));
}
}
