<?php

namespace App\Http\Controllers;

use App\Blogs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{
    public function get()
    {
        $user=Auth::user();
        $id=$user->id;
        $bloggers=DB::select("SELECT count(*) num From users WHERE user_type='Blogger' AND id in(SELECT blogger_id FROM supervisors_bloggers WHERE supervisor_id ='$id') limit 1")[0]->num;
        $data=[            
            'user'=>$user,
            'bloggers'=>$bloggers,
        ];
       // return $data;
       return view('supervisors.dash',$data);
    }
    public function put(Request $req)
    {   
            $user=User::find(Auth::user()->id);
            $user->first_name=$req->first_name;
            $user->last_name=$req->last_name;
            $user->email=$req->email;
            $user->save();
            return redirect()->route("sup.dash");
    }
    public function get_users()
    {    $user=Auth::user();
        $id=$user->id;
        $data=[
            'users'=>DB::select("SELECT * From users WHERE user_type='Blogger' AND id in(SELECT blogger_id FROM supervisors_bloggers WHERE supervisor_id ='$id') "),
          
        ];
        //return $data;
       return view('supervisors.users',$data);
    }
    public function get_blogs()
    {
        $user=Auth::user();
        $id=$user->id;
        $ids=collect(DB::select("SELECT blogger_id FROM supervisors_bloggers WHERE supervisor_id ='$id'"))->map(function($e){
            return $e->blogger_id;
        });        
        $blogs=Blogs::whereIn('user_id',$ids)->orWhere("user_id",$id)->get();
        $data=[
            'blogs'=>$blogs,
        ];
        //return $data;
       return view('supervisors.blogs',$data);
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
        return redirect()->route("sup.blogs");
    }
    public function update_blogs(Request $req)  
    {
        $p =  Blogs::find($req->id);
        $p->title=$req->title;
        $p->description=$req->des;
        $p->tags=$req->tags;
        $p->status=$req->status;
        $p->save();
        return redirect()->route("sup.blogs");
    }
    public function delete_post(Request $req)
    {
        //return $req;
        $post=Blogs::find($req->id);
        $post->delete();
        return redirect()->route("sup.blogs");
    }
}
