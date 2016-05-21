<?php /* Smarty version 2.6.28, created on 2016-05-17 22:45:53
         compiled from content_en.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'content_en.tpl', 18, false),)), $this); ?>


<?php $_from = $this->_tpl_vars['cats_en']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category'] => $this->_tpl_vars['posts']):
?>
    
    <?php if (( $this->_tpl_vars['category'] != 'No matter' ) && ( $this->_tpl_vars['category'] != 'From the Editor' )): ?><p class=MsoNormal style='text-align:justify;text-indent:35.4pt'><b
style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:12.0pt;
line-height:115%;font-family:"Times New Roman","serif";mso-ansi-language:EN-US'><?php echo $this->_tpl_vars['category']; ?>
</span></b></p><?php endif; ?>
        
        
        
                <?php $_from = $this->_tpl_vars['posts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post']):
?>
            <p class=MsoNormal style='text-align:justify'>
            
                    <?php if (! $this->_tpl_vars['post']['stol']): ?>
                                                <?php if (count($this->_tpl_vars['post']['users']) > 0): ?>
                        <b style='mso-bidi-font-weight: normal'>
                            <span lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif"; mso-ansi-language:EN-US'>
                          <?php $_from = $this->_tpl_vars['post']['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['user']):
?>
                          <?php echo $this->_tpl_vars['user']['us_initials_en']; ?>
 <?php echo $this->_tpl_vars['user']['us_name_en']; ?>
<?php if (( count($this->_tpl_vars['post']['users']) - 1 ) == $this->_tpl_vars['key']): ?>. <?php else: ?>, <?php endif; ?>
                          <?php endforeach; endif; unset($_from); ?>      
                        </span></b>
                        <?php endif; ?>
                    <?php endif; ?>
                                        
            <span lang=EN-US style='font-size:12.0pt;line-height:115%; font-family:"Times New Roman","serif";mso-ansi-language:EN-US'><?php echo $this->_tpl_vars['post']['title']; ?>
<o:p></o:p></span></p>
        <?php endforeach; endif; unset($_from); ?>

<?php endforeach; endif; unset($_from); ?>

    
<p class=MsoNormal style='text-indent:35.4pt; text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"; mso-ansi-language:EN-US'>Our Contributors<o:p></o:p></span></b></p>
<?php if ($this->_tpl_vars['tom'] == 2): ?>
<p class=MsoNormal style='text-indent:35.4pt; text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"; mso-ansi-language:EN-US'>Information for Contributors<o:p></o:p></span></b></p>
<?php endif; ?>
<p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
normal'><span lang=EN-US style='font-size:12.0pt;line-height:115%;font-family:
"Times New Roman","serif";mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></b></p>