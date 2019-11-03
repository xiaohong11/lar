<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GiftGardLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'gift_gard_log';
	public $timestamps = false;
	protected $fillable = array('admin_id', 'gift_gard_id', 'delivery_status', 'addtime', 'handle_type');
	protected $guarded = array();
}

?>
