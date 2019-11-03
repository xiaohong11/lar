<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsShopBrandfile extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_shop_brandfile';
	protected $primaryKey = 'b_fid';
	public $timestamps = false;
	protected $fillable = array('bid', 'qualificationNameInput', 'qualificationImg', 'expiredDateInput', 'expiredDate_permanent');
	protected $guarded = array();
}

?>
