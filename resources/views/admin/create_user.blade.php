@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h1>Người dùng</h1>
@stop

@section('content')

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
$(document).ready(function() {
    $('#table1').DataTable();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.delete-btn').on('click',function() {
        var row = $(this).closest('tr'); 

        if (confirm("Bạn có chắc chắn muốn xóa người dùng không?")) {
            $.ajax({
                url: "/user/delete", 
                type: 'POST', 
                data: {
                    userID: $(this).attr('data-id'),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // alert(response.msg);
                    row.remove();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }}
    )

    $('.detail-btn').on('click', function(){
        // var userId = $(this).attr('data-id');
        var userName = $(this).attr('data-name');
        var userEmail = $(this).attr('data-email');
        var userAvatar = $(this).attr('data-avatar');
        var userCreated = $(this).attr('data-created');

        $('#userName').text(userName);
        $('#userEmail').text(userEmail);
        $('#userCreated').text(userCreated);
        $('#userAvatar').attr('src', userAvatar);
    })
    
    });



</script>
@stop