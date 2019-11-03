<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class OrderInfo extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'order_info';
	protected $primaryKey = 'order_id';
	public $timestamps = false;
	protected $fillable = array('main_order_id', 'order_sn', 'user_id', 'order_status', 'shipping_status', 'pay_status', 'consignee', 'country', 'province', 'city', 'district', 'street', 'address', 'zipcode', 'tel', 'mobile', 'email', 'best_time', 'sign_building', 'postscript', 'shipping_id', 'shipping_name', 'shipping_code', 'shipping_type', 'pay_id', 'pay_name', 'how_oos', 'how_surplus', 'pack_name', 'card_name', 'card_message', 'inv_payee', 'inv_content', 'goods_amount', 'cost_amount', 'shipping_fee', 'insure_fee', 'pay_fee', 'pack_fee', 'card_fee', 'money_paid', 'surplus', 'integral', 'integral_money', 'bonus', 'order_amount', 'from_ad', 'referer', 'add_time', 'confirm_time', 'pay_time', 'shipping_time', 'confirm_take_time', 'auto_delivery_time', 'pack_id', 'card_id', 'bonus_id', 'invoice_no', 'extension_code', 'extension_id', 'to_buyer', 'pay_note', 'agency_id', 'inv_type', 'tax', 'is_separate', 'parent_id', 'discount', 'discount_all', 'is_delete', 'is_settlement', 'sign_time', 'is_single', 'point_id', 'shipping_dateStr', 'supplier_id', 'froms', 'coupons', 'is_zc_order', 'zc_goods_id', 'is_frozen', 'drp_is_separate', 'team_id', 'team_parent_id', 'team_user_id', 'team_price', 'chargeoff_status', 'invoice_type', 'vat_id');
	protected $guarded = array();
}

?>
