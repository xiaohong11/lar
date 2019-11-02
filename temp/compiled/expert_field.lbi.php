
<?php if ($this->_var['ad_child']): ?>
<div class="master-channel" id="master">
	<div class="ftit"><h3>达人专区</h3></div>
	<div class="master-con">
	<?php $_from = $this->_var['ad_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_15806200_1572699756');$this->_foreach['noad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['noad']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_15806200_1572699756']):
        $this->_foreach['noad']['iteration']++;
?>
		<div class="m-c-item m-c-i-<?php echo $this->_foreach['noad']['iteration']; ?>"<?php if ($this->_var['ad_0_15806200_1572699756']['ad_bg_code']): ?> style="background:url(<?php echo $this->_var['ad_0_15806200_1572699756']['ad_bg_code']; ?>) center center no-repeat;"<?php endif; ?>>
			<div class="m-c-main">
				<div class="title">
					<h3><?php echo $this->_var['ad_0_15806200_1572699756']['b_title']; ?></h3>
					<span><?php echo $this->_var['ad_0_15806200_1572699756']['s_title']; ?></span>
				</div>
				<a href="<?php echo $this->_var['ad_0_15806200_1572699756']['ad_link']; ?>" class="m-c-btn" target="_blank">去见识</a>
			</div>
			<div class="img"><a href="<?php echo $this->_var['ad_0_15806200_1572699756']['ad_link']; ?>" target="_blank"><img src="<?php echo $this->_var['ad_0_15806200_1572699756']['ad_code']; ?>" style="max-width:<?php echo $this->_var['ad_0_15806200_1572699756']['ad_width']; ?>px; max-height:<?php echo $this->_var['ad_0_15806200_1572699756']['ad_height']; ?>px;"></a></div>
		</div>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>		
	</div>
</div>
<?php endif; ?>