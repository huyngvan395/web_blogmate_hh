@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h1>Tạo người dùng</h1>
@stop

@section('content')
<div class="container mt-5 position-relative">
    <form action="{{route('admin.user.create')}}" method="POST" enctype="multipart/form-data">
        <!-- CSRF Token (if needed for Laravel or other frameworks) -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label">Tên</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên" required>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập mail" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
        </div>

        <!-- Avatar Upload Field -->
        <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện</label>
            <div class="file-upload">
                <button type="button" class="btn btn-primary" onclick="document.getElementById('avatar').click();">Chọn ảnh đại diện</button>
                <span id="status">Chưa có ảnh nào được chọn</span>
                <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewImage(event)">
            </div>
            
            <div id="image-preview-container" style="display: none; margin-top: 10px;">
                <label>Ảnh đại diện đã chọn:</label>
                <img id="image-preview" src="" alt="Ảnh đại diện" class="img-thumbnail rounded-circle" style="width:100px; height:100px">
            </div>
        
            @error('avatar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        @isset($success)
        <p class="bg-success text-white pt-2 pb-2 pr-2 pl-2">{{$success}}</p>
        @endisset

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Tạo người dùng</button>
    </form>
</div>

@stop

@section('css')
<style>
    /* .btn-primary {
            background-color: #5271ff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #05e0e9;
        }
        .btn-secondary{
            background: #5271ff;
        }
        .btn-secondary:hover{
            background: #05e0e9;
        }
        .file-upload {
            display: flex;
            align-items: center;
            gap: 10px;
        } */
        .file-upload input[type="file"] {
            display: none;
        }
</style>
@stop

@section('js')
<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    });
    $('#avatar').on('change', function(event) {
        var file = event.target.files[0];
        var fileName = $('#file-name');
        var previewContainer = $('#image-preview-container');
        var previewImage = $('#image-preview');

        // fileName.text(file ? file.name : 'Chưa có ảnh nào được chọn');

        if (file) {
            $('#status').hide();
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImage.attr('src', e.target.result);
                previewContainer.show(); 
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.hide(); 
        }
    });


</script>
@stop