@extends('layouts.base')
@section('title')
    <title>Chi tiết tin tức</title>
@endsection
@section('content')
    @livewire('client.news-detail', ['newsId' => $id])
@endsection