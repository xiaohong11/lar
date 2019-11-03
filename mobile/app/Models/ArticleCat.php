<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ArticleCat extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'article_cat';
	protected $primaryKey = 'cat_id';
	public $timestamps = false;
	protected $hidden = array('cat_id', 'cat_type');
	protected $visible = array();
	protected $appends = array('id', 'url');
	protected $fillable = array('cat_name', 'cat_type', 'keywords', 'cat_desc', 'sort_order', 'show_in_nav', 'parent_id');
	protected $guarded = array();

	public function article()
	{
		return $this->belongsTo('app\\models\\article', 'cat_id', 'cat_id');
	}

	public function getIdAttribute()
	{
		return $this->attributes['cat_id'];
	}

	public function getUrlAttribute()
	{
		return url('article/index/category', array('id' => $this->attributes['cat_id']));
	}
}

?>
