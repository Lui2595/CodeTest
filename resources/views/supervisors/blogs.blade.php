@extends('layouts.app')

@section('content')

<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
<style>
  
   
    @media only screen and (min-width: 768px) {
      .modal-dialog-post{
        max-width: 80%;
      }
    }
  
</style>

<div class="container-fluid">
    <div class="row">
      @include('layouts.sup-side')

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Posts</h1>
        </div>
        <div class="row justify-content-end">
          <button class="btn btn-primary mr-5" data-toggle="modal" data-target="#addmodal">Add Post</button>
        </div>
        <br>
        <div class="row">
          <div class="col-12">
            <table class="datatable table" >
              <thead class="thead-dark">
                <th>ID</th>
                <th>User</th>
                <th>Title</th>
                <th>Tags</th>
                <th>Status</th>
                <th>Created</th>
                <th>Update</th>
                <th>Actions</th>
              </thead>
            @foreach ($blogs as $blog)
                <tr>
                  <td>{{$blog->id}}</td>
                  <td>{{$blog->user->first_name}} {{$blog->user->last_name}}</td>
                  <td>{{$blog->title}}</td>
                  <td>    
                    @php
                      $tags= explode(",",$blog->tags);
                      // print_r($tags);
                    @endphp
                     @foreach ($tags as $tag)
                     <span class="badge badge-primary">{{$tag}}</span>
                     @endforeach
                  </td>
                  <td>{{$blog->status}}</td>
                  <td>{{$blog->created_at}}</td>
                  <td>{{$blog->updated_at}}</td>
                  <td>
                    <a href="{{route('post',["id"=>$blog->id])}}" class="btn btn-success"> View</a>
                    <button class="btn btn-primary m-1 btn-update"  data-toggle="modal" data-target="#editmodal"
                    data-id='{{$blog->id}}'
                    data-title='{{$blog->title}}'
                    data-des='{{$blog->description}}'
                    data-tags='{{$blog->tags}}'
                    data-status='{{$blog->status}}' >Update</button>
                    <button class="btn btn-danger m-1 btn-delete" data-toggle="modal" data-target="#delete_modal" data-id='{{$blog->id}}' data-title='{{$blog->title}}' >Delete</button> </td>
                </tr>
            @endforeach
            </table>
          </div>
        </div>

      </main>
      
      <!-- Modal Add Post -->
      <div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-post" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateLabel">Add Blog</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('sup.blogsAdd')}}" method="POST" id="addform">
                @csrf
                <div class="col-12">
        
                  <div class="form-group">
                    <label for="inputAddress">Title</label>
                    <input type="text" class="form-control" name="title" placeholder="New Post"  required>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Content</label>
                    <textarea name="des" id="post_content" cols="30" rows="10" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <div class="form-group">
                      <label for="usertype">Status</label>
                      <select class="form-control" name="status" id="" required>
                        <option value="">Select status</option>
                        <option value="Published">Published</option>
                        <option value="Hidden">Hidden</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Tags</label>
                    <input type="text" class="form-control" name="tags" id='tags' placeholder="New,Best,Topic...."  required>
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
            <!-- Modal Add Post -->
            <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-post" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="updateLabel">Update Blog</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('sup.blogsUpdate')}}" method="POST" id="updateform">
                      @csrf
                      @method("PUT")
                      <div class="col-12">
                        <input type="hidden" name="id" id="u_id">
                        <div class="form-group">
                          <label for="inputAddress">Title</label>
                          <input type="text" class="form-control" name="title" id="u_title" placeholder="New Post"  required>
                        </div>
                        <div class="form-group">
                          <label for="inputAddress">Content</label>
                          <textarea name="des" id="u_des" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                          <div class="form-group">
                            <label for="usertype">Status</label>
                            <select class="form-control" name="status" id="u_status" required>
                              <option value="">Select status</option>
                              <option value="Published">Published</option>
                              <option value="Hidden">Hidden</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputAddress">Tags</label>
                          <input type="text" class="form-control" name="tags" id='u_tags' placeholder="New,Best,Topic...."  required>
                        </div>
                      </div>
                    
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="event.preventDefault(); $('#updateform').trigger('reset')">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
                </form>
                </div>
              </div>
             </div>
            </div>

        <!-- Modal Delete Post -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="delete_modalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="delete_modalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('sup.blogsDelete')}}" method="POST" id="delete_form" >
                  @csrf
                  @method("DELETE")
                  <div class="col-12">
                    <input type="hidden" name="id" id="delete_id">
                    <p>Sure you like to delete <span id="delete_title"></span> permanently?</p>
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

  <script src="{{ asset('js/jquery-3.6.0.min.js') }}" ></script>
  <script src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.all.min.js" integrity="sha512-ng0ComxRUMJeeN1JS62sxZ+eSjoavxBVv3l7SG4W/gBVbQj+AfmVRdkFT4BNNlxdDCISRrDBkNDxC7omF0MBLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script type="text/javascript">
    $(document).ready( function () {
        $('.datatable').DataTable();
      });
      //$("#post_content").wysihtml5()
    $(".btn-delete").click(function(){
      
      let id=$(this).data("id")
      let title =$(this).data("title")
      $("#delete_title").html(title)
      $("#delete_id").val(id)
    })
    $(".btn-update").click(function(){
      
      let id=$(this).data("id")
      let title =$(this).data("title")
      let des =$(this).data("des")
      let tags=$(this).data("tags")
      let status=$(this).data("status")

      $("#u_id").val(id)
      $("#u_title").val(title)
      $("#u_des").val(des)
      $("#u_tags").val(tags)
      $("#u_status").val(status)
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