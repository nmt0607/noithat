@extends('layouts.master')
@section('title')
    <title>Test</title>
@endsection
@section('css')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @livewire('admin.test.test-list')
@endsection