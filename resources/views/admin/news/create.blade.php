@extends('layouts.master')
@section('title')
    <title>Quản lý tin tức</title>
@endsection
@section('content')
    <div class="body-content p-2">
        <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
            <div class="">
                <h4 class="m-0">
                    Tạo mới tin tức
                </h4>
            </div>
            <div class="paginate">
                <div class="d-flex">
                    <div>
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                    </div>

                    <span class="px-2">/</span>

                    <div class="">
                        <a href="{{ route('admin.news.index') }}">Quản lý tin tức</a>
                    </div>
                    <span class="px-2">/</span>
                    <div class="">
                        <div class="disable">Tạo mới tin tức</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card py-2 px-3">
            {{ Form::open(['url' => route('admin.news.store'), 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                @include('admin.news.field', ['errors' => $errors, 'info' => null])
            {{ Form::close() }}
        </div>
    </div>
@endsection

