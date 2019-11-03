<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace OSS\Http;

class ResponseCore
{
	/**
     * Stores the HTTP header information.
     */
	public $header;
	/**
     * Stores the SimpleXML response.
     */
	public $body;
	/**
     * Stores the HTTP response code.
     */
	public $status;

	public function __construct($header, $body, $status = NULL)
	{
		$this->header = $header;
		$this->body = $body;
		$this->status = $status;
		return $this;
	}

	public function isOK($codes = array(200, 201, 204, 206))
	{
		if (is_array($codes)) {
			return in_array($this->status, $codes);
		}

		return $this->status === $codes;
	}
}


?>
