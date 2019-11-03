<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsDtFile extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_dt_file';
	protected $primaryKey = 'dtf_id';
	public $timestamps = false;
	protected $fillable = array('cat_id', 'dt_id', 'user_id', 'permanent_file', 'permanent_date', 'cate_title_permanent');
	protected $guarded = array();
}

?>
