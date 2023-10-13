@extends('layouts.app-master')
@section('content')
<form class="mx-auto p-3 border border-primary" method="post" action="/">
    <h1 class="text-primary p-2 h3" >THÊM NGƯỜI LIÊN LẠC</h1>
    <div class="mb-3 row">
        <div class="col-md-6">
             <label>tên người liên lạc</label> <input class="form-control" name="name" type='text' required >
        </div>
        <div class="col-md-6">
             <label>Email người liên lạc</label> <input class="form-control" name="email" type="email" required>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-md-6">
             <label>Số điện thoại người liên lạc</label> <input class="form-control" name="phone" type="tel" required>
        </div>
        <div class="col-md-6">
            <label>Địa chỉ người liên lạc</label> <input class="form-control" name="address" type="text">
       </div>
    </div>
    <div class="mb-3 row">
        <div class="col-md-6">
             <label>Ngày sinh người liên lạc</label> <input class="form-control" name="phone" type="date" required>
        </div>
        <div class="col-md-6">
            <label>Công ty người liên lạc đang làm việc</label> <input class="form-control" name="company" type="text" >
       </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-warning py-2 px-5" >Lưu</button>
    </div>  @csrf
    </form> 
    @endsection
