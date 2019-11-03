<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\contracts\repository\article;

interface CategoryRepositoryInterface
{
	public function all($cat_id, $columns, $size);

	public function detail($cat_id, $columns);

	public function create(array $data);

	public function update(array $data);

	public function delete($id);
}


?>
