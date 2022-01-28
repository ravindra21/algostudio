<?php

namespace App\Http\Controllers\Views;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;


use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    //
    public function index(Request $request) {
        return view('dashboard.master-penjualan');
    }
}
