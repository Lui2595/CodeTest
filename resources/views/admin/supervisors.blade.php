@extends('layouts.app')

@section('content')

<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">

<div class="container-fluid">
    <div class="row">
      @include('layouts.admin-side')

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Supervisors</h1>
        </div>
  
        <br>
        <div class="row">
          <div class="col-12">
            <table class="datatable table" >
              <thead class="thead-dark">
                <th>User ID</th>
                <th>Supervisron Name</th>
                <th>Bloggers</th>
               
              </thead>
            @foreach ($supervisors as $sup)
                <tr>
                  {{-- <td>{{$sup->id}}</td>
                  <td>{{$sup->first_name}} {{$sup->last_name}}</td> --}}
                  
                  
                    {{-- @foreach ($sup->bloggers as $blogger)
                    {{$blogger->first_name}} {{$blogger->last_name}} </br> 
                    @endforeach --}}
                    <td>{{ $sup["id"]}}</td>
                    <td>{{ $sup["first_name"]}} {{ $sup["last_name"]}}</td>
                    <td>
                      @foreach ($sup["bloggers"] as $blogger)
                      <ul>
                        <li>  {{$blogger->first_name}} {{$blogger->last_name}}</li>
                      </ul>
                      
                      @endforeach
                    </td>
                  
            @endforeach
            </table>
          </div>
        </div>

      </main>
      
    

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