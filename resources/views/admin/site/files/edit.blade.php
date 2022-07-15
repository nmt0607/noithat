@extends('layouts.master')
@section('title')
    <title>Sửa Files</title>
@endsection
@section('content')
   @livewire('admin.site.files.file-edit',['file'=>$file])
@endsection