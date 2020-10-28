<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movie';//指定表
    protected $primaryKey = 'movie_id';//指定主键
    public $timestamps = false;//表明模型是否应该被打上时间戳/
}
