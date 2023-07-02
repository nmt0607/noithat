@extends('layouts.base')
@section('title')
    <title>Chi tiết sản phẩm</title>
@endsection
@section('content')
    @livewire('client.product-detail', ['productId' => $id])
@endsection