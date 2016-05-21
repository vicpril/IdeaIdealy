<?php /* Smarty version 2.6.28, created on 2016-01-24 19:10:56
         compiled from article.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'article.tpl', 25, false),)), $this); ?>



<p class=MsoNoSpacing align=right style='text-align:right;text-indent:35.45pt'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'>УДК <?php echo $this->_tpl_vars['art_udk']; ?>
<o:p></o:p></span></p>

<p class=MsoNoSpacing align=center style='text-align:center;text-indent:35.45pt'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNoSpacing align=center style='text-align:center;text-indent:35.45pt'><b
style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;font-family:
"Times New Roman","serif"; text-transform: uppercase;'><?php echo $this->_tpl_vars['art_title']; ?>
<?php if ($this->_tpl_vars['art_fin']): ?><sup>1</sup><?php endif; ?><o:p></o:p></span></b></p>

<p class=MsoNoSpacing align=center style='text-align:center;text-indent:35.45pt'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<?php if (! $this->_tpl_vars['art_stol']): ?>
<?php $_from = $this->_tpl_vars['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['job']):
?>
    
    <p class=MsoNoSpacing align=right style='text-align:right;text-indent:35.45pt'><b
    style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;font-family:
    "Times New Roman","serif"'>
                <?php $_from = $this->_tpl_vars['job']['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['user_id']):
?>
                <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_initials']; ?>
 <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_last_name']; ?>
<?php if (( count($this->_tpl_vars['job']['user']) - 1 ) > $this->_tpl_vars['index']): ?>, <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            </span><o:p></o:p></span></b></p>

    <p class=MsoNoSpacing align=right style='text-align:right;text-indent:35.45pt'><span
    style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

    <p class=MsoNoSpacing align=right style='margin-left:212.65pt;text-align:right;
    text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'><?php echo $this->_tpl_vars['job']['job_name']; ?>
<?php if ($this->_tpl_vars['job']['job_city']): ?>, <?php echo $this->_tpl_vars['job']['job_city']; ?>
<?php endif; ?><o:p></o:p></span></p>

    <p class=MsoNoSpacing align=right style='margin-left:212.65pt;text-align:right;
    text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>
            <?php $_from = $this->_tpl_vars['job']['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['user_id']):
?>
                <?php if ($this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['email_host'] != 'localhost.lo'): ?>
                <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['email']; ?>
<?php if (( count($this->_tpl_vars['job']['user']) - 1 ) > $this->_tpl_vars['index']): ?>, <?php endif; ?>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            <o:p></o:p></span></p>

    <p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
    text-indent:35.45pt'><i style='mso-bidi-font-style:normal'><span
    style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></i></p>
    
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><i style='mso-bidi-font-style:normal'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></i></p>


<div class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'><?php echo $this->_tpl_vars['art_notice']; ?>
<o:p></o:p></span></div>


<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><b style='mso-bidi-font-weight:normal'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'>Ключевые слова</span></b><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'>: <span
class=SpellE><?php echo $this->_tpl_vars['art_keywords']; ?>
<o:p></o:p></span></p>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black'><o:p>&nbsp;</o:p></span></p>


<div class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'><?php echo $this->_tpl_vars['art_text']; ?>
<o:p></o:p></span></div>
<?php if ($this->_tpl_vars['art_fin']): ?><div>_____________________________<p><sup>1</sup> <span><?php echo $this->_tpl_vars['art_fin']; ?>
<span></p></div><?php endif; ?>



<p class=MsoNoSpacing style='text-indent:35.45pt'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>Литература<o:p></o:p></span></b></p>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<div class=MsoNoSpacing style='margin-left:0.0cm;text-align:justify;text-justify:
inter-ideograph;text-indent: 1.25cm'><span lang=EN-US style='font-size:12.0pt;
font-family:"Times New Roman","serif";mso-ansi-language:EN-US'><?php echo $this->_tpl_vars['art_lit']; ?>
<o:p></o:p></span></div>
            





<p class=MsoNoSpacing align=center style='text-align:center'><b
style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:12.0pt;
font-family:"Times New Roman","serif";mso-ansi-language:EN-US; text-transform: uppercase;'><?php echo $this->_tpl_vars['art_title_en']; ?>
<o:p></o:p></span></b></p>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<?php if (! $this->_tpl_vars['art_stol']): ?>
<?php $_from = $this->_tpl_vars['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['job']):
?>
    
    <p class=MsoNoSpacing align=right style='text-align:right;text-indent:35.45pt'><b
    style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;font-family:
    "Times New Roman","serif"'>
                <?php $_from = $this->_tpl_vars['job']['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['user_id']):
?>
                <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_initials_en']; ?>
 <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_name_en']; ?>
<?php if (( count($this->_tpl_vars['job']['user']) - 1 ) > $this->_tpl_vars['index']): ?>, <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            </span><o:p></o:p></span></b></p>

    
    <p class=MsoNoSpacing align=right style='margin-left:212.65pt;text-align:right;
    text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'><?php echo $this->_tpl_vars['job']['job_name_en']; ?>
<?php if ($this->_tpl_vars['job']['job_city_en']): ?>, <?php echo $this->_tpl_vars['job']['job_city_en']; ?>
<?php endif; ?><o:p></o:p></span></p>

    <p class=MsoNoSpacing align=right style='margin-left:212.65pt;text-align:right;
    text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>
            <?php $_from = $this->_tpl_vars['job']['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['user_id']):
?>
                <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['email']; ?>
<?php if (( count($this->_tpl_vars['job']['user']) - 1 ) > $this->_tpl_vars['index']): ?>, <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            <o:p></o:p></span></p>

    <p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
    text-indent:35.45pt'><i style='mso-bidi-font-style:normal'><span
    style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></i></p>
    
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>


<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>


<div class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-ansi-language:EN-US'><?php echo $this->_tpl_vars['art_notice_en']; ?>
<o:p></o:p></span></div>


<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><b style='mso-bidi-font-weight:normal'><span lang=EN-US
style='font-size:12.0pt;font-family:"Times New Roman","serif";mso-fareast-font-family:
"Times New Roman";color:black;mso-ansi-language:EN-US'>Keywords</span></b><span
lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-ansi-language:EN-US'>: <?php echo $this->_tpl_vars['art_key_en']; ?>
<o:p></o:p></span></p>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph'><span
lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNoSpacing style='text-indent:35.45pt'><b style='mso-bidi-font-weight:
normal'><span lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-ansi-language:EN-US'>References<o:p></o:p></span></b></p>

<div class=MsoNoSpacing style='margin-left:0.0cm;text-align:justify;text-justify:
inter-ideograph;text-indent: 1.25cm'><span lang=EN-US style='font-size:12.0pt;
font-family:"Times New Roman","serif";mso-ansi-language:EN-US'><?php echo $this->_tpl_vars['art_lit_en']; ?>
<o:p></o:p></span></div>


<span style='font-size:11.0pt;line-height:115%;
font-family:"Times New Roman","serif;mso-ascii-theme-font:minor-latin;mso-fareast-font-family:
Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;
mso-bidi-font-family:"Times New Roman";mso-bidi-theme-font:minor-bidi;
mso-ansi-language:RU;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><br
clear=all style='mso-special-character:line-break;page-break-before:always'>
</span>