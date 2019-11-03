<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class CommentImg extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'comment_img';
	public $timestamps = false;
	protected $fillable = array('user_id', 'order_id', 'rec_id', 'goods_id', 'comment_id', 'comment_img', 'img_thumb', 'cont_desc');
	protected $guarded = array();
}

?>
