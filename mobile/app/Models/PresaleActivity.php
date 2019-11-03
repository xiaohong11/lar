<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class PresaleActivity extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'presale_activity';
	protected $primaryKey = 'act_id';
	public $timestamps = false;
	protected $fillable = array('act_name', 'cat_id', 'user_id', 'goods_id', 'goods_name', 'act_desc', 'deposit', 'start_time', 'end_time', 'pay_start_time', 'pay_end_time', 'is_finished', 'review_status', 'review_content', 'pre_num');
	protected $guarded = array();
}

?>
