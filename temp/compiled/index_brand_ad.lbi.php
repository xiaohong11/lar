
<div class="brand-channel clearfix" id="h-brand">
	<?php 
$k = array (
  'name' => 'get_adv_child',
  'ad_arr' => $this->_var['index_brand_banner'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
	<?php 
$k = array (
  'name' => 'recommend_brands',
  'num' => '17',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
</div>
