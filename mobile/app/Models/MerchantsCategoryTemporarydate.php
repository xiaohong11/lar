<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsCategoryTemporarydate extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_category_temporarydate';
	protected $primaryKey = 'ct_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'cat_id', 'parent_id', 'cat_name', 'parent_name', 'is_add');
	protected $guarded = array();
}

?>
