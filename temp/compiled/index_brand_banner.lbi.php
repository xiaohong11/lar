<?php $_from = $this->_var['ad_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_15418100_1572699756');$this->_foreach['noad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['noad']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_15418100_1572699756']):
        $this->_foreach['noad']['iteration']++;
?>
<div class="home-brand-adv slide_lr_info"><a href="<?php echo $this->_var['ad_0_15418100_1572699756']['ad_link']; ?>" target="_blank"><img src="<?php echo $this->_var['ad_0_15418100_1572699756']['ad_code']; ?>" width="<?php echo $this->_var['ad_0_15418100_1572699756']['ad_width']; ?>" height="<?php echo $this->_var['ad_0_15418100_1572699756']['ad_height']; ?>" class="slide_lr_img"></a></div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
