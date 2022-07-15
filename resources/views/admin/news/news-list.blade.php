@extends('layouts.master')
@section('title')
    <title>Quản lý tin tức</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.news.news-list')
@endsection