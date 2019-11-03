<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\article\controllers;

class Category extends \app\api\foundation\Controller
{
	protected $category;

	public function __construct(\app\repositories\article\CategoryRepository $category)
	{
		parent::__construct();
		$this->category = $category;
	}

	public function actionList(array $args)
	{
		return $this->category->all($args['id']);
	}

	public function actionGet(array $args)
	{
		return $this->category->detail($args['id']);
	}
}

?>
