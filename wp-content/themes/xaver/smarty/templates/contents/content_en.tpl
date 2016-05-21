

{*//////категории////////*}
{foreach from=$cats_en key=category item=posts}
    
    {if ($category != 'No matter') && ($category != 'From the Editor')}<p class=MsoNormal style='text-align:justify;text-indent:35.4pt'><b
style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:12.0pt;
line-height:115%;font-family:"Times New Roman","serif";mso-ansi-language:EN-US'>{$category}</span></b></p>{/if}
        
        
        
        {*///////посты////////*}
        {foreach from=$posts item=post}
            <p class=MsoNormal style='text-align:justify'>
            
                    {if !$post.stol}
                        {*///////авторы////////*}
                        {if $post.users|@count > 0}
                        <b style='mso-bidi-font-weight: normal'>
                            <span lang=EN-US style='font-size:12.0pt;font-family:"Times New Roman","serif"; mso-ansi-language:EN-US'>
                          {foreach from=$post.users key=key item=user}
                          {$user.us_initials_en} {$user.us_name_en}{if ($post.users|@count - 1) == $key}. {else}, {/if}
                          {/foreach}      
                        </span></b>
                        {/if}
                    {/if}
                                        
            <span lang=EN-US style='font-size:12.0pt;line-height:115%; font-family:"Times New Roman","serif";mso-ansi-language:EN-US'>{$post.title}<o:p></o:p></span></p>
        {/foreach}

{/foreach}

    
<p class=MsoNormal style='text-indent:35.4pt; text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"; mso-ansi-language:EN-US'>Our Contributors<o:p></o:p></span></b></p>
{if $tom == 2}
<p class=MsoNormal style='text-indent:35.4pt; text-align:justify'><b style='mso-bidi-font-weight:
normal'><span style='font-size:12.0pt;line-height:115%;font-family:"Times New Roman","serif"; mso-ansi-language:EN-US'>Information for Contributors<o:p></o:p></span></b></p>
{/if}
<p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
normal'><span lang=EN-US style='font-size:12.0pt;line-height:115%;font-family:
"Times New Roman","serif";mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></b></p>
