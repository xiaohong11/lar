<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api\foundation;

class Controller extends \app\http\base\controllers\Frontend
{
	protected function apiReturn($data, $code = 0)
	{
		return array('code' => $code, 'data' => $data);
	}

	protected function validate($args, $pattern)
	{
		$validator = Validation::createValidation();
		$rules = Validation::transPattern($pattern);

		if ($validator->validate($rules)->create($args) === false) {
			return $validator->getError();
		}
		else {
			return true;
		}
	}
}

?>
