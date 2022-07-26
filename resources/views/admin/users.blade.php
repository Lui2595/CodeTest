@extends('layouts.app')

@section('content')

<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">

<div class="container-fluid">
    <div class="row">
      @include('layouts.admin-side')

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Users</h1>
        </div>
        <div class="row justify-content-end">
          <button class="btn btn-primary mr-5" data-toggle="modal" data-target="#addmodal">Add User</button>
        </div>
        <br>
        <div class="row">
          <div class="col-12">
            <table class="datatable table" >
              <thead class="thead-dark">
                <th>ID</th>
                <th>User Type</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Supervisor</th>
                <th>Email</th>
                <th>Action</th>
              </thead>
            @foreach ($users as $user)
                <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->user_type}}</td>
                  <td>{{$user->first_name}}</td>
                  <td>{{$user->last_name}}</td>
                  
                  <td>@php
                    if($user->user_type=="Blogger"){
                      if(count($user->sup)===0){
                        echo '<input type="button" value="Add Supervisor" data-toggle="modal" data-target="#addsup" onclick="addSup('.$user->id.')">';
                      }else{
                        $ids="";
                        for ($i=0; $i < count($users) ; $i++) { 
                         // echo $user->sup;
                            foreach ($user->sup as $sup ) {
                              
                             // echo $users[$i]->id;
                              if( $sup->supervisor_id==$users[$i]->id){
                                echo '<p class="badge badge-light ">'.$users[$i]->first_name.' '.$users[$i]->last_name.'</p></br>';
                                $ids.=",".$users[$i]->id;
                              }
                            }
                        }
                        echo '<input type="button" value="Update Supervisor" data-toggle="modal" data-target="#addsup" onclick="updateSup('.$user->id.',\''.$ids.'\')">';
                      }
                    }
                     @endphp 
                    </td>
                  <td>{{$user->email}}</td>
                  <td><button class="btn btn-primary m-1 btn-update" data-toggle="modal" data-target="#update" data-id='{{$user->id}}' data-fname='{{$user->first_name}}' data-lname='{{$user->last_name}}' data-email='{{$user->email}}' data-type='{{$user->user_type}}'>Update</button>
                    <button class="btn btn-danger m-1 btn-delete" data-toggle="modal" data-target="#delete_modal" data-id='{{$user->id}}' data-name='{{$user->first_name}} {{$user->last_name}}' >Delete</button> </td>
                </tr>
            @endforeach
            </table>
          </div>
        </div>

      </main>
      
      <!-- Modal Add User -->
      <div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateLabel">Add User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('admin.users')}}" method="POST" id="addform">
                @csrf
                <div class="col-12">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">First Name</label>
                      <input type="text" class="form-control" name="first_name" placeholder="First Name"  required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">Last Name</label>
                      <input type="text" class="form-control" name="last_name" placeholder="First Name"  required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Example@hotmail.com"  required>
                  </div>
                  <div class="form-group">
                    <div class="form-group">
                      <label for="usertype">User Type</label>
                      <select class="form-control" name="user_type" id="" required>
                        <option value="">Select user type</option>
                        <option value="Admin">Admin</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Blogger">Blogger</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Password</label>
                    <input type="password" class="form-control" name="password" id='pass1' placeholder="Password"  required>
                  </div>
                </div>
              
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="event.preventDefault(); $('#addform').trigger('reset')">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
          </div>
        </div>
       </div>
      </div>
      <!-- Modal Update User -->
      <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateLabel">Update User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('admin.usersUpdate')}}" method="POST" id="update_form" >
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="u_id">
                <div class="col-12">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">First Name</label>
                      <input type="text" class="form-control" name="first_name" id="u_first_name" placeholder="First Name" value="" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">Last Name</label>
                      <input type="text" class="form-control" name="last_name" id="u_last_name" placeholder="First Name" value="" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Email</label>
                    <input type="email" class="form-control" name="email" id="u_email" placeholder="Example@hotmail.com" value="" required>
                  </div>
                  <div class="form-group">
                    <div class="form-group">
                      <label for="usertype">User Type</label>
                      <select class="form-control" name="user_type" id="u_type" required>
                        <option value="">Select user type</option>
                        <option value="Admin">Admin</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Blogger">Blogger</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">New Password (Not Required)</label>
                    <input type="pasword" class="form-control" name="password" id="u_password" placeholder="Password" value="" >
                  </div>

                </div>
              
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="prevenDefault(); $('#update_form').trigger('reset')">Cancel</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
          </div>
        </div>
        </div>
      </div>
        <!-- Modal Delete User -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="delete_modalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="delete_modalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('admin.usersDelete')}}" method="POST" id="delete_form" >
                  @csrf
                  @method("DELETE")
                  <div class="col-12">
                    <input type="hidden" name="id" id="delete_id">
                    <p>Sure you like to delete <span id="delete_user"></span> permanently?</p>
                  </div>
                
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="prevenDefault(); $('#delete_form').trigger('reset')">Cancel</button>
                <button type="submit" class="btn btn-primary">Continue</button>
              </div>
            </form>
            </div>
          </div>
          </div>
        </div>
   <!-- Modal -->
      <div class="modal fade" id="addsup" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateLabel">Add Supervisor</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('admin.bloggerSup')}}" id="supAddForm" method="POST">
                @csrf
                <div class="col-12">
                  @foreach ($users as $user)
                    @php
                      if($user->user_type=="Supervisor"){
                        if(count($user->sup)===0){
                        echo '<div class="form-group col-md-6">
                                <input type="checkbox" class="form-check-input" id="'.$user->id.'" onchange="fnSupArray(this)" >
                                <label class="form-check-label" for="">'.$user->first_name.' '.$user->last_name.'</label>
                              </div>';
                        }
                      }
                     @endphp 
                  @endforeach
                  <input type="hidden" name="supArray" id="supArray">
                  <input type="hidden" name="user_id" id="user_id">
                </div>
              
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="event.preventDefault(); $('#supAddForm').trigger('reset')">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
          </div>
        </div>
      </div>

  <script src="{{ asset('js/jquery-3.6.0.min.js') }}" ></script>
  <script src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>

    <script type="text/javascript">
    $(document).ready( function () {
        $('.datatable').DataTable();
      });

    $(".btn-delete").click(function(){
      
      let id=$(this).data("id")
      let name =$(this).data("name")
      $("#delete_user").html(name)
      $("#delete_id").val(id)
    })
    $(".btn-update").click(function(){
      
      let id=$(this).data("id")
      let fname =$(this).data("fname")
      let lname =$(this).data("lname")
      let email=$(this).data("email")
      let type=$(this).data("type")

      $("#u_first_name").val(fname)
      $("#u_last_name").val(lname)
      $("#u_email").val(email)
      $("#u_id").val(id)
      $("#u_type").val(type)
    })
  
    
    
    function addSup(id){
      $("#user_id").val(id)
    }
    function updateSup(id, ids){
      $("#user_id").val(id)
      $("#supArray").val(ids)
      let ids2=ids.split(",");
      for (let i = 0; i < ids2.length; i++) {
        const e = ids2[i];
        if(e!=""){
          $("#"+e).prop("checked",true)
        }
      }     
    }
    function fnSupArray(e){
      let val=$("#supArray").val().split(",")
      let id=$(e).prop("id");
      let check=$(e).prop("checked");
      //console.log(check);
      if(check){
        if(!val.includes(id)){
          val.push(id);
          $("#supArray").val(val.join(","))
        }
      }else{
        const index = val.indexOf(id);
        if (index > -1) { // only splice array when item is found
          val.splice(index, 1); // 2nd parameter means remove one item only
        }
        $("#supArray").val(val.join(","))
      }
      console.log($("#supArray").val())
      
       
    }
    </script>
  

    

@endsection