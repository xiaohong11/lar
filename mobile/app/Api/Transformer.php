<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api;

class Transformer implements \app\contracts\transformer\TransformerInterface
{
	/**
     * @var array
     */
	protected $_hidden = array();
	/**
     * @var array
     */
	protected $_map = array();

	public function setHidden(array $hidden = array())
	{
		$this->_hidden = $hidden;
	}

	public function setMap(array $map = array())
	{
		$this->_map = $map;
	}

	public function transformer(array $data = array())
	{
		return $data;
	}
}
//cichengxupojielaiziyujinmengwangluo banquanshuyushanghaishangchuangsuoyou jinzhidaomai yijingfaxiantingzhirenhefuwu
?>
