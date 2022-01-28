<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\DetailPenjualan;


use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function persentaseKategori(Request $request) {
        return Barang::selectRaw('kategori, count(kategori) as total')
        ->groupBy('kategori')
        ->get();
    }
}
