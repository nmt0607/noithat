@extends('layouts.master')
@section('title')
    <title>Danh sách đăng ký nhận tư vấn</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.advise.advise-list')
@endsection