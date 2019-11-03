<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\goods;

class VolumePriceRepository implements \app\contracts\repository\goods\VolumePriceRepositoryInterface
{
	public function allVolumes($goods_id, $price_type)
	{
		$res = \app\models\VolumePrice::where('goods_id', $goods_id)->where('price_type', $price_type)->orderBy('volume_number')->get()->toArray();
		return $res;
	}
}

?>
