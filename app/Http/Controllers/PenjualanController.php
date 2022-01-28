<?php

namespace App\Http\Controllers;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

use DB;

use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    //
    public function list(Request $request) {
        $limit = $request->input('limit', 0);
        if($limit > 0) {
            return Penjualan::limit($limit)->get();
        }
        
        return Penjualan::get();
    }

    public function detail($id, Request $request) {
        
        return DetailPenjualan::
        join('barang', 'detail_penjualan.kode_barang', '=', 'barang.kode_barang')
        ->where('id_penjualan', 'like', $id)->get();
    }

    public function grafikBulan($month, Request $request) {
        return DB::select("select 
            DAY(tanggal_penjualan) as tgl, count(tanggal_penjualan) as total 
            from penjualan 
            where MONTH(tanggal_penjualan) = ? 
            group by tanggal_penjualan", 
        [$month]);
    }
}
