<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id','title','description', 'tags', 'status',
    ];

    public function user()
    {   
        return $this->hasOne(User::class, 'id',"user_id");
    }

}
