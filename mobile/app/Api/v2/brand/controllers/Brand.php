<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\brand\controllers;

class Brand extends \app\api\foundation\Controller
{
	/** @var  $brand */
	protected $brand;
	/** @var $brandTransformer */
	protected $brandTransformer;

	public function __construct(\app\repositories\brand\BrandRepository $brand, \app\api\v2\brand\transformer\BrandTransformer $brandTransformer)
	{
		parent::__construct();
		$this->brand = $brand;
		$this->brandTransformer = $brandTransformer;
	}

	public function actionList()
	{
		$data = $this->brand->getAllBrands();
		return $this->apiReturn($data);
	}

	public function actionGet(array $args)
	{
		$pattern = array('id' => 'require');
		$this->validate($args, $pattern);
		$data = $this->brand->getBrandDetail($args['id']);
		return $this->apiReturn($data);
	}
}

?>
