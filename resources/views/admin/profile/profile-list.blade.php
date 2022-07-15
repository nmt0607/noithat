@extends('layouts.master')
@section('title')
    <title>Trang cá nhân</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.profile.profile-list')
@endsection