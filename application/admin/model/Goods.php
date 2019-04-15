<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Goods extends Model
{
    use SoftDelete;
    protected $deleteTime="delete_time";
    protected $autoWriteTimestamp=true;
    public function category(){
        return $this->hasOne("app\admin\model\Category","id","cat_id");
    }
}
