<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Category extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'category';
	protected $primaryKey = 'cat_id';
	public $timestamps = false;
	protected $fillable = array('cat_name', 'keywords', 'cat_desc', 'parent_id', 'sort_order', 'template_file', 'measure_unit', 'show_in_nav', 'style', 'is_show', 'grade', 'filter_attr', 'is_top_style', 'top_style_tpl', 'style_icon', 'cat_icon', 'is_top_show', 'category_links', 'category_topic', 'pinyin_keyword', 'cat_alias_name', 'commission_rate', 'touch_icon');
	protected $guarded = array();

	public function goods()
	{
		return self::hasMany('App\\Models\\Goods', 'cat_id', 'cat_id');
	}
}

?>
