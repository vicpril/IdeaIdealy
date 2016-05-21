<?php /* Smarty version 2.6.28, created on 2016-05-17 22:45:53
         compiled from content_ru.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'content_ru.tpl', 17, false),array('modifier', 'strlen', 'content_ru.tpl', 21, false),)), $this); ?>


<?php $_from = $this->_tpl_vars['cats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category'] => $this->_tpl_vars['posts']):
?>
    
    <?php if (( $this->_tpl_vars['category'] != 'Без рубрики' ) && ( $this->_tpl_vars['category'] != 'От автора' ) && ( $this->_tpl_vars['category'] != 'От редактора' )): ?><p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"'><?php echo $this->_tpl_vars['category']; ?>
<o:p></o:p></span></b></p><?php endif; ?>
        
        
        
                <?php $_from = $this->_tpl_vars['posts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post']):
?>
            <p class=MsoNormal style='text-align:justify'>
            
                    <?php if (! $this->_tpl_vars['post']['stol']): ?>
                                                <?php if (count($this->_tpl_vars['post']['users']) > 0): ?>
                        <b style='mso-bidi-font-weight: normal'>
                            <span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"'>
                          <?php $_from = $this->_tpl_vars['post']['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['user']):
?>
                          <?php if (( strlen($this->_tpl_vars['user']['us_initials']) ) < 4): ?><?php echo $this->_tpl_vars['user']['us_first_name']; ?>
 <?php else: ?><?php echo $this->_tpl_vars['user']['us_initials']; ?>
 <?php endif; ?> <?php echo $this->_tpl_vars['user']['us_last_name']; ?>
<?php if (( count($this->_tpl_vars['post']['users']) - 1 ) == $this->_tpl_vars['key']): ?>. <?php else: ?>, <?php endif; ?>
                          <?php endforeach; endif; unset($_from); ?>      
                        </span></b>
                        <?php endif; ?>
                    <?php endif; ?>
                                        
            <span class="" style='font-size:12.0pt;line-height:115%;
                    font-family:"Times New Roman","serif"'><?php echo $this->_tpl_vars['post']['title']; ?>
<?php if (( $this->_tpl_vars['post']['title'] == 'От редактора' ) || ( $this->_tpl_vars['post']['title'] == 'От автора' )): ?> [1 том]<?php endif; ?><o:p></o:p></span></p>
        <?php endforeach; endif; unset($_from); ?>

<?php endforeach; endif; unset($_from); ?>




<p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"'>Наши
авторы<o:p></o:p></span></b></p>
<?php if ($this->_tpl_vars['tom'] == 2): ?>
<p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"'>Информация
для авторов [2 том<a name="_GoBack"></a>]<o:p></o:p></span></b></p>
<?php endif; ?>

<p class=MsoNormal style='text-indent:1.0cm'><span style='font-size:10.0pt'><o:p>&nbsp;</o:p></span></p>


<span style='font-size:11.0pt;line-height:115%;
font-family:"Times New Roman","serif;mso-ascii-theme-font:minor-latin;mso-fareast-font-family:
Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;
mso-bidi-font-family:"Times New Roman";mso-bidi-theme-font:minor-bidi;
mso-ansi-language:RU;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><br
clear=all style='mso-special-character:line-break;page-break-before:always'>
</span>