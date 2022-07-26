<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\SupervisorsBloggers;
use App\Blogs;
use App\Supervisors;

class AdminController extends Controller
{
    //
    public function get()
    {
        $admins=DB::select("SELECT count(*) num From users WHERE user_type='Admin' limit 1")[0]->num;
        $supervisors=DB::select("SELECT count(*) num From users WHERE user_type='Supervisor' limit 1")[0]->num;
        $bloggers=DB::select("SELECT count(*) num From users WHERE user_type='Blogger' limit 1")[0]->num;
        $data=[
            'user'=>Auth::user(),
            'admins'=>$admins,
            'supervisors'=>$supervisors,
            'bloggers'=>$bloggers,
        ];
       // return $data;
       return view('admin.dash',$data);
    }
    public function put(Request $req)
    {   
            $user=User::find(Auth::user()->id);
            $user->first_name=$req->first_name;
            $user->last_name=$req->last_name;
            $user->email=$req->email;
            $user->save();
            return redirect()->route("admin.dash");
    }
    public function get_users()
    {       
        $data=[
            'users'=>User::all(),
        ];
        //return $data;
       return view('admin.users',$data);
    }
    public function add_user(Request $req)
    {
        $u =new User();
        $u->first_name=$req->first_name;
        $u->last_name=$req->last_name;
        $u->user_type=$req->user_type;
        $u->email=$req->email;
        $u->password=Hash::make($req->password);
        $u->save();
        return redirect()->route("admin.users");
    }
    public function update_user(Request $req)
    {
        //return $req;
        $user=User::find($req->id);
        $user->first_name=$req->first_name;
        $user->last_name=$req->last_name;
        $user->email=$req->email;
        if($req->password!=""||$req->password!=null){
            $user->password=Hash::make($req->password);
        }
        $user->save();
        return redirect()->route("admin.users");
    }
    public function delete_user(Request $req)
    {
        $user=User::find($req->id);
        $user->delete();
        return redirect()->route("admin.users");
    }
    public function add_sup(Request $req)
    {   //return $req;
        $sup= SupervisorsBloggers::where("blogger_id",$req->user_id)->get();
        $supers=explode(",",$req->supArray);
            $ids=[];
            if(count($sup)>0){
                for ($i=0; $i < count($sup); $i++) { 
                    if(!in_array($sup[$i]["supervisor_id"], $supers)){
                     $rel=SupervisorsBloggers::find($sup[$i]["id"]);
                     array_push($ids,$rel);
                      $rel->delete();
                    }
                 }
                 validate:
                 for ($i=0; $i < count($sup); $i++) { 
                     foreach ($supers as $key => $super) {
                         if($super==$sup[$i]["supervisor_id"]){
                             array_splice($supers, $key, 1,);
                             goto validate;
                         }
                      }
                  }
                 
            }
            
            
            //return $ids;
            for ($i=0; $i < count($supers); $i++) { 
                if($supers[$i]!=""){
                    $rel = new SupervisorsBloggers();
                    $rel->supervisor_id=$supers[$i];
                    $rel->blogger_id=$req->user_id;
                    $rel->save();
                }
            }
        
            return redirect()->route("admin.users");
    }
    public function get_blogs()
    {
        $data=[
            'blogs'=>Blogs::all(),
        ];
        //return $data;
       return view('admin.blogs',$data);
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
        return redirect()->route("admin.blogs");
    }
    public function update_blogs(Request $req)  
    {
        $p =  Blogs::find($req->id);
        $p->title=$req->title;
        $p->description=$req->des;
        $p->tags=$req->tags;
        $p->status=$req->status;
        $p->save();
        return redirect()->route("admin.blogs");
    }
    public function delete_post(Request $req)
    {
        //return $req;
        $post=Blogs::find($req->id);
        $post->delete();
        return redirect()->route("admin.blogs");
    }
    public function get_supervisors()
    {
        $sup=User::where("user_type","Supervisor")->get();
        $res= $sup->map(function($e){
            $bloggers= SupervisorsBloggers::where("supervisor_id",$e->id)->get();
            $bloggers= $bloggers->map(function($f){
                return User::find($f->blogger_id);
            });
            return [
                "id"=>$e->id,
                "first_name"=>	$e->first_name,
                "last_name"	=>$e->last_name,
                "email" =>	$e->email,
                "user_type"	=>$e->user_type,
                "email_verified_at"	=>$e->email_verified_at,
                "last_login" =>	$e->last_login,
                "created_at" =>	$e->created_at,
                "updated_at" =>	$e->updated_at,
                "bloggers"=>$bloggers
            ];
        });
        //return $res;
        $data=[
            'supervisors'=>$res,
        ];
        return view('admin.supervisors',$data);
    }
}
