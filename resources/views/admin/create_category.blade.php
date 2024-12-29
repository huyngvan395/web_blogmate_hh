@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h1>Tạo danh mục</h1>
@stop

@section('content')
<div class="container mt-5 position-relative">
    <form action="{{route('admin.category.create')}}" method="POST" enctype="multipart/form-data">
        <!-- CSRF Token (if needed for Laravel or other frameworks) -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="mb-3">
            <label for="name" class="form-label">Danh mục</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên" required>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
            @if(session('success'))
            <p class=" text-success pt-2 pb-2 pr-2 pl-2">{{session('success')}}</p>
            @endisset

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Tạo danh mục</button>
    </form>
</div>
@stop

@section('css')
@stop

@section('js')

@stop