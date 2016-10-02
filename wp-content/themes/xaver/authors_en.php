<?php
/*
Template Name: Authors list EN
*/

get_header();
require_once(ABSPATH . WPINC . '/registration.php');
?>

   <h1 class="ii-page-title">Our authors</h1>  <br>
<?
       global $wpdb;
     $au = $wpdb->get_results("
				SELECT post_id, meta_value,user_login FROM `wp_postmeta` left join  wp_posts on (wp_postmeta.post_id=wp_posts.ID) left join wp_users on ( REPLACE(LCASE(TRIM(wp_postmeta.meta_value)), ' ','')=REPLACE(LCASE(TRIM(wp_users.display_name)), ' ','')) where meta_key='coauthor' and post_status='publish' and post_type='post' group by meta_value order by meta_value ASC
		");
      //  print_r($au);exit;
	      foreach($au as $key=>$value)
	      {
			      //      [0] => stdClass Object
			      //  (
			       //     [post_id] => 416
			       //     [meta_value] => Айламазьян А.М.
			       //     [user_login] =>

			       if(!$value->user_login)
			       {              unset($user);
			       	//echo "Zaregi ".tranaslat($value->meta_value)."<br>";
							$user=Array
							(
							    "user_login" => tranaslat($value->meta_value),
							    "role" => 'subscriber',
							    "user_email" => 'temp@localhost.lo',
							    "user_url" => '',
							    "first_name" => $value->meta_value,
							    "comment_shortcuts" => '',
							    "use_ssl" => 0 ,
							    "user_pass" => "ideaidealynsuem",
							    "display_name" => $value->meta_value
							) ;
							$in=wp_insert_user($user);
						//		echo "<a href='/author/".$in."'>".$value->meta_value."</a><br>";

			       }
			       else{
			     //  	echo "<a href='/author/".$value->user_login."'>".$value->meta_value."</a><br>";
			       }

	        }



       echo "<ul style='line-height:25px;'>";
wp_list_authors2_en("optioncount=1&exclude_admin=1&show_fullname=1&hide_empty=&style=list");
echo "</ul>";



get_footer();













function tranaslat($title) {
	$gost1 = array(
   "Є"=>"EH","І"=>"I","і"=>"i","№"=>"#","є"=>"eh",
   "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
   "Е"=>"E","Ё"=>"JO","Ж"=>"ZH",
   "З"=>"Z","И"=>"I","Й"=>"JJ","К"=>"K","Л"=>"L",
   "М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
   "С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"KH",
   "Ц"=>"C","Ч"=>"CH","Ш"=>"Sh","Щ"=>"Shh","Ъ"=>"'",
   "Ы"=>"Y","Ь"=>"","Э"=>"EH","Ю"=>"YU","Я"=>"YA",
   "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
   "е"=>"e","ё"=>"jo","ж"=>"zh",
   "з"=>"z","и"=>"i","й"=>"jj","к"=>"k","л"=>"l",
   "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
   "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"kh",
   "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
   "ы"=>"y","ь"=>"","э"=>"eh","ю"=>"yu","я"=>"ya","«"=>"","»"=>"","—"=>"-"
  );
		    return strtr($title, $gost1);
}



?>

