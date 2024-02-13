@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصفحات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                الملف الشخصي</span>
        </div>
    </div>

</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">

    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">

                <div class="tab-content border-left border-bottom border-right border-top-0 p-4">

                    <div class="tab-pane active" id="settings">
                        <form role="form">
                            <div class="form-group">
                                <label for="FullName">الاسم الكامل</label>
                                <input type="text" value="{{$user->name}}" id="FullName" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="Email">البريد الإلكتروني</label>
                                <input type="email" value="{{$user->email}}" id="Email" class="form-control" disabled>
                            </div>
                            <label>الأدوار</label>
                            @foreach ($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach

                            <div class="form-group">
                                <label for="RePassword">الحالة</label>
                                <input type="text" value="{{$user->Status}}" id="RePassword" class="form-control" disabled>
                            </div>
                            <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('home') }}">رجوع</a>
                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
@endsection
