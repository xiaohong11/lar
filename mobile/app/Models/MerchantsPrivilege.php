<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsPrivilege extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_privilege';
	public $timestamps = false;
	protected $fillable = array('action_list', 'grade_id');
	protected $guarded = array();
}

?>
