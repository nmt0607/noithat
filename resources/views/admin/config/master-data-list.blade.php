
@extends('layouts.master')
@section('title')
    <title>Danh sách cấu hình</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.config.master-data-list')
@endsection