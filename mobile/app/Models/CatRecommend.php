<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class CatRecommend extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'cat_recommend';
	public $timestamps = false;
	protected $fillable = array('cat_id', 'recommend_type');
	protected $guarded = array();
}

?>
