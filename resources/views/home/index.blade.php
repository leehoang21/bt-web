@extends('layouts.app-master')

@section('content')
    @guest
    <div class="bg-light p-5 rounded">
        <h1>Homepage</h1>
        <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>     
    </div>
    @endguest
    @auth
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5 style="margin-top:10px">Contacts</h5>
            <a href="create" style="margin-left: 10px;"class="btn btn-success">Thêm</a>
        </div>
        <div class="ibox-content">
            <table class="table">
                <thead>
                <tr>
                   
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày sinh</th>
                    <th>Công ty</th>
                    <th>Action</th>
                    
                </tr>
                </thead>
                <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{$contact->name}}</td>
                        <td>{{$contact->email}}</td>
                        <td>{{$contact->phone}}</td>
                        <td>{{$contact->address}}</td>
                        <td>{{$contact->date_of_birth}}</td>
                        <td>{{$contact->company}}</td>

                        <td>
                            <a href="edit/{{ $contact->id }}" class="btn btn-primary">Sửa</a>
                            <a href="delete/{{ $contact->id }}" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <tr> <td colspan="4"> {{ $contacts->onEachSide(5)->links()}} </td> </tr>
        </table>
        </div>
    </div>
    @endauth
@endsection
