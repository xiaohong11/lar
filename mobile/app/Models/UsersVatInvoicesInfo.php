<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class UsersVatInvoicesInfo extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'users_vat_invoices_info';
	public $timestamps = false;
	protected $fillable = array('user_id', 'company_name', 'company_address', 'tax_id', 'company_telephone', 'bank_of_deposit', 'bank_account', 'consignee_name', 'consignee_mobile_phone', 'consignee_province', 'consignee_address', 'audit_status', 'add_time');
	protected $guarded = array();
}

?>
