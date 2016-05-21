

{foreach from=$users key=i item=user}   
    <b><span style='font-size:12.0pt;line-height:115%;
font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
color:black;mso-fareast-language:RU'></span></b><span
style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-fareast-language:
RU'>{if $user.email_host != 'localhost.lo'} {$user.email}{if ($users|@count - 1) > $i}, {/if}{/if}
{/foreach}


{foreach from=$users item=user}   
    <p><b><span style='font-size:12.0pt;line-height:115%;
font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
color:black;mso-fareast-language:RU'>{$user.us_full_name}</span></b><span
style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif";
mso-fareast-font-family:"Times New Roman";color:black;mso-fareast-language:
RU'>{if $user.email}{if $user.email_host != 'localhost.lo'} {$user.email}{else}<span
style='color: red'> Нет e-mail'a</span>{/if}{else}<span
style='color: red'> Нет e-mail'a</span>{/if}</p>

{/foreach}

