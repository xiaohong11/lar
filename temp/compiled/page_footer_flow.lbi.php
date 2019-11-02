
<div class="footer user-footer">
	<div class="dsc-copyright">
		<div class="w w1200">
			<?php if ($this->_var['navigator_list']['bottom']): ?> 
			<p class="footer-ecscinfo pb10">
				<?php $_from = $this->_var['navigator_list']['bottom']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_bottom_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_bottom_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_bottom_list']['iteration']++;
?> 
				<a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a> 
				<?php if (! ($this->_foreach['nav_bottom_list']['iteration'] == $this->_foreach['nav_bottom_list']['total'])): ?> 
				| 
				<?php endif; ?> 
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
			</p>
			<?php endif; ?> 
			<?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?>
			<p class="footer-otherlink">	
				<?php $_from = $this->_var['img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
				<a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" border="0" /></a>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				<?php if ($this->_var['txt_links']): ?>
				<?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');$this->_foreach['nolink'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nolink']['total'] > 0):
    foreach ($_from AS $this->_var['link']):
        $this->_foreach['nolink']['iteration']++;
?>
				<a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a>
				<?php if (! ($this->_foreach['nolink']['iteration'] == $this->_foreach['nolink']['total'])): ?> 
				| 
				<?php endif; ?> 
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				<?php endif; ?>
			</p>
			<?php endif; ?>
			<?php if ($this->_var['icp_number']): ?> 
			<p class="copyright_info"><?php echo $this->_var['lang']['icp_number']; ?>:<a href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $this->_var['icp_number']; ?></a> POWERED BY<a href="http://www.dscmall.cn/" target="_blank">大商创</a>2.0</p>
			<?php endif; ?>
		</div>
	</div>
    
    
    <div class="hidden">
        <input type="hidden" name="seller_kf_IM" value="<?php echo $this->_var['shop_information']['is_IM']; ?>" rev="<?php echo $this->_var['site_domain']; ?>" ru_id="<?php echo $_GET['merchant_id']; ?>" />
        <input type="hidden" name="seller_kf_qq" value="<?php echo $this->_var['basic_info']['kf_qq']; ?>" />
        <input type="hidden" name="seller_kf_tel" value="<?php echo $this->_var['basic_info']['kf_tel']; ?>" />
        <input type="hidden" name="user_id" value="<?php echo empty($_SESSION['user_id']) ? '0' : $_SESSION['user_id']; ?>" />
    </div>
</div>

<?php echo $this->smarty_insert_scripts(array('files'=>'scroll_city.js')); ?>