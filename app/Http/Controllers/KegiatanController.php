<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Saldo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KegiatanController extends Controller
{
    public function daftar_kegiatan(){
        $kegiatan = Kegiatan::get()->sortByDesc('created_at');
        return view('Admin.Admin-Dashboard.kegiatan', ['kegiatan' => $kegiatan]);
    }

    public function tambah_kegiatan(Request $request){
        $anggaran = str_replace(['Rp. ', '.', '.'], ['', '', ''], $request->anggaran);
        
        $tambah_kegiatan = Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'slug_nama_kegiatan' => Str::slug($request->nama_kegiatan),
            'anggaran' => $anggaran
        ]);
        Saldo::create([
            'kegiatan_id' => $tambah_kegiatan->id,
            'sisa_saldo' => $anggaran
        ]);
        Alert::success('Berhasil', 'Kegiatan berhasil di tambahkan');
        return back();
    }

    public function ubah_kegiatan(Request $request, $id){
        $anggaran = str_replace(['Rp. ', '.', '.'], ['', '', ''], $request->anggaran);
        Kegiatan::where('id', $id)->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'slug_nama_kegiatan' => Str::slug($request->nama_kegiatan),
            'anggaran' => (int)$anggaran
        ]);
        Alert::success('Berhasil', 'Kegiatan berhasil di ubah');
        return back();
    }

    public function hapus_kegiatan($id){
        Kegiatan::find($id)->delete();
        return response()->json([
            'status' => 1,
            'msg'    => "Catatan berhasil di hapus"
        ]);
    }
}