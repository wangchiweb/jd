<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $table = 'prize';//指定表
    protected $primaryKey = 'prize_id';//指定主键
    public $timestamps = false;//表明模型是否应该被打上时间戳
}
