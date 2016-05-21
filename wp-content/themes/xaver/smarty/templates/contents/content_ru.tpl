

{*//////категории////////*}
{foreach from=$cats key=category item=posts}
    
    {if ($category != 'Без рубрики') && ($category != 'От автора') && ($category != 'От редактора')}<p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"'>{$category}<o:p></o:p></span></b></p>{/if}
        
        
        
        {*///////посты////////*}
        {foreach from=$posts item=post}
            <p class=MsoNormal style='text-align:justify'>
            
                    {if !$post.stol}
                        {*///////авторы////////*}
                        {if $post.users|@count > 0}
                        <b style='mso-bidi-font-weight: normal'>
                            <span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"'>
                          {foreach from=$post.users key=key item=user}
                          {if ($user.us_initials|@strlen) < 4}{$user.us_first_name} {else}{$user.us_initials} {/if} {$user.us_last_name}{if ($post.users|@count - 1) == $key}. {else}, {/if}
                          {/foreach}      
                        </span></b>
                        {/if}
                    {/if}
                                        
            <span class="" style='font-size:12.0pt;line-height:115%;
                    font-family:"Times New Roman","serif"'>{$post.title}{if ($post.title == 'От редактора') || ($post.title == 'От автора')} [1 том]{/if}<o:p></o:p></span></p>
        {/foreach}

{/foreach}




<p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"'>Наши
авторы<o:p></o:p></span></b></p>
{if $tom == 2}
<p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"'>Информация
для авторов [2 том<a name="_GoBack"></a>]<o:p></o:p></span></b></p>
{/if}

<p class=MsoNormal style='text-indent:1.0cm'><span style='font-size:10.0pt'><o:p>&nbsp;</o:p></span></p>


<span style='font-size:11.0pt;line-height:115%;
font-family:"Times New Roman","serif;mso-ascii-theme-font:minor-latin;mso-fareast-font-family:
Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;
mso-bidi-font-family:"Times New Roman";mso-bidi-theme-font:minor-bidi;
mso-ansi-language:RU;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><br
clear=all style='mso-special-character:line-break;page-break-before:always'>
</span>
