@extends('Admin.Layout_Admin.master', ['title'=>'Kegiatan'])
@section('konten')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
        </div>
    </div>
    <div class="page-inner mt--5">
        @if (Auth::user()->role == 1)
        <div class="row mt--2">
            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Daftar Kegiatan</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('TambahKegiatan')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="d-flex flex-wrap justify-content-around pb-2">
                                        <div class="form-group form-group-default">
                                            <label>Nama Kegiatan</label>
                                                <input type="text" name="nama_kegiatan" class="form-control" placeholder="Masukkan Nama Kegiatan" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-wrap justify-content-around pb-2">
                                        <div class="form-group form-group-default">
                                            <label>Total Anggaran</label>
                                                <input type="text" id="anggaran" name="anggaran" class="form-control" placeholder="Masukkan Total Anggaran" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="d-flex flex-wrap justify-content-end">
                                        <button class="btn btn-sm rounded-4 btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ringkasan Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-catatan-hutang" class="display nowrap table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Kegiatan</th>
                                        <th class="text-center">Anggaran</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kegiatan as $data_kegiatan)
                                    <tr>
                                        <td class="text-center">{{$data_kegiatan->nama_kegiatan}}</td>
                                        <td class="text-center">@currency($data_kegiatan->anggaran)</td>
                                        <td class="text-center">{{Carbon\Carbon::parse($data_kegiatan->created_at)->format('d F Y')}}</td>
                                        
                                        <td class="text-center"> 
                                            <div class="form-button-action"> 
                                                @if (Auth::user()->role == 1)
                                                    <button type="button" id="tombol-ubah" onclick="catatanID({{$data_kegiatan->id}})" class="btn btn-link btn-primary btn-lg" data-toggle="modal" 
                                                        data-target="#editCatatan-{{$data_kegiatan->id}}"> 
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" kegiatan-id = "{{$data_kegiatan->id}}" data-toggle="tooltip" title="" 
                                                        class="btn btn-link btn-danger hapus_kegiatan" data-original-title="Remove"> 
                                                        <i class="fa fa-times"></i> 
                                                    </button>
                                                    <a href="{{route('DaftarKegiatan.DetailKegiatan', $data_kegiatan->slug_nama_kegiatan)}}" class="btn btn-link btn-info" data-original-title="Remove"> 
                                                        <i class="fa fa-eye"></i> 
                                                    </a>
                                                @else
                                                <a href="{{route('DaftarKegiatan.DetailKegiatan', $data_kegiatan->slug_nama_kegiatan)}}" class="btn btn-link btn-info" data-original-title="Remove"> 
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                @endif
                                            </div>
                                        </td>

                                        <div class="modal fade" id="editCatatan-{{$data_kegiatan->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-center modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header no-bd">
                                                        <h5 class="modal-title">
                                                            <span class="fw-mediumbold">
                                                                Edit Kegiatan
                                                            </span>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('UbahKegiatan', $data_kegiatan->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label>Nama Kegiatan</label>
                                                                        <textarea name="nama_kegiatan" class="form-control" placeholder="Masukkan Saldo" required>{{$data_kegiatan->nama_kegiatan}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label>Total Anggaran</label>
                                                                        <input type="text" name="anggaran" id="anggaran-{{$data_kegiatan->id}}" value="@currency($data_kegiatan->anggaran)" class="form-control" placeholder="Masukkan Total Anggaran">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer no-bd">
                                                            <button type="submit" class="btn btn-sm btn-primary"">Simpan</button>
                                                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

    $('#table-catatan-hutang').DataTable({
        "pageLength": 10,
        rowReorder: {
            selector: 'td:nth-child(1)'
        },
        responsive: true,
        "bLengthChange" : false, //thought this line could hide the LengthMenu
        order: [[0, 'desc']]
    });

    function catatanID(id){
        var catatan_id = id
        var anggaranEdit = document.getElementById('anggaran-'+catatan_id);
            anggaranEdit.addEventListener('keyup', function(e){
            anggaranEdit.value = formatRupiah(this.value, 'Rp. ');
        });
    }
    /* Fungsi */
    var anggaran = document.getElementById('anggaran');
        anggaran.addEventListener('keyup', function(e){
        anggaran.value = formatRupiah(this.value, 'Rp. ');
    });

    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).on('click', '.hapus_kegiatan', function (event) {
        const id = $(event.currentTarget).attr('kegiatan-id');

        swal({
            title: "Yakin ?",
            text: "Menghapus Data ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {

            if (willDelete) {
                $.ajax({
                url: "/hapus-kegiatan/" + id,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 0) {
                        alert("Gagal Hapus")
                    } else if (response.status == 1) {
                        swal({
                                title: "Berhasil",
                                text: `${response.msg}`,
                                icon: "success",
                                buttons: true,
                                successMode: true,
                            }),
                        setTimeout(function() {location.reload()}, 800);
                        return false;
                    }
                }
                });
            }
        });
    });
</script>
@endsection
