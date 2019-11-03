<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Http\Controllers;

class ExampleController extends Controller
{
	public function __construct()
	{
	}

	public function index()
	{
		return array('key' => 'example api.');
	}
}

?>
