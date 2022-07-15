@extends('layouts.master')
@section('title')
    <title>Tạo mới bài viết</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.news.news-create')
@endsection