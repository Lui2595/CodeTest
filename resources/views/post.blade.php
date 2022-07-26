@extends('layouts.app')

@section('content')

<div class="container">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 blog-main">
          
            <div class="blog-post">
              <h2 class="blog-post-title">{{$post['title']}}</h2>
              @php
              $date=new DateTime($post['created_at']);
              $dateTx=$date->format('F d, Y');
              @endphp
              <p class="blog-post-meta">{{ $dateTx }} by <a href="#">{{$post->user->first_name}}</a></p>
              <div class="card" style="min-height: 100px">
                {!!$post['description']!!}
              </div>
             
            </div><!-- /.blog-post -->
         
          

        </div><!-- /.blog-main -->

        <aside class="col-md-4 blog-sidebar">
          <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">About</h4>
            <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>

      
        </aside><!-- /.blog-sidebar -->

      </div>
    </div> 
</div>


  @endsection