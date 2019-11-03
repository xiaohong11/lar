<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
class Express
{
	private $expressname = array();

	public function __construct()
	{
		$this->expressname = $this->expressname();
	}

	private function getcontent($url)
	{
		if (function_exists('file_get_contents')) {
			$file_contents = file_get_contents($url);
		}
		else {
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
		}

		return $file_contents;
	}

	private function expressname()
	{
		$result = $this->getcontent('http://www.kuaidi100.com/');
		preg_match_all('/data\\-code\\="(?P<name>\\w+)"\\>\\<span\\>(?P<title>.*)\\<\\/span>/iU', $result, $data);
		$name = array();

		foreach ($data['title'] as $k => $v) {
			$name[$v] = $data['name'][$k];
		}

		return $name;
	}

	private function json_array($json)
	{
		if ($json) {
			foreach ((array) $json as $k => $v) {
				$data[$k] = !is_string($v) ? $this->json_array($v) : $v;
			}

			return $data;
		}
	}

	public function getorder($name, $order, $kuaidi100key)
	{
		@$keywords = $name;
		$result = $this->getcontent('http://www.kuaidi100.com/query?type=' . $keywords . '&postid=' . $order);
		$result = json_decode($result);

		if ($result->status == 201) {
			$result = $this->getcontent('http://api.kuaidi100.com/api?id=' . $kuaidi100key . '&com=' . $keywords . '&nu=' . $order . '&show=0&muti=1&order=desc');
			$result = json_decode($result);
		}

		$data = $this->json_array($result);
		return $data;
	}
}

$express_name = trim($_POST['com']);
$express_no = trim($_POST['nu']);
include_once '../../data/kuaidi_key.php';
include_once 'kuaidi_config.php';
$express = new Express();
$result = $express->getorder($postcom, $express_no, $kuaidi100key);
$express_info = '<table style="border:1px; solid #90BFFF; width:100%;border-collapse:collapse;border-spacing:0; float:left;">';
if (($result['status'] == 1) || ($result['status'] == 200)) {
	$data = array_reverse($result['data']);

	foreach ($data as $key => $val) {
		$express_info .= '<tr style="height:20px;">';
		$express_info .= '<td style=\'text-align:right;width:140px;\'>' . $val['time'] . '</td>';
		$express_info .= '<td>&nbsp;&nbsp;|&nbsp;&nbsp;</td>';
		$express_info .= '<td style=\'text-align:left;\'>' . $val['context'] . '</td>';
		$express_info .= '</tr>';
	}

	$express_info .= '</table>';
}
else {
	$express_info = '<span style="font-size:18px;">很抱歉，暂时无法查询此订单信息！请尝试跳转到网页查询</span><a href=' . 'http://www.kuaidi100.com/chaxun?com=' . $postcom . '&nu=' . $express_no . '><span style="color:red;">点击跳转</span></a>';
}

echo $express_info;
exit();

?>
