@extends('Admin.Layout_Admin.master', ['title'=>'Detail Kegiatan'])
@section('konten')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row mt--2">
            @if (Auth::user()->role == 1)
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Rincian Hari Ini</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('TambahDetailKegiatan')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-wrap justify-content-around pb-2">
                                <div class="form-group form-group-default">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" required>
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Bukti/Gambar Nota</label>
                                    <input type="hidden" name="kegiatan_id" value="{{$kegiatan->id}}" hidden>
                                    <input name="gambar_bukti" class="form-control"
                                    id="gambar-bukti"
                                    accept="image/png, image/jpeg"
                                    type="file"
                                    required>
                                    <img id="preview-GambarBukti"
                                    src="{{ asset('Admin/assets/img/404.jpg') }}"
                                    alt="preview image" width="200"
                                    height="200" style="padding: 5%;">
                                </div>
                            </div>
                            <div class="d-flex flex-wrap justify-content-end">
                                <button class="btn btn-sm rounded-4 btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            
            @if (Auth::user()->role == 1)<div class="col-md-6">@elseif (Auth::user()->role == 2)<div class="col-md-4">@endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Rincian Anggaran</div>
                        </div>
                    </div>
                    @php
                        $total_piutang = \App\Models\DetailKegiatan::where('kegiatan_id', $kegiatan->id)->sum('piutang');
                        $total_terbayar = \App\Models\DetailKegiatan::where('kegiatan_id', $kegiatan->id)->sum('terbayar');
                        $sisa_saldo = \App\Models\Saldo::where('kegiatan_id', $kegiatan->id)->select('sisa_saldo')->first();
                    @endphp
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="avatar avatar-online">
                                <i class="avatar-title rounded-circle border border-white fas fa-money-bill-wave"></i>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Total Anggaran</h6>
                                <span class="text-muted">@currency($kegiatan->anggaran)</span>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Tersisa</h6>
                                <span class="text-muted">@currency($sisa_saldo->sisa_saldo)</span>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                        <div class="d-flex">
                            <div class="avatar avatar-online">
                                <i class="avatar-title rounded-circle border border-white fas fa-money-bill-alt"></i>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Total Piutang</h6>
                                <span class="text-muted">@currency($total_piutang)</span>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                        <div class="d-flex">
                            <div class="avatar avatar-online">
                                <i class="avatar-title rounded-circle border border-white fas fa-money-check-alt"></i>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Total Terbayar</h6>
                                <span class="text-muted">@currency($total_terbayar)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @if (Auth::user()->role == 1)
        </div>
        <div class="row">
        @endif
            @if (Auth::user()->role == 1)<div class="col-md-12"> @elseif (Auth::user()->role == 2)<div class="col-md-8">@endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ringkasan Piutang</h4>
                    </div>
                    <div class="card-body">
                        @if (Auth::user()->role == 1)
                            <form action="{{route('CetakCatatanHutang')}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="validationDefault01" class="form-label">Tanggal Awal</label>
                                        <input type="date" name="tanggal_awal" class="form-control" id="validationDefault01" value="Mark" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationDefault01" class="form-label">Tanggal Akhir</label>
                                        <input type="date" name="tanggal_akhir" class="form-control" id="validationDefault01" value="Mark" required>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-sm mt-4 btn-info" id="validationTooltipUsernamePrepend"><i class="fa fa-print fa-lg"></i></button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <div class="table-responsive">
                            <table id="table-catatan-hutang" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Keterangan</th>
                                        <th>Piutang</th>
                                        <th>Terbayar</th>
                                        <th>Saldo</th>
                                        <th>Tanggal</th>
                                        @if (Auth::user()->role == 1)<th>Aksi</th>@endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail_kegiatan as $data_detail_kegiatan)
                                    <tr>
                                        <td>
                                            <a data-toggle="modal" data-target="#staticBackdrop-{{$data_detail_kegiatan->id}}">
                                                <img src="{{ asset('storage/'.$data_detail_kegiatan->gambar_bukti) }}"
                                                alt="preview image" width="120"
                                                height="120" style="padding: 5%;">
                                            </a>
                                            <div class="modal fade" id="staticBackdrop-{{$data_detail_kegiatan->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="staticBackdropLabel">Gambar/Bukti Preview</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img class="w-100" src="{{ asset('storage/'.$data_detail_kegiatan->gambar_bukti) }}"
                                                        alt="preview image" style="padding: 5%;">
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$data_detail_kegiatan->keterangan}}</td>
                                        <td class="text-nowrap">@currency($data_detail_kegiatan->piutang)</td>
                                        <td class="text-nowrap">@currency($data_detail_kegiatan->terbayar)</td>
                                        @php
                                            $total_terbayar = \App\Models\DetailKegiatan::where('kegiatan_id', $kegiatan->id)->sum('terbayar');
                                            $total_saldo = $kegiatan->anggaran - $total_terbayar;
                                        @endphp
                                        <td class="text-nowrap">@currency($data_detail_kegiatan->saldo)</td>
                                        <td class="text-nowrap">{{Carbon\Carbon::parse($data_detail_kegiatan->created_at)->format('d F Y')}}</td>
                                        @if (Auth::user()->role == 1)
                                        <td> 
                                            <div class="form-button-action"> 
                                                <button type="button" id="tombol-ubah" onclick="catatanID({{$data_detail_kegiatan->id}})" class="btn btn-link btn-primary btn-lg" data-toggle="modal" 
                                                    data-target="#editCatatan-{{$data_detail_kegiatan->id}}"> 
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <div class="modal fade" id="editCatatan-{{$data_detail_kegiatan->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-center modal-md" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header no-bd">
                                                                <h5 class="modal-title">
                                                                    <span class="fw-mediumbold">
                                                                        Ubah Detail Rincian
                                                                    </span>
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('UbahDataDetailKegiatan', $data_detail_kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Keterangan</label>
                                                                                <input type="text" name="keterangan" value="{{$data_detail_kegiatan->keterangan}}" class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group form-group-default">
                                                                                <input type="hidden" name="kegiatan_id" value="{{$data_detail_kegiatan->kegiatan_id}}" hidden>
                                                                                <label
                                                                                    class="btn btn-sm btn-rounded btn-block upload_bukti"
                                                                                    upload-bukti="{{ $data_detail_kegiatan->id }}"
                                                                                    style="background-color: #f3f3f9; color: black;font-weight: bold;">Upload
                                                                                    Upload Gambar Bukti/Nota
                                                                                    <input name="gambar_bukti"
                                                                                        id="gambar-bukti{{ $data_detail_kegiatan->id }}"
                                                                                        accept="image/png, image/jpeg"
                                                                                        type="file"
                                                                                        style="display: none;"
                                                                                        name="image">
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group form-group-default">
                                                                                    <label>Bukti/Gambar terbaru</label>
                                                                                    <img id="preview-Bukti-{{ $data_detail_kegiatan->id }}"
                                                                                        src="{{ asset('Admin/assets/img/404.jpg') }}"
                                                                                        alt="preview image"width="200"
                                                                                        height="200" style="padding: 5%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group form-group-default">
                                                                                    <label>Bukti/Gambar sebelumnya</label>
                                                                                    <img src="{{ asset('storage/'.$data_detail_kegiatan->gambar_bukti) }}"
                                                                                        alt="preview image" width="200"
                                                                                        height="200" style="padding: 5%;">
                                                                                </div>
                                                                            </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Piutang</label>
                                                                                <input type="text" name="piutang" id="utang-awal-{{$data_detail_kegiatan->id}}" class="form-control" 
                                                                                @if ($data_detail_kegiatan->piutang == null)
                                                                                    value=""
                                                                                @else
                                                                                    value="@currency($data_detail_kegiatan->piutang)"
                                                                                @endif
                                                                                 placeholder="Masukkan Piutang" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group form-group-default">
                                                                                <label>Terbayar Sebelumnya</label>
                                                                                <input type="text" name="terbayar" value="@currency($data_detail_kegiatan->terbayar)" id="bayar-utang-{{$data_detail_kegiatan->id}}" class="form-control" placeholder="Masukkan Terbayar" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer no-bd">
                                                                    <button type="submit" class="btn btn-sm btn-primary"">Simpan</button>
                                                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                                                                </div>
                                                            </form>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                                    style="width: 0%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" detail-kegiatan-id = "{{$data_detail_kegiatan->id}}" data-toggle="tooltip" title="" 
                                                    class="btn btn-link btn-danger hapus_detail_kegiatan" data-original-title="Remove"> 
                                                    <i class="fa fa-times"></i> 
                                                </button>
                                            </div>
                                        </td>
                                        @endif
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
    });

    function catatanID(id)
    {
        var catatan_id = id
        var utang_awal = document.getElementById('utang-awal-'+catatan_id);
        var bayar_utang = document.getElementById('bayar-utang-'+catatan_id);

        utang_awal.addEventListener('keyup', function(e)
            {
                utang_awal.value = formatRupiah(this.value, 'Rp. ');
            });
        bayar_utang.addEventListener('keyup', function(e)
            {
                bayar_utang.value = formatRupiah(this.value, 'Rp. ');
            });
    }
    /* Fungsi */
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


    $(document).ready(function (e) {
        $("#gambar-bukti").change(function () {

            let file = this.files[0];
            // console.log(file);
            let reader = new FileReader();

            if (file['size'] < 2111775) {
                reader.onload = (e) => {
                    $("#preview-GambarBukti").attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                swal({
                    title: "Error",
                    text: "File gambar KTP terlalu besar",
                    icon: "error",
                    dangerMode: true,
                })
                $("#gambar-bukti").val(null);
            }

        });
    });

    $('.upload_bukti').click(function () {
        var id = $(this).attr('upload-bukti');

        $(document).ready(function (e) {
            $("#gambar-bukti" + id).change(function () {

                let file = this.files[0];
                // console.log(file);
                let reader = new FileReader();

                if (file['size'] < 2111775) {
                    reader.onload = (e) => {
                        $("#preview-Bukti-" + id).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                    $(".button_upload").removeAttr("hidden");
                } else {
                    swal({
                        title: "Error",
                        text: "File gambar terlalu besar ",
                        icon: "error",
                        dangerMode: true,
                    })
                    $("#gambar-bukti" + id).val(null);
                    $(".button_upload").attr("hidden", false);
                    // $('#preview-KTP').attr('src', '')
                }

            });
        });
    })    

    $(document).on('click', '.hapus_detail_kegiatan', function (event) {
        const id = $(event.currentTarget).attr('detail-kegiatan-id');

        swal({
            title: "Yakin ?",
            text: "Menghapus Data ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {

            if (willDelete) {
                $.ajax({
                url: "/hapus-detail-kegiatan/" + id,
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
