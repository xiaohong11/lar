<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\user;

class AddressRepository implements \app\contracts\repository\user\AddressRepositoryInterface
{
	public function addressListByUserId($id)
	{
		return \app\models\UserAddress::select('*')->where('user_id', $id)->get()->toArray();
	}

	public function find($address_id)
	{
		$address = \app\models\UserAddress::where('address_id', $address_id)->first();

		if ($address_id === null) {
			return array();
		}

		return $address;
	}
}

?>
