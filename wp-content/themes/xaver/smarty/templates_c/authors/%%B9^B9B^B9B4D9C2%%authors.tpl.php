<?php /* Smarty version 2.6.28, created on 2015-12-20 16:26:47
         compiled from authors.tpl */ ?>

<body lang=RU style='tab-interval:35.4pt'>

<p class=MsoNormal align=center style='mso-margin-top-alt:auto;margin-bottom:
25.0pt;text-align:center;line-height:normal'><b><span style='font-size:12.0pt;
font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
color:black;mso-fareast-language:RU'>НАШИ АВТОРЫ<o:p></o:p></span></b></p>

<p class=MsoNormal>
    
 <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>   
    <b><span style='font-size:12.0pt;line-height:115%;
font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
color:black;mso-fareast-language:RU'><?php echo $this->_tpl_vars['user']['us_full_name']; ?>
</span></b><span
style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-fareast-language:
RU'><?php if ($this->_tpl_vars['user']['post']): ?>, <?php echo $this->_tpl_vars['user']['post']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['user']['job_adress']): ?>, <?php echo $this->_tpl_vars['user']['job_adress']; ?>
<?php endif; ?><br><br>

    
    
<?php endforeach; endif; unset($_from); ?>