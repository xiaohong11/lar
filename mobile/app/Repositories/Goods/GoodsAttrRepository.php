<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\goods;

class GoodsAttrRepository implements \app\contracts\repository\goods\GoodsAttrRepositoryInterface
{
	public function propertyPrice($property)
	{
		if (!empty($property)) {
			if (is_array($property)) {
				foreach ($property as $key => $val) {
					if (strpos($val, ',')) {
						$property = explode(',', $val);
					}
					else {
						$property[$key] = addslashes($val);
					}
				}
			}
			else {
				$property = addslashes($property);
			}

			$price = \app\models\GoodsAttr::wherein('goods_attr_id', $property)->sum('attr_price');
		}
		else {
			$price = 0;
		}

		return empty($price) ? 0 : $price;
	}
}

?>
