<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Tag extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'tag';
	protected $primaryKey = 'tag_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'goods_id', 'tag_words');
	protected $guarded = array();
}

?>
