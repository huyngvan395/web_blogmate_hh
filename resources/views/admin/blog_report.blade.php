@extends('adminlte::page')

@section('title', 'Blog Management')

@section('content_header')
<h1>Blog</h1>
@stop

@php
$heads = [
'ID',
'Tiêu đề',
['label' => 'Tác giả', 'width' => 40],
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
    @foreach($blogs as $blog)
    <tr>
        <td>{{$blog->id}}</td>
        <td>{{$blog->title}}</td>
        <td>{{$blog->user->name}}</td>
        <td>
            <nobr>
                {{-- <button class="btn btn-xs btn-default text-primary mx-1 shadow edit-btn" title="Edit"
                    data-id="{{ $blog->id }}">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button> --}}
                <button class="btn btn-xs btn-default text-danger mx-1 shadow delete-btn" title="Delete"
                    data-id="{{ $blog->id }}">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>
                <button class="btn btn-xs btn-default text-teal mx-1 shadow detail-btn" title="Details"
                    data-id="{{ $blog->id }}" data-title="{{$blog->title}}" data-content="{{$blog->content}}"
                    data-author-name="{{$blog->user->name}}" 
                    data-author-image="{{asset('storage/'.$blog->user->avatar)}}"
                    data-toggle="modal" data-target=".bd-example-modal-lg">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>
            </nobr>
        </td>
    </tr>
    @endforeach
</x-adminlte-datatable>
<div class="modal fade bd-example-modal-lg" id="modalInfoUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="blog-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="d-flex align-items-center pt-3 pl-3">
            <img id="author-image" src="" alt="" class="rounded-circle" style="height: 30px; width: 30px">
            <p id="author-name" class="m-0 p-0 pl-3"></p>
        </div>
        <div class="modal-body">
            <div id="blogContent" class="trix-content" style="overflow-y: scroll;height: 400px;">
            </div>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<style>
    .trix-content {
    width: 100%;
  }

  .trix-content h1 {
      font-size: 2rem !important;
      line-height: 1.25rem !important;
      margin-bottom: 1.5rem;
      margin-top: 1.5rem;
      font-weight: 600;
  }
  .trix-content{
    font-size: 1.1rem;
  }
  
  .trix-content a:not(.no-underline) {
      text-decoration: underline;
  }
  
  .trix-content a:visited {
      color: green;
  }
  
  .trix-content ul {
      list-style-type: disc;
      padding-left: 1rem;
  }
  
  .trix-content ol {
      list-style-type: decimal;
      padding-left: 1rem;
  }
  
  .trix-content pre {
      display: inline-block;
      width: 100%;
      vertical-align: top;
      font-family: monospace;
      font-size: 1.5em;
      padding: 0.5em;
      white-space: pre;
      background-color: #eee;
      overflow-x: auto;
  }
  
  .trix-content blockquote {
      border: 0 solid #ccc;
      border-left-width: 0.3em;
      margin-left: 0.3em;
      padding-left: 0.6em;
      font-style: italic;
  }
.trix-content figure.attachment {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin: 0;
  padding: 0;
  width: 100%;
}

.trix-content figure.attachment img {
  display: block;
  max-width: 70%;
  height: 400px;
  margin: 4px 0px 0px 0px;
}

@media (max-width:640px){
  .trix-content figure.attachment img {
    display: block;
    max-width: 90%;
    height: 270px;
    margin: 4px 0px 0px 0px;
  }
}

.trix-content figure.attachment a{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.trix-content figure.attachment figcaption.attachment__caption {
  padding: 3px;
  width: 80%;
  font-style: italic; /* Định dạng tùy ý cho chú thích */
  color: #666;
  text-align: center;
  margin-bottom: 4px;
}

.trix-content figure.attachment figcaption.attachment__caption textarea.attachment__caption-editor{
  overflow: hidden;
  border: none;
  box-shadow: none;
}
</style>
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!"); 
     $(document).ready(function() {
    $('#table1').DataTable();

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    $('.delete-btn').on('click',function() {
        var row = $(this).closest('tr'); 

        if (confirm("Bạn có chắc chắn muốn xóa blog?")) {
            $.ajax({
                    url: "/blog/delete", // URL đến route
                    type: 'POST', // Phương thức HTTP
                    data: {
                        blogID: $(this).attr('data-id'),
                        _token: '{{ csrf_token() }}' // Thêm CSRF token
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

    $('.detail-btn').on('click', function() {
        var blogTitle=$(this).attr('data-title');
        var blogContent=$(this).attr('data-content');
        var authorImage=$(this).attr('data-author-image');
        var authorName=$(this).attr('data-author-name');
        
        $('#blog-title').text(blogTitle);
        $('#author-name').text(authorName);
        $('#author-image').attr('src', authorImage);
        $('#blogContent').html(blogContent);

    })
});
</script>
@stop