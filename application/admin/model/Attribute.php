<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Attribute extends Model
{
    use SoftDelete;
    protected $deleteTime="delete_time";
    protected $autoWriteTimestamp=true;
    public function type(){
        return $this->hasOne("app\admin\model\Type","id","type_id");
    }
}
