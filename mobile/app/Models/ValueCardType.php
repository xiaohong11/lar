<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ValueCardType extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'value_card_type';
	public $timestamps = false;
	protected $fillable = array('name', 'vc_desc', 'vc_value', 'vc_prefix', 'vc_dis', 'vc_limit', 'use_condition', 'use_merchants', 'spec_goods', 'spec_cat', 'vc_indate', 'is_rec', 'add_time');
	protected $guarded = array();
}

?>
