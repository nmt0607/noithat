@extends('layouts.master')
@section('title')
    <title>Cấu hình chung</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.master-data-list')
@endsection