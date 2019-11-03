<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ArticleExtend extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'article_extend';
	public $timestamps = false;
	protected $fillable = array('article_id', 'click', 'likenum', 'hatenum');
	protected $guarded = array();
}

?>
