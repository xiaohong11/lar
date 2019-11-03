<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SellerGrade extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seller_grade';
	public $timestamps = false;
	protected $fillable = array('grade_name', 'goods_sun', 'seller_temp', 'favorable_rate', 'give_integral', 'rank_integral', 'pay_integral', 'white_bar', 'grade_introduce', 'entry_criteria', 'grade_img', 'is_open', 'is_default');
	protected $guarded = array();
}

?>
