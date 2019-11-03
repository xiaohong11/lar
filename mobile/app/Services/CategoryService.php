<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\services;

class CategoryService
{
	private $categoryRepository;

	public function __construct(\app\repositories\category\CategoryRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function categoryList()
	{
		$list = $this->categoryRepository->getAllCategorys();
		return $list;
	}
}


?>
