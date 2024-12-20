@extends('adminlte::page')

@section('title', 'Category Management')

@section('content_header')
<h1>Category</h1>
@stop

@php
$heads = [
'ID',
'Tên',
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
    @foreach($categories as $category)
    <tr>
        <td>{{$category->id}}</td>
        <td>{{$category->name}}</td>
        {{-- <td>{{$user->email}}</td> --}}
        <td>
            <nobr>
                {{-- <button class="btn btn-xs btn-default text-primary mx-1 shadow edit-btn" title="Edit"
                    data-id="{{$user->id}}" data-email="{{$user->email}}" data-name="{{$user->name}}"
                    data-avatar="{{ asset('storage/' . $user->avatar) }}" data-created="{{$user->created_at}}">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button> --}}
                <button class="btn btn-xs btn-default text-danger mx-1 shadow delete-btn" title="Delete"
                    data-id="{{$category->id}}">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>
                {{-- <button class="btn btn-xs btn-default text-teal mx-1 shadow detail-btn" title="Details"
                    data-id="{{$user->id}}" data-email="{{$user->email}}" data-name="{{$user->name}}"
                    data-avatar="{{ asset('storage/' . $user->avatar) }}" data-created="{{$user->created_at}}"
                    data-toggle="modal" data-target="#modalInfoUser">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button> --}}
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
  
  <!-- Modal -->
  {{-- <div class="modal fade" id="modalInfoUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Thông tin danh mục</h5>
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
        </div> --}}
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      {{-- </div>
    </div>
  </div> --}}
@stop

@section('css')
{{-- .model{
    display: flex !important;
    height: 100% !important;
    width: 100% !important;
    background-color: black !important;
    opacity: 0.5 !important;
    justify-content: center !important;
    align-items: center !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
} --}}

{{-- .model-content{
    background-color: white !important;
}
.image-detail{
    border-width:1px !important;
    border-radius:100% !important;
    height: 25px !important;
    width:25px !important;
} --}}
@stop

@section('js')
<script>
// $(document).ready(function() {
//     $('#table1').DataTable();

//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     $('.delete-btn').on('click',function() {
//         var row = $(this).closest('tr'); 

//         if (confirm("Bạn có chắc chắn muốn xóa người dùng không?")) {
//             $.ajax({
//                 url: "/user/delete", 
//                 type: 'POST', 
//                 data: {
//                     userID: $(this).attr('data-id'),
//                     _token: '{{ csrf_token() }}'
//                 },
//                 success: function(response) {
//                     // alert(response.msg);
//                     row.remove();
//                 },
//                 error: function(xhr, status, error) {
//                     console.error(xhr.responseText);
//                 }
//             });
//         }}
//     )

//     $('.detail-btn').on('click', function(){
//         // var userId = $(this).attr('data-id');
//         var userName = $(this).attr('data-name');
//         var userEmail = $(this).attr('data-email');
//         var userAvatar = $(this).attr('data-avatar');
//         var userCreated = $(this).attr('data-created');

//         $('#userName').text(userName);
//         $('#userEmail').text(userEmail);
//         $('#userCreated').text(userCreated);
//         $('#userAvatar').attr('src', userAvatar);
//     })
    
//     });



</script>
@stop