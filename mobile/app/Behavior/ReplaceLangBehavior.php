<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\behavior;

class ReplaceLangBehavior
{
	private $model;

	public function run()
	{
		if (is_dir(APP_DRP_PATH)) {
			$this->model = new \app\libraries\Mysql();
			$condition['code'] = 'custom_distribution';
			$condition2['code'] = 'custom_distributor';
			$this->custom = $this->model->table('drp_config')->where($condition)->getField('value');
			$this->customs = $this->model->table('drp_config')->where($condition2)->getField('value');
			config('custom', $this->custom);
			config('customs', $this->customs);
			$coustomes = L();

			if (is_array($coustomes)) {
				foreach ($coustomes as $key => $val) {
					L($key, str_replace('分销', $this->custom, str_replace('分销商', $this->customs, $val)));
				}
			}
		}
	}
}


?>
