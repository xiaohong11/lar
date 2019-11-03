<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GoodsActivity extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods_activity';
	protected $primaryKey = 'act_id';
	public $timestamps = false;
	protected $fillable = array('act_name', 'user_id', 'act_desc', 'activity_thumb', 'act_promise', 'act_ensure', 'act_type', 'goods_id', 'product_id', 'goods_name', 'start_time', 'end_time', 'is_finished', 'ext_info', 'is_hot', 'review_status', 'review_content', 'is_new');
	protected $guarded = array();
}

?>
