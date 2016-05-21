
<body lang=RU style='tab-interval:35.4pt'>

<p class=MsoNormal align=center style='mso-margin-top-alt:auto;margin-bottom:
25.0pt;text-align:center;line-height:normal'><b><span style='font-size:12.0pt;
font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
color:black;mso-fareast-language:RU'>НАШИ АВТОРЫ<o:p></o:p></span></b></p>

<p class=MsoNormal>
    
 {foreach from=$users item=user}   
    <b><span style='font-size:12.0pt;line-height:115%;
font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
color:black;mso-fareast-language:RU'>{$user.us_full_name}</span></b><span
style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-fareast-language:
RU'>{if $user.post}, {$user.post}{/if}{if $user.job_adress}, {$user.job_adress}{/if}<br><br>

    
    
{/foreach}