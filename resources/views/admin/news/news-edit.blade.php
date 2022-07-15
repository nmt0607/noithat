@extends('layouts.master')
@section('title')
    <title>Chỉnh sửa bài viết</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.news.news-edit',['editId'=>$id])
@endsection