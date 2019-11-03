<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class LinkDescTemporary extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'link_desc_temporary';
	public $timestamps = false;
	protected $fillable = array('goods_id');
	protected $guarded = array();
}

?>
