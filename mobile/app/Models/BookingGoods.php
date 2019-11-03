<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class BookingGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'booking_goods';
	protected $primaryKey = 'rec_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'email', 'link_man', 'tel', 'goods_id', 'goods_desc', 'goods_number', 'booking_time', 'is_dispose', 'dispose_user', 'dispose_time', 'dispose_note');
	protected $guarded = array();
}

?>
