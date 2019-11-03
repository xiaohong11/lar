<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\models;

class Keyword extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'keywords';
	public $timestamps = false;
	protected $fillable = array('date', 'searchengine', 'keyword', 'count');
	protected $guarded = array();
}

?>
