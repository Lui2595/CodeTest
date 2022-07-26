@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
      @include('layouts.sup-side')

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
        </div>
        <div class="row text-center">
          <div class="card col-md-6 col-lg-3" >
            <div class="card-body">
              <h5 class="card-title text-center">Posts</h5>
              <h2 class="card-text  text-center">{{$posts}}</h2>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-6 col-sm-12">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">First Name</label>
                <input type="text" class="form-control" id="" placeholder="First Name" value="{{$user->first_name}}" disabled>
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Last Name</label>
                <input type="text" class="form-control" id="" placeholder="First Name" value="{{$user->last_name}}" disabled>
              </div>
            </div>
            <div class="form-group">
              <label for="inputAddress">Email</label>
              <input type="email" class="form-control" id="" placeholder="Example@hotmail.com" value="{{$user->email}}" disabled>
            </div>
            <button class="btn btn-primary" data-toggle="modal" data-target="#update">Update</button>
          </div>
        </div>

      </main>
      
      <!-- Modal -->
      <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateLabel">Update Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('blogger.dash')}}" method="POST">
                @csrf
                @method("PUT")
                <div class="col-12">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">First Name</label>
                      <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{$user->first_name}}" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">Last Name</label>
                      <input type="text" class="form-control" name="last_name" placeholder="First Name" value="{{$user->last_name}}" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Example@hotmail.com" value="{{$user->email}}" required>
                  </div>
                </div>
              
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="prevenDefault()">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection