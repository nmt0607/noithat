
@extends('layouts.master')
@section('title')
    <title>Cấu hình trang</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.config.site-config-list')
@endsection