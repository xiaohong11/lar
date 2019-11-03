<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SellerShopinfo extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seller_shopinfo';
	public $timestamps = false;
	protected $fillable = array('ru_id', 'shop_name', 'shop_title', 'shop_keyword', 'country', 'province', 'city', 'district', 'shop_address', 'seller_email', 'kf_qq', 'kf_ww', 'meiqia', 'kf_type', 'kf_tel', 'site_head', 'mobile', 'shop_logo', 'logo_thumb', 'street_thumb', 'brand_thumb', 'notice', 'street_desc', 'shop_header', 'shop_color', 'shop_style', 'status', 'apply', 'is_street', 'remark', 'seller_theme', 'win_goods_type', 'store_style', 'check_sellername', 'shopname_audit', 'shipping_id', 'shipping_date', 'longitude', 'tengxun_key', 'latitude', 'kf_appkey', 'kf_touid', 'kf_logo', 'kf_welcomeMsg', 'kf_secretkey', 'user_menu', 'kf_im_switch', 'seller_money', 'frozen_money', 'seller_templates', 'templates_mode', 'js_appkey', 'js_appsecret');
	protected $guarded = array();

	public function MerchantsShopInformation()
	{
		return self::belongsTo('App\\Models\\MerchantsShopInformation', 'ru_id', 'user_id')->select('user_id', 'shoprz_brandName');
	}
}

?>
