<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class CommentBaseline extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'comment_baseline';
	public $timestamps = false;
	protected $fillable = array('goods', 'service', 'shipping');
	protected $guarded = array();
}

?>
