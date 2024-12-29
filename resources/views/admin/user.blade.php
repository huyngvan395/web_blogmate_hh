@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h1>Người dùng</h1>
@stop

@php
$heads = [
'ID',
'Tên',
['label' => 'Email', 'width' => 40],
['label' => 'Vai trò', 'width' => 10],
['label' => 'Hành động', 'no-export' => true, 'width' => 5],
];
// $btnEdit = '<button id="editBtn" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
    // <i class="fa fa-lg fa-fw fa-pen"></i>
    // </button>';
// $btnDelete = '<button id="deleteBtn" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
    // <i class="fa fa-lg fa-fw fa-trash"></i>
    // </button>';
// $btnDetails = '<button id="detailBtn" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
    // <i class="fa fa-lg fa-fw fa-eye"></i>
    // </button>';
@endphp

@section('content')
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
    @foreach($users as $user)
    <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>
            <div class="d-flex align-item-center">
                @if($user->role== 'admin')
                <span class="bg-success p-1 rounded">{{$user->role}}</span>
                @else
                <span class="bg-primary p-1 rounded">{{$user->role}}</span>
                @endif
            </div>
        </td>
        <td>
            <nobr>
                <button class="btn btn-xs btn-default text-primary mx-1 shadow edit-btn" title="Edit"
                    data-id="{{$user->id}}" data-email="{{$user->email}}" data-name="{{$user->name}}"
                    data-avatar="{{ asset('storage/' . $user->avatar) }}" data-created="{{$user->created_at}}"
                    data-toggle="modal" data-target="#modalUpdateUser">
                    <i class="fa fa-lg fa-fw fa-pen" ></i>
                </button>
                <button class="btn btn-xs btn-default text-danger mx-1 shadow delete-btn" title="Delete"
                    data-id="{{$user->id}}">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>
                <button class="btn btn-xs btn-default text-teal mx-1 shadow detail-btn" title="Details"
                    data-id="{{$user->id}}" data-email="{{$user->email}}" data-name="{{$user->name}}"
                    data-avatar="{{ asset('storage/' . $user->avatar) }}" data-created="{{$user->created_at}}"
                    data-toggle="modal" data-target="#modalInfoUser">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>
            </nobr>
        </td>
    </tr>
    @endforeach
</x-adminlte-datatable>

</div>
{{-- <div id="userDetailsModal" class="modal">
    <div class="modal-content">
        <span id="closeModal" class="close-btn">&times;</span>
        <h2>Thông tin người dùng</h2>
        <p><strong>Tên:</strong> <span id="userName"></span></p>
        <p><strong>Email:</strong> <span id="userEmail"></span></p>
        <div class="d-flex">
            <p><strong>Ảnh đại diện: </strong></p>
            <img id="userAvatar" src="" alt="" class="image-detail">
        </div>
        <p><strong>Ngày tạo:</strong><span id="userCreated"></span></p>
    </div>
</div> --}}

<div class="modal fade" id="modalUpdateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdateUserLabel">Cập nhật thông tin người dùng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateUserForm">
                    <input type="hidden" id="updateUserId" name="userID">
                    <div class="form-group">
                        <label for="updateUserName">Tên</label>
                        <input type="text" class="form-control" id="updateUserName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="updateUserEmail">Email</label>
                        <input type="email" class="form-control" id="updateUserEmail" name="email" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="updateUserAvatar">Ảnh đại diện</label>
                        <input type="file" class="form-control" id="updateUserAvatar" name="avatar">
                    </div> --}}

                    <div class="form-group">
                        <div class="d-flex align-items-center">
                            <label for="avatar" class="form-label">Ảnh đại diện</label>
                            <img id="image-preview" src="" alt="Ảnh đại diện" class="img-thumbnail rounded-circle" style="width:70px; height:70px">
                            
                        </div>
                        <div class="file-upload pt-2">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('avatar').click();">Thay ảnh đại diện</button>
                            <input type="file" id="avatar" name="avatar" accept="image/*" class="d-none">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="update-submit-btn">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

  
  <!-- Modal -->
  <div class="modal fade" id="modalInfoUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Thông tin người dùng</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p><strong>Tên:</strong> <span id="userName"></span></p>
            <p><strong>Email:</strong> <span id="userEmail"></span></p>
            <div class="d-flex">
                <p><strong>Ảnh đại diện: </strong></p>
                <img id="userAvatar" src="" alt="" class="img-thumbnail rounded-circle" style="height: 80px; width: 80px">
            </div>
            <p><strong>Ngày tạo:</strong><span id="userCreated"></span></p>
        </div>
      </div>
    </div>
  </div>
@stop

@section('css')

@stop

@section('js')
<script>
$(document).ready(function() {
    $('#table1').DataTable();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#table1').on('click', '.edit-btn', function() {
        var userId = $(this).data('id');
        var userName = $(this).data('name');
        var userEmail = $(this).data('email');
        var userAvatar = $(this).data('avatar');

        $('#updateUserId').val(userId);
        $('#updateUserName').val(userName);
        $('#updateUserEmail').val(userEmail);
        $('#image-preview').attr('src', userAvatar);
    });

    $('#table1').on('click', '.delete-btn', function() {
        var row = $(this).closest('tr'); 

        if (confirm("Bạn có chắc chắn muốn xóa người dùng không?")) {
            $.ajax({
                url: "/user/delete", 
                type: 'POST', 
                data: {
                    userID: $(this).data('id'),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    row.remove();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    // Gán sự kiện cho nút Details
    $('#table1').on('click', '.detail-btn', function() {
        var userName = $(this).data('name');
        var userEmail = $(this).data('email');
        var userAvatar = $(this).data('avatar');
        var userCreated = $(this).data('created');

        $('#userName').text(userName);
        $('#userEmail').text(userEmail);
        $('#userCreated').text(userCreated);
        $('#userAvatar').attr('src', userAvatar);
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

    $('#updateUserForm').on('submit', function(e) {
        e.preventDefault();  
        var formData = new FormData(this);

        $.ajax({
            url: '/your-backend-endpoint', 
            type: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(response) {
                if (response.success) {
                    alert('Cập nhật thành công!');
                    $('#modalUpdateUser').modal('hide');
                } else {
                    alert('Cập nhật thất bại!');
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra! Vui lòng thử lại sau.');
            }
        });
    });
    
    });

</script>
@stop