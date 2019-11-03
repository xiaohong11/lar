<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsShopBrand extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_shop_brand';
	protected $primaryKey = 'bid';
	public $timestamps = false;
	protected $fillable = array('user_id', 'bank_name_letter', 'brandName', 'brandFirstChar', 'brandLogo', 'brandType', 'brand_operateType', 'brandEndTime', 'brandEndTime_permanent', 'site_url', 'brand_desc', 'sort_order', 'is_show', 'is_delete', 'major_business', 'audit_status', 'add_time');
	protected $guarded = array();
}

?>
