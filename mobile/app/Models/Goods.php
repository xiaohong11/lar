<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Goods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods';
	protected $primaryKey = 'goods_id';
	protected $appends = array('url', 'goodsthumb');
	public $timestamps = false;
	protected $fillable = array('cat_id', 'user_cat', 'user_id', 'goods_sn', 'bar_code', 'goods_name', 'goods_name_style', 'click_count', 'brand_id', 'provider_name', 'goods_number', 'goods_weight', 'default_shipping', 'market_price', 'cost_price', 'shop_price', 'promote_price', 'promote_start_date', 'promote_end_date', 'warn_number', 'keywords', 'goods_brief', 'goods_desc', 'desc_mobile', 'goods_thumb', 'goods_img', 'original_img', 'is_real', 'extension_code', 'is_on_sale', 'is_alone_sale', 'is_shipping', 'integral', 'add_time', 'sort_order', 'is_delete', 'is_best', 'is_new', 'is_hot', 'is_promote', 'is_volume', 'is_fullcut', 'bonus_type_id', 'last_update', 'goods_type', 'seller_note', 'give_integral', 'rank_integral', 'suppliers_id', 'is_check', 'store_hot', 'store_new', 'store_best', 'group_number', 'is_xiangou', 'xiangou_start_date', 'xiangou_end_date', 'xiangou_num', 'review_status', 'review_content', 'goods_shipai', 'comments_number', 'sales_volume', 'comment_num', 'model_price', 'model_inventory', 'model_attr', 'largest_amount', 'pinyin_keyword', 'goods_product_tag', 'goods_tag', 'stages', 'stages_rate', 'freight', 'shipping_fee', 'tid', 'goods_unit', 'goods_cause', 'dis_commission', 'is_distribution');
	protected $guarded = array();

	public function getUrlAttribute()
	{
		return url('goods/index/index', array('id' => $this->attributes['goods_id']));
	}

	public function getGoodsThumbAttribute()
	{
		return get_image_path($this->attributes['goods_thumb']);
	}
}

?>
