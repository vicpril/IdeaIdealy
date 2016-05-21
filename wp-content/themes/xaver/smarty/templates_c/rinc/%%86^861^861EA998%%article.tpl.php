<?php /* Smarty version 2.6.28, created on 2016-04-23 13:09:21
         compiled from article.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strlen', 'article.tpl', 35, false),array('modifier', 'count', 'article.tpl', 35, false),)), $this); ?>

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'>Статья <?php echo $this->_tpl_vars['art_pos']; ?>
<o:p></o:p></span></p>

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'>Рубрика <span style='text-transform:
uppercase'><?php echo $this->_tpl_vars['art_cat']; ?>
</span><o:p></o:p></span></p>

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'>Стр. <?php if ($this->_tpl_vars['art_f_page']): ?><?php echo $this->_tpl_vars['art_f_page']; ?>
<?php else: ?><span style="background:red;">&nbsp;&nbsp;</span><?php endif; ?>-<?php if ($this->_tpl_vars['art_l_page']): ?><?php echo $this->_tpl_vars['art_l_page']; ?>
<?php else: ?><span style="background:red;">&nbsp;&nbsp;</span><?php endif; ?></span><span lang=EN-US
style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-ansi-language:
EN-US;mso-fareast-language:RU'><o:p></o:p></span></p>

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>
<?php if (! $this->_tpl_vars['art_stol']): ?>
<?php if ($this->_tpl_vars['users']): ?>


    <?php if ($this->_tpl_vars['art_multy_job'] == false): ?>
        
            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";mso-fareast-language:RU'>
        <?php $_from = $this->_tpl_vars['jobs'][0]['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['user_id']):
?>
                    <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_last_name']; ?>
 <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_first_name']; ?>
<?php if (( strlen($this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_first_name']) ) - 1 == 1): ?>.<?php endif; ?> <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_patronymic']; ?>
<?php if (strlen($this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_patronymic']) - 1 == 1): ?>.<?php endif; ?><?php if (count($this->_tpl_vars['jobs'][0]['user']) - 1 > $this->_tpl_vars['i']): ?>, <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>             
            <span style='text-transform:uppercase'><o:p></o:p></span></span></p>


            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";text-transform:uppercase;mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>

            <p class=MsoNormal style='text-indent:0.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span
            class=SpellE><span style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";
            mso-fareast-language:RU'><?php echo $this->_tpl_vars['jobs'][0]['job_name']; ?>
, </p><p class=MsoNormal style='text-indent:0.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span
            class=SpellE><span style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";
            mso-fareast-language:RU'><?php echo $this->_tpl_vars['jobs'][0]['job_adress']; ?>
</p>

    <?php else: ?>
            
          
            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><sup><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";mso-fareast-language:RU'></span></sup><span
            style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:
            RU'><?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['user']):
?>  
                <?php echo $this->_tpl_vars['user']['us_last_name']; ?>
 <?php echo $this->_tpl_vars['user']['us_first_name']; ?>
<?php if (( strlen($this->_tpl_vars['user']['us_first_name']) ) - 1 == 1): ?>.<?php endif; ?> <?php echo $this->_tpl_vars['user']['us_patronymic']; ?>
<?php if (strlen($this->_tpl_vars['user']['us_patronymic']) - 1 == 1): ?>.<?php endif; ?><sup><?php $_from = $this->_tpl_vars['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['job']):
?><?php if ($this->_tpl_vars['user']['job_id'] == $this->_tpl_vars['job']['id']): ?><?php echo $this->_tpl_vars['k']+1; ?>
<?php endif; ?><?php endforeach; endif; unset($_from); ?></sup><?php if (( count($this->_tpl_vars['users']) - 1 ) > $this->_tpl_vars['user']['index']): ?>, <?php endif; ?>
                
        <?php endforeach; endif; unset($_from); ?>
        <span style='text-transform:uppercase'><o:p></o:p></span></span></p>
        
            
            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";text-transform:uppercase;mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>
        
            
            
        <?php $_from = $this->_tpl_vars['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['job']):
?>
            <p class=MsoNormal style='tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><sup><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";mso-fareast-language:RU'><?php echo $this->_tpl_vars['i']+1; ?>
</span></sup><span
            style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:
            RU'><?php echo $this->_tpl_vars['job']['job_name']; ?>
, </p><p class=MsoNormal style='tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><sup></sup><span
            style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:
            RU'><?php echo $this->_tpl_vars['job']['job_adress']; ?>
<o:p></o:p></span></p>
        <?php endforeach; endif; unset($_from); ?>
            
    <?php endif; ?>
    

    

        
        

    
    <?php if ($this->_tpl_vars['email_on']): ?>
            <span style='mso-bookmark:OLE_LINK2'></span><span style='mso-bookmark:OLE_LINK1'></span>

            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>

            <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['user']):
?>
            <?php if ($this->_tpl_vars['user']['email_host'] != 'localhost.lo'): ?>
            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";mso-fareast-language:RU'><?php if (count($this->_tpl_vars['users']) > 1): ?><?php echo $this->_tpl_vars['user']['us_last_name']; ?>
 <?php endif; ?><?php echo $this->_tpl_vars['user']['email']; ?>
<o:p></o:p></span></p>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>
<?php endif; ?>
<?php endif; ?>



    <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
    layout-grid-mode:char'><b style='mso-bidi-font-weight:normal'><span
    style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:
    RU'><?php echo $this->_tpl_vars['art_title']; ?>
<o:p></o:p></span></b></p>

    <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
    layout-grid-mode:char'><b style='mso-bidi-font-weight:normal'><span
    style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:
    RU'><o:p>&nbsp;</o:p></span></b></p>


<div class=MsoNormal style='margin-top:0.0pt;margin-right:0cm;margin-bottom:
0.0pt; text-indent:1.0cm;mso-hyphenate:none;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'>
<span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU;mso-bidi-font-weight:bold'>
<?php echo $this->_tpl_vars['art_notice']; ?>

<o:p></o:p></span></div>







<?php if ($this->_tpl_vars['art_udk']): ?>
<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'>УДК <?php echo $this->_tpl_vars['art_udk']; ?>
<o:p></o:p></span></p><p>&nbsp;</p>
<?php endif; ?>

<?php if ($this->_tpl_vars['art_doi']): ?>
<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span class=SpellE><span lang=EN-US style='font-size:
10.0pt;mso-fareast-font-family:"Times New Roman";mso-ansi-language:EN-US;
mso-fareast-language:RU'>DOI</span></span><span style='font-size:10.0pt;
mso-fareast-font-family:"Times New Roman";mso-fareast-language:RU'>: <?php echo $this->_tpl_vars['art_doi']; ?>
<o:p></o:p></span></p>

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>
<?php endif; ?>
<?php if ($this->_tpl_vars['art_keywords']): ?>
<p class=MsoNormal style='text-indent:1.0cm'><b style='mso-bidi-font-weight:
normal'><i style='mso-bidi-font-style:normal'><span style='font-size:10.0pt;
mso-bidi-font-size:11.0pt'>Ключевые слова: </span></i></b><span
style='font-size:10.0pt;mso-bidi-font-size:11.0pt'><?php echo $this->_tpl_vars['art_keywords']; ?>
<o:p></o:p></span></p>

<p class=MsoNormal style='text-indent:1.0cm'><span style='font-size:10.0pt;
mso-bidi-font-size:11.0pt'><o:p>&nbsp;</o:p></span></p>
<?php endif; ?>

<?php if ($this->_tpl_vars['art_lit']): ?>
<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";text-transform:
uppercase;mso-fareast-language:RU'>СПИСОК ЛИТЕРАТУРЫ<o:p></o:p></span></b></p>

<div class=MsoNormal style='margin-top:0.0pt;margin-right:0cm;margin-bottom:
0.0pt; text-indent:1.0cm;mso-hyphenate:none;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'>
<span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU;mso-bidi-font-weight:bold'>
<?php echo $this->_tpl_vars['art_lit']; ?>

<o:p></o:p></span></div>

<?php endif; ?>

<?php if ($this->_tpl_vars['art_fin']): ?>

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:RU'>Финансирование статьи<o:p></o:p></span></b></p>

<div class=MsoNormal style='margin-top:0.0pt;margin-right:0cm;margin-bottom:
0.0pt; text-indent:1.0cm;mso-hyphenate:none;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'>
<span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU;mso-bidi-font-weight:bold'>
<?php echo $this->_tpl_vars['art_fin']; ?>

<o:p></o:p></span></div>
<?php endif; ?>


<?php if ($this->_tpl_vars['art_date_arrival']): ?>
<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'>Дата</span><span style='font-size:
10.0pt;mso-fareast-font-family:"Times New Roman";mso-ansi-language:EN-US;
mso-fareast-language:RU'> </span><span style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";mso-fareast-language:RU'>поступления статьи в редакцию</span><span lang=EN-US
style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-ansi-language:
EN-US;mso-fareast-language:RU'>: <?php echo $this->_tpl_vars['art_date_arrival']; ?>
<o:p></o:p></span></p>
<?php endif; ?>

<p class=MsoNormal style='text-indent:1.0cm'><span lang=EN-US style='font-size:
10.0pt;mso-bidi-font-size:11.0pt;mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>



<p class=MsoNormal style='text-indent:1.0cm'><span style='font-size:10.0pt;
mso-bidi-font-size:11.0pt'>Рубрика</span><span style='font-size:10.0pt;
mso-bidi-font-size:11.0pt;mso-ansi-language:EN-US'> <span lang=EN-US style="text-transform: uppercase;"><?php echo $this->_tpl_vars['art_cat_en']; ?>
<o:p></o:p></span></span></p>

<p class=MsoNormal style='text-indent:1.0cm'><span lang=EN-US style='font-size:
10.0pt;mso-bidi-font-size:11.0pt;mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>


<?php if (! $this->_tpl_vars['art_stol']): ?>
<?php if ($this->_tpl_vars['users']): ?>

<?php if ($this->_tpl_vars['art_multy_job'] == false): ?>
    
        <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
        layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
        "Times New Roman";mso-fareast-language:RU'>
    <?php $_from = $this->_tpl_vars['jobs'][0]['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['user_id']):
?>
                <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_name_en']; ?>
 <?php echo $this->_tpl_vars['users'][$this->_tpl_vars['user_id']]['us_initials_en']; ?>
<?php if (count($this->_tpl_vars['jobs'][0]['user']) - 1 > $this->_tpl_vars['i']): ?>, <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>             
        <span style='text-transform:uppercase'><o:p></o:p></span></span></p>
    
    
        <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
        layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
        "Times New Roman";text-transform:uppercase;mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>
<?php if ($this->_tpl_vars['jobs'][0]['job_name_en']): ?>
        <p class=MsoNormal style='tab-stops:49.6pt 154.5pt;layout-grid-mode:char'><a
        name="OLE_LINK2"></a><a name="OLE_LINK1"><span style='mso-bookmark:OLE_LINK2'></span></a><span
        class=SpellE><span style='mso-bookmark:OLE_LINK1'><span style='mso-bookmark:
        OLE_LINK2'><span style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";
        mso-fareast-language:RU'><?php echo $this->_tpl_vars['jobs'][0]['job_name_en']; ?>
, </p><p class=MsoNormal style='tab-stops:49.6pt 154.5pt;layout-grid-mode:char'><a
        name="OLE_LINK2"></a><a name="OLE_LINK1"><span style='mso-bookmark:OLE_LINK2'></span></a><span
        class=SpellE><span style='mso-bookmark:OLE_LINK1'><span style='mso-bookmark:
        OLE_LINK2'><span style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";
        mso-fareast-language:RU'><?php echo $this->_tpl_vars['jobs'][0]['job_adress_en']; ?>
<o:p></o:p></p>
<?php endif; ?>
        
<?php else: ?>
        
    
            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><sup><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";mso-fareast-language:RU'></span></sup><span
            style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:
            RU'><?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['user']):
?>  
                <sup><?php $_from = $this->_tpl_vars['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['job']):
?><?php if ($this->_tpl_vars['user']['job_id'] == $this->_tpl_vars['job']['id']): ?><?php echo $this->_tpl_vars['k']+1; ?>
<?php endif; ?><?php endforeach; endif; unset($_from); ?></sup><?php echo $this->_tpl_vars['user']['us_name_en']; ?>
 <?php echo $this->_tpl_vars['user']['us_initials_en']; ?>
<?php if (( count($this->_tpl_vars['users']) - 1 ) > $this->_tpl_vars['user']['index']): ?>, <?php endif; ?>
                
        <?php endforeach; endif; unset($_from); ?>
        <span style='text-transform:uppercase'><o:p></o:p></span></span></p>
        
            
            <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";text-transform:uppercase;mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>
            
        <?php $_from = $this->_tpl_vars['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['job']):
?>
            <p class=MsoNormal style='tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><sup><span style='font-size:10.0pt;mso-fareast-font-family:
            "Times New Roman";mso-fareast-language:RU'><?php echo $this->_tpl_vars['i']+1; ?>
</span></sup><span
            style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:
            RU'><?php echo $this->_tpl_vars['job']['job_name_en']; ?>
, </p><p class=MsoNormal style='tab-stops:49.6pt 154.5pt;
            layout-grid-mode:char'><sup></sup><span
            style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-fareast-language:
            RU'><?php echo $this->_tpl_vars['job']['job_adress_en']; ?>
<o:p></o:p></span></p>
        <?php endforeach; endif; unset($_from); ?>
      
            
            
<?php endif; ?>
<?php endif; ?>
        

<?php if (false): ?>
        <span style='mso-bookmark:OLE_LINK2'></span><span style='mso-bookmark:OLE_LINK1'></span>

        <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
        layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
        "Times New Roman";mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>
    <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['user']):
?>
        <?php if ($this->_tpl_vars['user']['email_host'] != 'localhost.lo'): ?>
        <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
        layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
        "Times New Roman";mso-fareast-language:RU'><?php if (count($this->_tpl_vars['users']) > 1): ?><?php echo $this->_tpl_vars['user']['us_name_en']; ?>
 <?php endif; ?><?php echo $this->_tpl_vars['user']['email']; ?>
<o:p></o:p></span></p>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
        <p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
        layout-grid-mode:char'><span style='font-size:10.0pt;mso-fareast-font-family:
        "Times New Roman";mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>

<?php endif; ?>
        

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><b style='mso-bidi-font-weight:normal'><span lang=EN-US
style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";mso-ansi-language:
EN-US;mso-fareast-language:RU'><?php echo $this->_tpl_vars['art_title_en']; ?>
<o:p></o:p></span></b></p>

<p class=MsoNormal style='text-indent:1.0cm;tab-stops:49.6pt 154.5pt;
layout-grid-mode:char'><span lang=EN-US style='font-size:10.0pt;mso-fareast-font-family:
"Times New Roman";text-transform:uppercase;mso-ansi-language:EN-US;mso-fareast-language:
RU'><o:p>&nbsp;</o:p></span></p>

<div class=MsoNormal style='text-indent:1.0cm;mso-hyphenate:none'><span
lang=EN-US style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";
mso-ansi-language:EN-US;mso-fareast-language:RU'><?php echo $this->_tpl_vars['art_notice_en']; ?>
<o:p></o:p></span></div>



<?php if ($this->_tpl_vars['art_key_en']): ?>
<p class=MsoNormal style='text-indent:1.0cm'><b style='mso-bidi-font-weight:
normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US
style='font-size:10.0pt;mso-bidi-font-size:11.0pt;mso-ansi-language:EN-US'>Keywords:
</span></i></b><span lang=EN-US style='font-size:10.0pt;mso-ansi-language:EN-US'><?php echo $this->_tpl_vars['art_key_en']; ?>
<o:p></o:p></span></p>

<p class=MsoNormal style='text-indent:1.0cm'><span lang=EN-US style='font-size:
10.0pt;mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>
<?php endif; ?>

<p class=MsoNormal style='text-indent:1.0cm'><span lang=EN-US style='font-size:
10.0pt;mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>




<p class=MsoNormal style='text-indent:1.0cm'><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt'>ОСНОВНОЙ ТЕКСТ СТАТЬИ<o:p></o:p></span></b></p>

<p class=MsoNormal style='text-indent:1.0cm'><span style='font-size:10.0pt;
mso-fareast-font-family:"Times New Roman";mso-fareast-language:RU'><o:p>&nbsp;</o:p></span></p>

<div class=MsoNormal style='text-indent:1.0cm;mso-hyphenate:none'><span
lang=EN-US style='font-size:10.0pt;mso-fareast-font-family:"Times New Roman";
mso-ansi-language:EN-US;mso-fareast-language:RU'><?php echo $this->_tpl_vars['art_text']; ?>
<o:p></o:p></span></div>


<p class=MsoNormal style='text-indent:1.0cm'><span style='font-size:10.0pt'><o:p>&nbsp;</o:p></span></p>




<span style='font-size:11.0pt;line-height:115%;
font-family:"Times New Roman","serif;mso-ascii-theme-font:minor-latin;mso-fareast-font-family:
Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;
mso-bidi-font-family:"Times New Roman";mso-bidi-theme-font:minor-bidi;
mso-ansi-language:RU;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><br
clear=all style='mso-special-character:line-break;page-break-before:always'>
</span>