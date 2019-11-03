<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\product;

class ProductRepository implements \app\contracts\repository\product\ProductRepositoryInterface
{
	private $model;

	public function __construct()
	{
		$this->model = \app\models\Products::where('product_id', '<>', 0);
	}

	public function field($filed)
	{
		$this->model->select($filed);
		return $this;
	}

	public function findBy($column)
	{
		foreach ($column as $k => $v) {
			$this->model = $this->model->where($k, $v);
		}

		return $this;
	}

	public function column($column)
	{
		$row = $this->model->select($column)->first();

		if ($row === null) {
			return array();
		}

		$row = $row->toArray();
		return $row[$column];
	}
}

?>
