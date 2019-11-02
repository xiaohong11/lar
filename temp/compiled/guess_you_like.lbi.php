
<div class="lift-channel clearfix" id="guessYouLike">
	<div class="ftit"><h3>还没逛够</h3></div>
	<ul>
		<?php $_from = $this->_var['guess_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['foo']['iteration']++;
?>
		<li class="opacity_img">
			<a href="<?php echo $this->_var['goods']['url']; ?>">
				<div class="p-img"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>"></div>
				<div class="p-name" title="<?php echo htmlspecialchars($this->_var['goods']['short_name']); ?>"><?php echo htmlspecialchars($this->_var['goods']['short_name']); ?></div>
				<div class="p-price">
					<div class="shop-price"><?php echo $this->_var['goods']['shop_price']; ?></div>
					<div class="original-price"><?php echo $this->_var['goods']['market_price']; ?></div>
				</div>
			</a>
		</li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</ul>
</div>