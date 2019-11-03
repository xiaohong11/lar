<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Nav extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'nav';
	public $timestamps = false;
	protected $fillable = array('ctype', 'cid', 'name', 'ifshow', 'vieworder', 'opennew', 'url', 'type');
	protected $guarded = array();
}

?>
