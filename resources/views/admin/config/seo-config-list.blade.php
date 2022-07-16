@extends('layouts.master')
@section('title')
    <title>Cấu hình SEO</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.config.seo-config-list')
@endsection