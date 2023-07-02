@extends('layouts.master')
@section('title')
    <title>Quản lý sản phẩm</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.product-form', ['editId' => $id??''])
@endsection