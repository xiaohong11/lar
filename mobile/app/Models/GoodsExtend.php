<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GoodsExtend extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods_extend';
	protected $primaryKey = 'extend_id';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'is_reality', 'is_return', 'is_fast', 'width', 'height', 'depth', 'origincountry', 'originplace', 'assemblycountry', 'barcodetype', 'catena', 'isbasicunit', 'packagetype', 'grossweight', 'netweight', 'netcontent', 'licensenum', 'healthpermitnum');
	protected $guarded = array();
}

?>
