@extends('layouts.master')
@section('title')
الأقسام
@stop
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto" style="color: #333; font-size: 35px; margin-bottom: 10px;">الإعدادات</h4>
			<span class="text-muted mt-1 tx-13 mr-2 mb-0" style="color: #333; font-size: 25px; margin-bottom: 10px;">/ الأقسام</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- affichage erreur de validation inputs -->
@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
<!-- row -->
<div class="row">
	<!-- condition si l'ajout est affecté -->
	@if(session()->has('Add'))
	<script>
	window.onload = function() {
		notif({
			msg: 'تم اضافة القسم بنجاح',
			type: "success"
		})
	}
</script>
	@endif
	<!-- erreur si la section est deja enregistrer -->
	@if(session()->has('Error'))
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<strong>{{session()->get('Error')}}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif
	<!-- erreur si la modification est reussie-->
	@if(session()->has('edit'))
	<script>
	window.onload = function() {
		notif({
			msg: 'تم تعديل القسم بنجاح',
			type: "success"
		})
	}
</script>
	@endif
	<!-- erreur si la suppression est reussie-->
	@if(session()->has('delete'))
	<script>
	window.onload = function() {
		notif({
			msg: 'تم حذف القسم بنجاح',
			type: "error"
		})
	}
</script>
    @endif

	<div class="col-xl-12">
		<div class="card mg-b-20">
			<div class="card-header pb-0">
				<div class="d-flex justify-content-between">
				@can('اضافة قسم')
					<a class="modal-effect  btn btn-sm btn-primary" data-effect="effect-slide-in-bottom" data-toggle="modal" href="#modaldemo8"><i class="fas fa-plus"></i>&nbsp;اضافة قسم</a>
					@endcan
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example1" class="table key-buttons text-md-nowrap">
						<thead>
							<tr>
								<th style="font-size: 15px; font-weight: bold;">#</th>
								<th style="font-size: 15px; font-weight: bold;">اسم القسم</th>
								<th style="font-size: 15px; font-weight: bold;">الوصف </th>
								<th style="font-size: 15px; font-weight: bold;">العمليات</th>
							</tr>
						</thead>
						<tbody>
							@foreach($sections as $x)
							<tr>
								<td>{{$x->id}}</td>
								<td>{{$x->section_name}}</td>
								<td>{{$x->description}}</td>
								<td>
									@can('تعديل قسم')
									<button class="btn btn-primary btn-sm" data-id="{{ $x->id }}" data-section_name="{{ $x->section_name }}" data-description="{{ $x->description }}" data-toggle="modal" data-target="#exampleModal2">تعديل</button>
									@endcan
									@can('حذف قسم')

									<button class="btn btn-danger btn-sm" data-id="{{ $x->id }}" data-section_name="{{ $x->section_name }}" data-toggle="modal" data-target="#modaldemo9">حذف</button>
									@endcan
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--popup Card add -->
	<div class="modal" id="modaldemo8">
		<div class="modal-dialog" role="document">
			<div class="modal-content modal-content-demo">
				<div class="modal-header">
					<h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<form action="{{ route('sections.store') }}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="exampleInputEmail1">اسم القسم</label>
							<input type="text" class="form-control" id="section_name" name="section_name">
						</div>
						<div class="form-group">
							<label for="exampleFormControlTextarea1">ملاحظات</label>
							<textarea class="form-control" id="description" name="description" rows="3"></textarea>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success">تاكيد</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End popup Card add -->

	</div>
	<!-- row closed -->
	<!-- edit -->
	<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="sections/update" method="post" autocomplete="off">
						{{method_field('patch')}}
						{{csrf_field()}}
						<div class="form-group">
							<input type="hidden" name="id" id="id" value="">
							<label for="recipient-name" class="col-form-label">اسم القسم:</label>
							<input class="form-control" name="section_name" id="section_name" type="text">
						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">ملاحظات:</label>
							<textarea class="form-control" id="description" name="description"></textarea>
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">تاكيد</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End popup Card edit-->
	<!-- delete -->
	<div class="modal" id="modaldemo9">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content modal-content-demo">
				<div class="modal-header">
					<h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<form action="sections/destroy" method="post">
					{{method_field('delete')}}
					{{csrf_field()}}
					<div class="modal-body">
						<p>هل انت متاكد من عملية الحذف ؟</p><br>
						<input type="hidden" name="id" id="id" value="">
						<input class="form-control" name="section_name" id="section_name" type="text" readonly>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
						<button type="submit" class="btn btn-danger">تاكيد</button>
					</div>
			</div>
			</form>
		</div>
	</div>
	<!-- end popup_delete -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<!-- script edit -->
<script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		// recuperer element du lien update
		var id = button.data('id')
		var section_name = button.data('section_name')
		var description = button.data('description')
		var modal = $(this)
		//afficher les valeur recuperer dans les inputs du popup
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
	})
</script>
<!-- script delete -->
<script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('section_name')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
	})
</script>
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection