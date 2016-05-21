


<p class=MsoNoSpacing align=right style='text-align:right;text-indent:35.45pt'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'>УДК {$art_udk}<o:p></o:p></span></p>

<p class=MsoNoSpacing align=center style='text-align:center;text-indent:35.45pt'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNoSpacing align=center style='text-align:center;text-indent:35.45pt'><b
style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;font-family:
"Times New Roman","serif"; text-transform: uppercase;'>{$art_title}{if $art_fin}<sup>1</sup>{/if}<o:p></o:p></span></b></p>

<p class=MsoNoSpacing align=center style='text-align:center;text-indent:35.45pt'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

{*////шапка////*}
{if !$art_stol}
{foreach from=$jobs key=i item=job}
    
    <p class=MsoNoSpacing align=right style='text-align:right;text-indent:35.45pt'><b
    style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;font-family:
    "Times New Roman","serif"'>
                {foreach from=$job.user key=index item=user_id}
                {$users[$user_id].us_initials} {$users[$user_id].us_last_name}{if ($job.user|@count - 1) > $index}, {/if}
                {/foreach}
            </span><o:p></o:p></span></b></p>

    <p class=MsoNoSpacing align=right style='text-align:right;text-indent:35.45pt'><span
    style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

    <p class=MsoNoSpacing align=right style='margin-left:212.65pt;text-align:right;
    text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>{$job.job_name}{if $job.job_city}, {$job.job_city}{/if}<o:p></o:p></span></p>

    <p class=MsoNoSpacing align=right style='margin-left:212.65pt;text-align:right;
    text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>
            {foreach from=$job.user key=index item=user_id}
                {if $users[$user_id].email_host != 'localhost.lo'}
                {$users[$user_id].email}{if ($job.user|@count - 1) > $index}, {/if}
                {/if}
                {/foreach}
            <o:p></o:p></span></p>

    <p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
    text-indent:35.45pt'><i style='mso-bidi-font-style:normal'><span
    style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></i></p>
    
{/foreach}
{/if}

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><i style='mso-bidi-font-style:normal'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></i></p>

{*////Аннотация////*}

<div class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>{$art_notice}<o:p></o:p></span></div>

{*////Ключевые слова////*}

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><b style='mso-bidi-font-weight:normal'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'>Ключевые слова</span></b><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'>: <span
class=SpellE>{$art_keywords}<o:p></o:p></span></p>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black'><o:p>&nbsp;</o:p></span></p>

{*////Текст статьи////*}

<div class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>{$art_text}<o:p></o:p></span></div>
{if $art_fin}<div>_____________________________<p><sup>1</sup> <span>{$art_fin}<span></p></div>{/if}


{*<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>
*}
{*////Литература////*}

<p class=MsoNoSpacing style='text-indent:35.45pt'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>Литература<o:p></o:p></span></b></p>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<div class=MsoNoSpacing style='margin-left:0.0cm;text-align:justify;text-justify:
inter-ideograph;text-indent: 1.25cm'><span lang=EN-US style='font-size:12.0pt;
font-family:"Times New Roman","serif";mso-ansi-language:EN-US'>{$art_lit}<o:p></o:p></span></div>
            

{*<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>
*}



{*////Title_EN////*}

<p class=MsoNoSpacing align=center style='text-align:center'><b
style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:12.0pt;
font-family:"Times New Roman","serif";mso-ansi-language:EN-US; text-transform: uppercase;'>{$art_title_en}<o:p></o:p></span></b></p>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph'><span
style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

{*////шапка////*}
{if !$art_stol}
{foreach from=$jobs key=i item=job}
    
    <p class=MsoNoSpacing align=right style='text-align:right;text-indent:35.45pt'><b
    style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;font-family:
    "Times New Roman","serif"'>
                {foreach from=$job.user key=index item=user_id}
                {$users[$user_id].us_initials_en} {$users[$user_id].us_name_en}{if ($job.user|@count - 1) > $index}, {/if}
                {/foreach}
            </span><o:p></o:p></span></b></p>

    
    <p class=MsoNoSpacing align=right style='margin-left:212.65pt;text-align:right;
    text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>{$job.job_name_en}{if $job.job_city_en}, {$job.job_city_en}{/if}<o:p></o:p></span></p>

    <p class=MsoNoSpacing align=right style='margin-left:212.65pt;text-align:right;
    text-indent:35.45pt'><span style='font-size:12.0pt;font-family:"Times New Roman","serif"'>
            {foreach from=$job.user key=index item=user_id}
                {$users[$user_id].email}{if ($job.user|@count - 1) > $index}, {/if}
                {/foreach}
            <o:p></o:p></span></p>

    <p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
    text-indent:35.45pt'><i style='mso-bidi-font-style:normal'><span
    style='font-size:12.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></i></p>
    
{/foreach}
{/if}


<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>

{*////Аннотация////*}

<div class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><span lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-ansi-language:EN-US'>{$art_notice_en}<o:p></o:p></span></div>

{*////Keywords////*}

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph;
text-indent:35.45pt'><b style='mso-bidi-font-weight:normal'><span lang=EN-US
style='font-size:12.0pt;font-family:"Times New Roman","serif";mso-fareast-font-family:
"Times New Roman";color:black;mso-ansi-language:EN-US'>Keywords</span></b><span
lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-ansi-language:EN-US'>: {$art_key_en}<o:p></o:p></span></p>

<p class=MsoNoSpacing style='text-align:justify;text-justify:inter-ideograph'><span
lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNoSpacing style='text-indent:35.45pt'><b style='mso-bidi-font-weight:
normal'><span lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif";
mso-ansi-language:EN-US'>References<o:p></o:p></span></b></p>

<div class=MsoNoSpacing style='margin-left:0.0cm;text-align:justify;text-justify:
inter-ideograph;text-indent: 1.25cm'><span lang=EN-US style='font-size:12.0pt;
font-family:"Times New Roman","serif";mso-ansi-language:EN-US'>{$art_lit_en}<o:p></o:p></span></div>


<span style='font-size:11.0pt;line-height:115%;
font-family:"Times New Roman","serif;mso-ascii-theme-font:minor-latin;mso-fareast-font-family:
Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;
mso-bidi-font-family:"Times New Roman";mso-bidi-theme-font:minor-bidi;
mso-ansi-language:RU;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><br
clear=all style='mso-special-character:line-break;page-break-before:always'>
</span>
