<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Searchengine extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'searchengine';
	public $timestamps = false;
	protected $fillable = array('date', 'searchengine', 'count');
	protected $guarded = array();
}

?>
