<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Card extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'card';
	protected $primaryKey = 'card_id';
	public $timestamps = false;
	protected $fillable = array('card_name', 'user_id', 'card_img', 'card_fee', 'free_money', 'card_desc');
	protected $guarded = array();
}

?>
