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
                <button class="btn btn-xs btn-default text-danger mx-1 shadow delete-btn" title="Delete"
                    data-id="{{$category->id}}">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>

            </nobr>
        </td>
    </tr>
    @endforeach
</x-adminlte-datatable>

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
        
    
        $('#table1').on('click', '.delete-btn', function() {
        var row = $(this).closest('tr'); 

        if (confirm("Bạn có chắc chắn muốn xóa danh mục này không?")) {
            $.ajax({
                url: "/category/delete", 
                type: 'POST', 
                data: {
                    categoryID: $(this).data('id'),
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
        });
    
    
</script>
@stop