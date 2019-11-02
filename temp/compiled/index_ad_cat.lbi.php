<?php if ($this->_var['ad_child']): ?>
<div class="need-channel clearfix" id="h-need">
<?php $_from = $this->_var['ad_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_15273100_1572699756');$this->_foreach['noad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['noad']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_15273100_1572699756']):
        $this->_foreach['noad']['iteration']++;
?>
<?php if ($this->_foreach['noad']['iteration'] < 6): ?>
<div class="channel-column" style="background:url(<?php echo $this->_var['ad_0_15273100_1572699756']['ad_bg_code']; ?>) no-repeat;">
	<div class="column-title">
		<h3><?php echo $this->_var['ad_0_15273100_1572699756']['b_title']; ?></h3>
		<p><?php echo $this->_var['ad_0_15273100_1572699756']['s_title']; ?></p>
	</div>
	<div class="column-img"><img src="<?php echo $this->_var['ad_0_15273100_1572699756']['ad_code']; ?>"></div>
	<a href="<?php echo $this->_var['ad_0_15273100_1572699756']['ad_link']; ?>" target="_blank" class="column-btn">去看看</a>
</div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>
<input type="hidden" value="<?php if ($this->_var['ad_child']): ?>1<?php else: ?>0<?php endif; ?>" name="index_ad_cat"/>