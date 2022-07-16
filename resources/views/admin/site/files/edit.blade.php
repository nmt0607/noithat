@extends('layouts.master')
@section('title')
    <title>Chỉnh sửa File</title>
@endsection
@section('content')
   @livewire('admin.site.files.file-edit',['file'=>$file])
@endsection