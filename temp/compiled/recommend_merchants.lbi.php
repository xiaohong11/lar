<?php if ($this->_var['ad_child']): ?>
<?php if ($this->_var['cat_id']): ?>
	<div class="selectbrand" id="selectbrand">
		<div class="sb-hd">
			<h2>精选大牌</h2>
		</div>
		<div class="sb-bd">
			<div class="selectbrand-slide">
				<a href="javascript:;" class="prev"><i class="iconfont icon-left"></i></a>
				<a href="javascript:;" class="next"><i class="iconfont icon-right"></i></a>
				<div class="hd">
					<ul></ul>
				</div>
				<div class="bd">
					<ul>
						<?php $_from = $this->_var['ad_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_15972200_1572699756');$this->_foreach['noad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['noad']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_15972200_1572699756']):
        $this->_foreach['noad']['iteration']++;
?>
						<li>
							<a href="<?php echo $this->_var['ad_0_15972200_1572699756']['ad_link']; ?>">
								<img src="<?php echo $this->_var['ad_0_15972200_1572699756']['ad_code']; ?>" width="<?php echo $this->_var['ad_0_15972200_1572699756']['ad_width']; ?>" height="<?php echo $this->_var['ad_0_15972200_1572699756']['ad_height']; ?>" alt="" class="cover">
								<div class="logo-wrap"><div class="sbs-logo"><img src="<?php echo $this->_var['ad_0_15972200_1572699756']['ad_bg_code']; ?>" alt=""></div></div>
								<div class="intro">
									<span><?php echo $this->_var['ad_0_15972200_1572699756']['b_title']; ?></span>
									<em><?php echo $this->_var['ad_0_15972200_1572699756']['s_title']; ?></em>
								</div>
							</a>
						</li>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
<div class="store-channel" id="storeRec">
	<div class="ftit"><h3><?php echo $this->_var['lang']['recommended_store']; ?></h3></div>
	<div class="rec-store-list">
		<?php $_from = $this->_var['ad_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_15978300_1572699756');$this->_foreach['noad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['noad']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_15978300_1572699756']):
        $this->_foreach['noad']['iteration']++;
?>
		<div class="rec-store-item opacity_img">
			<a href="<?php echo $this->_var['ad_0_15978300_1572699756']['ad_link']; ?>" target="_blank">
            <div class="p-img"><img src="<?php echo $this->_var['ad_0_15978300_1572699756']['ad_code']; ?>" width="<?php echo $this->_var['ad_0_15978300_1572699756']['ad_width']; ?>" height="<?php echo $this->_var['ad_0_15978300_1572699756']['ad_height']; ?>"></div>
            <div class="info">
                <div class="s-logo"><div class="img"><img src="<?php echo $this->_var['ad_0_15978300_1572699756']['ad_bg_code']; ?>"></div></div>
                <div class="s-title">
                        <div class="tit"><?php echo $this->_var['ad_0_15978300_1572699756']['b_title']; ?></div>
                    <div class="ui-tit"><?php echo $this->_var['ad_0_15978300_1572699756']['s_title']; ?></div>
                </div>
            </div>
			</a>
		</div>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</div>
</div>
<?php endif; ?>
<?php endif; ?>