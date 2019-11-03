<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\models;

class RegField extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'reg_fields';
	public $timestamps = false;
	protected $fillable = array('reg_field_name', 'dis_order', 'display', 'type', 'is_need');
	protected $guarded = array();
}

?>
