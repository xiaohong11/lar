<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsNav extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_nav';
	public $timestamps = false;
	protected $fillable = array('ctype', 'cid', 'cat_id', 'name', 'ifshow', 'vieworder', 'opennew', 'url', 'type', 'ru_id');
	protected $guarded = array();
}

?>
