<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class AutoManage extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'auto_manage';
	public $timestamps = false;
	protected $fillable = array('item_id', 'type', 'starttime', 'endtime');
	protected $guarded = array();
}

?>
