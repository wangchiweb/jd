<?php
namespace App\Model;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    protected $table = 'category';//指定表
    protected $primaryKey = 'cat_id';//指定主键
    public $timestamps = false;//表明模型是否应该被打上时间戳

    use ModelTree;
    public function __construct(array $attributes = []){
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('sort_order');
        $this->setTitleColumn('cat_name');
    }
}
