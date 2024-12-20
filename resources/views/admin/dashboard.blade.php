@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Trang chính</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <x-adminlte-small-box title="{{$allUsers->count()}}" text="Người dùng" icon="fas fa-user" theme="primary" url="/admin/user"
        url-text="Xem tất cả" />
    </div>
    <div class="col-md-6">
        <x-adminlte-small-box title="{{$allBlogs->count()}}" text="Blog" icon="fas fa-newspaper" theme="red" url="/admin/blog"
        url-text="Xem tất cả" />
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <canvas id="myChart1" style="max-width: 100%; height: 300px;"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="myChart2" style="max-width: 100%; height: 300px;"></canvas>
    </div>
</div>
<div class="row">
    <div class="d-flex flex-column col-6 shadow rounded-sm p-2">
        <div class="d-flex justify-content-start">
            <h3 class="p-2">Những thành viên mới</h3>
        </div>
        <div class="row">
            @foreach($latestUsers as $user)
            <div class="col-md-3 d-flex flex-column justify-content-center align-items-center">
                <img src="{{asset('storage/'.$user->avatar)}}" alt="" class="rounded-circle" style="width:3rem; height:3rem">
                <p class="text-truncate text-nowrap">{{$user->name}}</p>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{route('admin.user')}}" class="text-primary">Xem tất cả người dùng</a>
        </div>
    </div>
    <div class="col-6">
        
    </div>
</div>

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!"); 
    document.addEventListener("DOMContentLoaded", function () {
    const blogs= @json($blogsData);
    const users=@json($usersData);
    var ctx1 = document.getElementById('myChart1').getContext('2d');
    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var myChart1 = new Chart(ctx1, {
      type: 'line', 
      data: {
        labels: blogs.map(item => item.month), 
        datasets: [{
          label: 'Số lượng blog trong 6 tháng gần nhất',
          data: blogs.map(item => item.count ), 
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',       
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top',
          }
        }
      }
    });
    
    var myChart2 = new Chart(ctx2, {
        type: 'bar', 
        data: {
            labels: users.map(item => item.month), 
            datasets: [{
                label: 'Số người dùng mới trong 6 tháng gần nhất', 
                data: users.map(item  => item.count), 
                backgroundColor: [ 
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [ 
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1 
            }]
        },
        options: {
            responsive: true, 
            scales: {
                x: { 
                    beginAtZero: true 
                },
                y: { 
                    beginAtZero: true 
                }
            },
            plugins: {
                legend: { 
                    display: true,
                    position: 'top'
                }
            }
        }
    })
  });
</script>
@stop