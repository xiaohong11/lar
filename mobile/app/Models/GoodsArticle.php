<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GoodsArticle extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods_article';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'article_id', 'admin_id');
	protected $guarded = array();
}

?>
