<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';//指定表
    protected $primaryKey = 'coupon_id';//指定主键
    public $timestamps = false;//表明模型是否应该被打上时间戳
}
