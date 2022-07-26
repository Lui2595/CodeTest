<?php

namespace App\Http\Controllers;

use App\Blogs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BloggerController extends Controller
{
    public function get()
    {
        $user=Auth::user();
        $id=$user->id;
        $posts=Blogs::where("user_id",$id)->count();
         $data=[            
            'user'=>$user,
            'posts'=>$posts,
        ];
       // return $data;
       return view('blogger.dash',$data);
    }
    public function put(Request $req)
    {   
            $user=User::find(Auth::user()->id);
            $user->first_name=$req->first_name;
            $user->last_name=$req->last_name;
            $user->email=$req->email;
            $user->save();
            return redirect()->route("blogger.dash");
    }
    public function get_blogs()
    {
        $user=Auth::user();
        $id=$user->id;
        $blogs=Blogs::Where("user_id",$id)->get();
        $data=[
            'blogs'=>$blogs,
        ];
        //return $data;
       return view('blogger.blogs',$data);
    }
    public function add_blogs(Request $req)
    {   
        $p = new Blogs();
        $p->user_id=Auth::user()->id;
        $p->title=$req->title;
        $p->description=$req->des;
        $p->tags=$req->tags;
        $p->status=$req->status;
        $p->save();
        return redirect()->route("blogger.blogs");
    }
    public function update_blogs(Request $req)  
    {
        $p =Blogs::find($req->id);
        $p->title=$req->title;
        $p->description=$req->des;
        $p->tags=$req->tags;
        $p->status=$req->status;
        $p->save();
        return redirect()->route("blogger.blogs");
    }
    public function delete_post(Request $req)
    {
        //return $req;
        $post=Blogs::find($req->id);
        $post->delete();
        return redirect()->route("blogger.blogs");
    }
}
