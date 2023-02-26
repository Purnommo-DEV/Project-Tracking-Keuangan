<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Exports\CatatanHutang;
use App\Models\DetailKegiatan;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DetailKegiatanController extends Controller
{
    public function detail_kegiatan($slug){
        $kegiatan = Kegiatan::where('slug_nama_kegiatan', $slug)->first();
        $sisa_saldo = Saldo::where('kegiatan_id', $kegiatan->id)->select('sisa_saldo')->first();
        $detail_kegiatan = DetailKegiatan::where('kegiatan_id', $kegiatan->id)->get();
        return view('Admin.Admin-Dashboard.detail_kegiatan', [
            'detail_kegiatan' => $detail_kegiatan, 
            'kegiatan'=>$kegiatan,
            'sisa_saldo'=>$sisa_saldo
        ]);
    }

    public function tambah_detail_kegiatan(Request $request){
        $saldo = Saldo::where('kegiatan_id', $request->kegiatan_id)->select('sisa_saldo')->first();
        if($saldo->sisa_saldo <= 0 ){
            Alert::error('Gagal', 'Saldo anda Rp. 0');
            return back();
        }
        $upload_bukti = new DetailKegiatan();
        $upload_bukti->keterangan = $request->keterangan;
        $upload_bukti->saldo = $saldo->sisa_saldo;
            $upload_bukti->kegiatan_id = $request->kegiatan_id;
            if($request->hasFile('gambar_bukti')){
                $path = 'storage/' . $upload_bukti->gambar_bukti;
                $image  = $request->file('gambar_bukti');
                $store  = $image->store('gambar_bukti', 'public');
                $upload_bukti->gambar_bukti = $store;
            }
        $upload_bukti->save();
    
        Alert::success('Berhasil', 'Uplaod gambar berhasil');
        return back();
    }

    public function ubah_detail_kegiatan(Request $request, $id){
        $piutang = str_replace(['Rp. ', '.', '.'], ['', '', ''], $request->piutang);
        $terbayar = str_replace(['Rp. ', '.', '.'], ['', '', ''], $request->terbayar);
        
        $detail_kegiatan = DetailKegiatan::where('id', $id)->first();
        $saldo = Saldo::where('kegiatan_id', $detail_kegiatan->kegiatan_id)->select('sisa_saldo')->first();
        $detail_kegiatan->piutang = $piutang;
        $detail_kegiatan->terbayar = $terbayar+$detail_kegiatan->terbayar;
        if($detail_kegiatan->terbayar > $piutang){
            Alert::error('Gagal', 'Pembayaran melebihi hutang');
            return back();
        }else if($terbayar <= $piutang){
            $detail_kegiatan->saldo = $saldo->sisa_saldo - $terbayar;
            Saldo::where('kegiatan_id', $detail_kegiatan->kegiatan_id)->update([
                'sisa_saldo' => $saldo->sisa_saldo - $terbayar
            ]);
        }

        if($request->hasFile('gambar_bukti')){
            $path = 'storage/' . $detail_kegiatan->gambar_bukti;
            if (File::exists($path)) {
                File::delete($path);
            }
            $image  = $request->file('gambar_bukti');
            $store  = $image->store('gambar_bukti', 'public');
            $detail_kegiatan->gambar_bukti = $store;
        }
        $detail_kegiatan->keterangan = $request->keterangan;
        $detail_kegiatan->save();
        Alert::success('Berhasil', 'Detail Kegiatan berhasil di ubah');
        return back();
    }

    public function hapus_detail_kegiatan($id){
        $terbayar_detail_kegiatan = DetailKegiatan::where('id', $id)->first();
        $sisa_saldo = Saldo::where('kegiatan_id', $terbayar_detail_kegiatan->kegiatan_id)->first();
        $sisa_saldo->update([
            'sisa_saldo' => $terbayar_detail_kegiatan->terbayar + $sisa_saldo->sisa_saldo
        ]);

        DetailKegiatan::find($id)->delete();
        return response()->json([
            'status' => 1,
            'msg'    => "Catatan berhasil di hapus"
        ]);
    }

    public function export_input(Request $request) {
        // dd($request->all() ) ;
        return Excel::download( new CatatanHutang(), 'Laporan.xlsx');
    }
}
