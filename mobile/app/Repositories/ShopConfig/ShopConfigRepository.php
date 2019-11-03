<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\shopconfig;

class ShopConfigRepository implements \app\contracts\repository\shopconfig\ShopConfigRepositoryInterface
{
	public function getShopConfig()
	{
		$shopConfig = cache('shop_config');

		if (empty($shopConfig)) {
			$shopConfig = \app\models\ShopConfig::get()->toArray();
			cache('shop_config', $shopConfig, array('expire' => 3600));
		}

		return $shopConfig;
	}

	public function getShopConfigByCode($code)
	{
		$shopConfig = $this->getShopConfig();

		foreach ($shopConfig as $v) {
			if ($v['code'] == $code) {
				return $v['value'];
			}
		}
	}
}

?>
