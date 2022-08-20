@extends('layouts.master')
@section('title')
    <title>Danh sách câu hỏi của khách hàng</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.question-customer.question-of-customer')
@endsection