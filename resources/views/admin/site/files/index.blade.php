
@extends('layouts.master')
@section('title')
    <title>Quản lý Files</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.site.files.files-list')
@endsection