<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    protected $table = '';//指定表
    protected $primaryKey = 'id';//指定主键
    public $timestamps = false;//表明模型是否应该被打上时间戳
}
