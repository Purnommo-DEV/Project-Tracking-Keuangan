<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
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
	</style>
</head>
<body>
	@include('sweetalert::alert')
	<div class="wrapper justify-content-center">
    <div class="content">
        <div class="page-inner">
            <div class="row" style="justify-content: center;">
                <div class="col-md-4">
                    <div class="card" style="border-radius: 20px;">
                        <div class="card-header">
                            <h4 class="card-title">Login Admin</h4>
                        </div>
                        <form action="{{route('CekLogin')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default" style="border-radius: 15px;">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="form-group form-group-default" style="border-radius: 15px;">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action d-flex justify-content-center">
                                <button class="btn btn-info btn-sm btn-round">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    
 
</div>
</div>
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

@yield('script')
</body>
</html>