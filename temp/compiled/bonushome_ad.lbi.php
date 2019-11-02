<?php if ($this->_var['ad_child']): ?>
<?php $_from = $this->_var['ad_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad_0_16589000_1572699756');$this->_foreach['noad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['noad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad_0_16589000_1572699756']):
        $this->_foreach['noad']['iteration']++;
?>
<?php if ($this->_var['ad_0_16589000_1572699756']['ad_code']): ?>
<div class="ejectAdv" ectype="ejectAdv">
    <div class="ejectAdvbg"></div>
    <div class="ejectAdvimg">
            <a href="<?php echo $this->_var['ad_0_16589000_1572699756']['ad_link']; ?>" target="_blank"><img src="<?php echo $this->_var['ad_0_16589000_1572699756']['ad_code']; ?>"></a>
        <a href="javascript:void(0);" class="ejectClose" ectype="ejectClose"></a>
    </div>
</div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>