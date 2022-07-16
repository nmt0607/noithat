@extends('layouts.master')
@section('title')
    <title>Câu hỏi thường gặp</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.faqs.faqs-list')
@endsection