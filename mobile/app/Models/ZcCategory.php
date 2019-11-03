<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ZcCategory extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'zc_category';
	protected $primaryKey = 'cat_id';
	public $timestamps = false;
	protected $fillable = array('cat_name', 'keywords', 'measure_unit', 'show_in_nav', 'style', 'grade', 'filter_attr', 'is_top_style', 'top_style_tpl', 'cat_icon', 'is_top_show', 'category_links', 'category_topic', 'pinyin_keyword', 'cat_alias_name', 'template_file', 'cat_desc', 'parent_id', 'sort_order', 'is_show');
	protected $guarded = array();
}

?>
