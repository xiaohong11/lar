<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Coupons extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'coupons';
	protected $primaryKey = 'cou_id';
	public $timestamps = false;
	protected $fillable = array('cou_name', 'cou_total', 'cou_man', 'cou_money', 'cou_user_num', 'cou_goods', 'spec_cat', 'cou_start_time', 'cou_end_time', 'cou_type', 'cou_get_man', 'cou_ok_user', 'cou_ok_goods', 'cou_ok_cat', 'cou_intro', 'cou_add_time', 'ru_id', 'cou_order', 'cou_title', 'review_status', 'review_content');
	protected $guarded = array();
}

?>
