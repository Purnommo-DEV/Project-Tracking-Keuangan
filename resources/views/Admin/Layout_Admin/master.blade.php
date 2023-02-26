<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('Frontend/assets/images/logo.jpeg')}}" type="image/x-icon"/>
	{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" /> --}}

	
	<!-- Fonts and icons -->
	<script src="{{ asset('Admin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Nunito", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{asset('Admin/assets/css/fonts.min.css')}}"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('Admin/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('Admin/assets/css/atlantis.min.css') }}">
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('Admin/assets/css/demo.css') }}">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
	

	<style>
		* {
            font-family: 'Nunito';
        }
		.modal-body {
			overflow : auto;
		}
        .container{
            margin: 0 auto;
            width: 90%;
        }
        .main_view{
            width: 80%;
            height: 25rem;
        }
        .main_view img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .side_view{
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .side_view img{
            width: 9rem;
            height: 7rem;
            object-fit: cover;
            cursor: pointer;
            margin:0.5rem;
        }
	</style>
</head>
<body>
	@include('sweetalert::alert')
	<div class="wrapper">
		<div class="main-header">

			<!-- Logo Header -->
			<!-- End Logo Header -->

			<!-- Navbar Header -->
            @include('Admin.Layout_Admin.navbar')
			<!-- End Navbar -->

		</div>
		<!-- Sidebar -->
            @include('Admin.Layout_Admin.sidebar')
        <!-- End Sidebar -->

		<div class="main-panel" data-background-color="bg2">
            @yield('konten')
        
			<div class="modal fade" id="ubahPassword" tabindex="-1" aria-labelledby="ubahPasswordLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title fs-5 form-label" id="ubahPasswordLabel">Edit Password</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form class="forms-sample" id="form-EditPassword" method="post" action="{{route('UbahPassword')}}">
								@csrf
								<div class="form-group">
									<div class="col">
										<label for="validationCustom01" class="form-label" style="font-size: medium;">Password
											Lama</label>
										<div class="input-group has-validation">
											<input name="passwordlama" type="password" class="form-control" id="passwordlama" />
											<span class="input-group-text" onclick="password_show_hide1();">
												<i class="fas fa-eye" id="show_eye"></i>
												<i class="fas fa-eye-slash d-none" id="hide_eye"></i>
											</span>
											<div class="input-group has-validation">
												<label class="text-danger error-text passwordlama_error"></label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col">
										<label for="validationCustom01" class="form-label" style="font-size: medium;">Password
											Baru</label>
										<div class="input-group has-validation">
											<input name="password" type="password" class="input form-control" id="password" />
											<span class="input-group-text" onclick="password_show_hide2();">
												<i class="fas fa-eye" id="show_eye2"></i>
												<i class="fas fa-eye-slash d-none" id="hide_eye2"></i>
											</span>
											<div class="input-group has-validation">
												<label class="text-danger error-text password_error"></label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col">
										<label for="validationCustom01" class="form-label" style="font-size: medium;">Konfirmasi
											Password Baru</label>
										<div class="input-group has-validation">
											<input name="konfirmasipasswordbaru" type="password" class="input form-control"
												id="konfirmasipasswordbaru" />
											<span class="input-group-text" onclick="password_show_hide3();">
												<i class="fas fa-eye" id="show_eye3"></i>
												<i class="fas fa-eye-slash d-none" id="hide_eye3"></i>
											</span>
											<div class="input-group has-validation">
												<label class="text-danger error-text konfirmasipasswordbaru_error"></label>
											</div>
										</div>
									</div>
								</div>
								<div class="col pt-3">
									<button type="submit" class="btn btn-dark mr-2 btn-block py-3"
										style="border: none;background: #007bda;border-radius: 20px;">Simpan</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

        <!-- Footer -->
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul class="nav">
							<li class="nav-item">
								<a style="color:white;" class="nav-link" href="https://www.themekita.com">
									ThemeKita
								</a>
							</li>
							<li class="nav-item">
								<a style="color:white;" class="nav-link" href="#">
									Help
								</a>
							</li>
							<li class="nav-item">
								<a style="color:white;" class="nav-link" href="#">
									Licenses
								</a>
							</li>
						</ul>
					</nav>
					<div style="color:white;" class="copyright ml-auto">
						2018, made with <i class="fa fa-heart heart text-danger"></i> by <a style="color:white;" href="https://www.themekita.com">ThemeKita</a>
					</div>				
				</div>
			</footer>
        <!-- End Footer -->
		</div>
		
		<!-- Custom template | don't include it in your project! -->
            @include('Admin.Layout_Admin.custom_template')
		<!-- End Custom template -->
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('Admin/assets/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('Admin/assets/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('Admin/assets/js/core/bootstrap.min.js') }}"></script>
	<!-- jQuery UI -->
	<script src="{{ asset('Admin/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('Admin/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
	
	<!-- jQuery Scrollbar -->
	<script src="{{ asset('Admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
	<!-- Datatables -->
	<script src="{{ asset('Admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>
	
	{{-- <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script> --}}
	{{-- <script src="https://www.ksia.or.kr/plugin/DataTables-1.10.15/extensions/Responsive/js/responsive.bootstrap4.js"></script> --}}

	<!-- Atlantis JS -->
	<script src="{{ asset('Admin/assets/js/atlantis.min.js') }}"></script>
	<script src="{{ asset('Admin/assets/js/canvasjs.min.js') }}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	
	<script src="{{ asset('Admin/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
	<script src="{{ asset('Admin/assets/js/setting-demo2.js') }}"></script>
	<script src="{{asset('Admin/assets/plugins/ckeditor/ckeditor.js')}}"></script>
	<script src="{{asset('Admin/assets/plugins/validate/jquery.validate.min.js')}}"></script>
	{{-- <script type="text/javascript" src="https://rawgit.com/ckeditor/ckeditor-releases/master/ckeditor.js"></script> --}}
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> --}}
	<script>
		CKEDITOR.replaceAll('.ckeditor');
	</script>
	<script>
		$(function(){
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	<script>

	$('#form-EditPassword').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                // $(document).find('span.error-text').text('');
                $(document).find('label.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $('label.' + prefix + '_error').text(val[0]);
                        // $('span.'+prefix+'_error').text(val[0]);
                    });
                } else {
                    $('#form-EditPassword')[0].reset();
                    // alert(data.msg);
                    swal("Berhasil!", data.msg, "success");

					$("#ubahPassword").modal('hide')
						setTimeout(function() {location.reload()}, 800);
						return false;
                }
            }
        });
    });

	function password_show_hide1() {
        var x = document.getElementById("passwordlama");
        var show_eye = document.getElementById("show_eye");
        var hide_eye = document.getElementById("hide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }

    function password_show_hide2() {
        var x = document.getElementById("password");
        var show_eye = document.getElementById("show_eye2");
        var hide_eye = document.getElementById("hide_eye2");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }

    function password_show_hide3() {
        var x = document.getElementById("konfirmasipasswordbaru");
        var show_eye = document.getElementById("show_eye3");
        var hide_eye = document.getElementById("hide_eye3");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }
	</script>
	
	@yield('script')
</body>
</html>