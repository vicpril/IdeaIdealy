<?php /* Smarty version 2.6.28, created on 2015-12-21 09:56:45
         compiled from content.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'content.tpl', 9, false),)), $this); ?>


<?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['user']):
?>   
    <b><span style='font-size:12.0pt;line-height:115%;
font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
color:black;mso-fareast-language:RU'></span></b><span
style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-fareast-language:
RU'><?php if ($this->_tpl_vars['user']['email_host'] != 'localhost.lo'): ?> <?php echo $this->_tpl_vars['user']['email']; ?>
<?php if (( count($this->_tpl_vars['users']) - 1 ) > $this->_tpl_vars['i']): ?>, <?php endif; ?><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>


<?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>   
    <p><b><span style='font-size:12.0pt;line-height:115%;
font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
color:black;mso-fareast-language:RU'><?php echo $this->_tpl_vars['user']['us_full_name']; ?>
</span></b><span
style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-fareast-language:
RU'><?php if ($this->_tpl_vars['user']['email']): ?><?php if ($this->_tpl_vars['user']['email_host'] != 'localhost.lo'): ?> <?php echo $this->_tpl_vars['user']['email']; ?>
<?php else: ?><span
style='color: red'> Нет e-mail'a</span><?php endif; ?><?php else: ?><span
style='color: red'> Нет e-mail'a</span><?php endif; ?></p>

<?php endforeach; endif; unset($_from); ?>
