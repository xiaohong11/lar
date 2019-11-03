<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SearchKeyword extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'search_keyword';
	protected $primaryKey = 'keyword_id';
	public $timestamps = false;
	protected $fillable = array('keyword', 'pinyin', 'is_on', 'count', 'addtime', 'pinyin_keyword');
	protected $guarded = array();
}

?>
