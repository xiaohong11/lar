<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsShopInformation extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_shop_information';
	protected $primaryKey = 'shop_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'shoprz_type', 'subShoprz_type', 'shop_expireDateStart', 'shop_expireDateEnd', 'shop_permanent', 'authorizeFile', 'shop_hypermarketFile', 'shop_categoryMain', 'user_shopMain_category', 'shoprz_brandName', 'shop_class_keyWords', 'shopNameSuffix', 'rz_shopName', 'hopeLoginName', 'merchants_message', 'allow_number', 'steps_audit', 'merchants_audit', 'review_goods', 'sort_order', 'is_street', 'is_IM', 'self_run');
	protected $guarded = array();
}

?>
