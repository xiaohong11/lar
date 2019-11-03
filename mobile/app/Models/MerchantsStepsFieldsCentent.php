<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsStepsFieldsCentent extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_steps_fields_centent';
	public $timestamps = false;
	protected $fillable = array('tid', 'textFields', 'fieldsDateType', 'fieldsLength', 'fieldsNotnull', 'fieldsFormName', 'fieldsCoding', 'fieldsForm', 'fields_sort', 'will_choose');
	protected $guarded = array();
}

?>
