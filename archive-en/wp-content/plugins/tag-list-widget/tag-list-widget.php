<?php
/*
Plugin Name: Tag List Widget
Plugin URI: http://www.ethitter.com/plugins/tag-list-widget/
Description: Creates a list of tags as an alternative to the tag cloud. Widget provides various options for deliminating list, trimming long tag names to fit theme constraints, displaying post counts, and excluding specific tags.
Author: Erick Hitter
Version: 0.3
Author URI: http://www.ethitter.com/
*/

add_action("plugins_loaded","TLW_pluginsloaded");

function TLW_pluginsloaded() {
	register_sidebar_widget("Tag List Widget","TLW_sidebar");
	register_widget_control("Tag List Widget","TLW_control");
	register_deactivation_hook( __FILE__,"TLW_deactivate");
	$foption = get_option("TLW_direct");if (!is_array($foption)) {$foption = array('do' => '0', 'limit' => '0');}
	$opt_exclude = get_option("TLW_exclude","notset"); if ($opt_exclude=="notset") {update_option("TLW_exclude","");}
}

function TLW() {
$switch = get_option("TLW_direct");
switch ($switch["invoke"]) {

default:
case "default":
	$options = get_option("TLW");

if ($options["delim"] == "ul") {$bl="<ul id=\"taglist\">";$al="</ul>";$bi="<li>";$ai="</li>";}
	elseif ($options["delim"] == "ol") {$bl="<ol id=\"taglist\">";$al="</ol>";$bi="<li>";$ai="</li>";}
	elseif ($options["delim"] == "linebreak") {$bl="<div id=\"taglist\">";$al="</div>";$bi="";$ai="<br />";}
	elseif ($options["delim"] == "custom") {$bl=$options["before_list"];$al=$options["after_list"];$bi=$options["before_item"];$ai=$options["after_item"];}

break;

case "direct":
	$options = get_option("TLW_direct");
	$bl = ""; $al = "";
	$bi = $options["bi"];
	$ai = $options["ai"];

break;
}

$limit = $options["limit"];
$exclude = explode(",", $options["exclude"]);

$tags = get_tags();
$tags_count = count($tags);

for ($i = 0;$i < $tags_count;$i++):
$slug = $tags[$i]->slug;
	if ($options["count"]=="on") {$count = " (".number_format_i18n($tags[$i]->count).")";}
	if (in_array($slug,$exclude)) {continue;}
	else {
		if ($limit>0) {if(strlen($tags[$i]->name)>$limit) {$name=substr($tags[$i]->name,0,$limit)."...";} else {$name=substr($tags[$i]->name,0,$limit);}} else {$name=$tags[$i]->name;}
		$tag_list .= $bi."<a id=\"taglist_item\" href=\"".get_tag_link($tags[$i]->term_id)."\">".$name.$count."</a>".$ai;
	}
endfor;

echo "<!--Tags list by Tag List Widget; http://www.ethitter.com/plugins/tag-list-widget/-->";
echo $bl;
echo $tag_list;
echo $al;

$options["invoke"] = "default"; update_option("TLW_direct", $options["invoke"]);
}

function TLW_direct($limit,$count,$bi,$ai,$exclude) {
	$direct["invoke"] = "direct";
	$direct["limit"] = $limit;
	$direct["count"] = $count;
	$direct["bi"] = $bi;
	$direct["ai"] = $ai;
	$direct["exclude"] = $exclude;

update_option("TLW_direct",$direct);
//update_option("TLW_direct_exclude",$exclude);
TLW();
}

function TLW_sidebar($args) {
extract($args);
$options = get_option("TLW");
if (empty($options['title'])) {$title="Tags";} else {$title=$options['title'];}

echo $before_widget;
echo $before_title;
echo $title;
echo $after_title;
TLW();
echo $after_widget;
}

function TLW_control() {
	$options = get_option("TLW");
	if (!is_array($options)) {$options = array('title' => 'Tags', 'limit' => '0', 'delim' => 'ul');}
	$opt_exclude = get_option("TLW_exclude");

if ($_POST["TLW_Submit"]) {
	$options["title"] = htmlspecialchars($_POST["TLW_Title"]);
	if (is_numeric($_POST["TLW_Limit"])) {$options["limit"] = $_POST["TLW_Limit"];} else {$options["limit"] = "0";}
	$options["count"] = $_POST["TLW_Count"];
	$options["delim"] = $_POST["TLW_delim"];
	$options["before_list"] = $_POST["TLW_before_list"];
	$options["after_list"] = $_POST["TLW_after_list"];
	$options["before_item"] = $_POST["TLW_before_item"];
	$options["after_item"] = $_POST["TLW_after_item"];
	$options["exclude"] = $_POST["TLW_exclude"];

update_option("TLW", $options);
}

?>
<p>
<label for="TLW_Title">Заголовок: </label><br />
<input class="widefat" type="text" id="TLW_Title" name="TLW_Title" value="<?php echo $options['title'];?>" />
<br /><small><em>(Оставьте пустым для значения по умолчанию.)</em></small><br /><br />
<label for="TLW_Limit">Урезать длинные названия до <em>x</em> знаков: </label>
<input type="text" id="TLW_Limit" name="TLW_Limit" size="3" maxlength="2" value="<?php echo $options['limit'];?>" />
<br /><small><em>(Установите 0 чтобы отобразить полностью тему.)</em></small><br /><br />
<input type="checkbox" id="TLW_Count" name="TLW_Count"<?php if($options["count"]=="on") {echo " checked";}?>> <label for="TLW_Count">Показывать кол-во материала в данной теме??</label><br /><br />
<label for="TLW_exclude">Исключить темы:</label><br />
<input class="widefat" type="text" id="TLW_exclude" name="TLW_exclude" value="<?php echo $options['exclude']; ?>" />
<br /><small><em>Введите короткие ссылки тем (slug), разделенные запятыми, чтобы исключить их из выпадающего списка.</em></small><br /><br />
<label for="TLW_delim">Разделители:</label><br />
<input type="radio" id="TLW_delim" name="TLW_delim" value="ul"<?php if($options["delim"]=="ul") {echo " checked";}?>> Список из стрелок<br />
<input type="radio" id="TLW_delim" name="TLW_delim" value="ol"<?php if($options["delim"]=="ol") {echo " checked";}?>> Нумерованный список<br />
<input type="radio" id="TLW_delim" name="TLW_delim" value="linebreak"<?php if($options["delim"]=="linebreak") {echo " checked";}?>> Обрыв строки<br />
<input type="radio" id="TLW_delim" name="TLW_delim" value="custom"<?php if($options["delim"]=="custom") {echo " checked";}?>> Свой, укажите ниже<br /><br />
<strong>Разделители</strong><br />
<label for="TLW_before_list">До списка:</label><br />
<input type="text" id="TLW_before_list" name="TLW_before_list" size="10" value="<?php echo $options['before_list']; ?>"><br /><br />
<label for="TLW_after_list">После списка:</label><br />
<input type="text" id="TLW_after_list" name="TLW_after_list" size="10" value="<?php echo $options['after_list']; ?>"><br /><br />
<label for="TLW_before_item">До темы:</label><br />
<input type="text" id="TLW_before_item" name="TLW_before_item" size="10" value="<?php echo $options['before_item']; ?>"><br /><br />
<label for="TLW_after_item">После темы:</label><br />
<input type="text" id="TLW_after_item" name="TLW_after_item" size="10" value="<?php echo $options['after_item']; ?>"><br /><br />
<input type="hidden" id="TLW_Submit" name="TLW_Submit" value="1" />
<?php
}

function TLW_deactivate() {
delete_option("TLW");
delete_option("TLW_direct");
unregister_widget_control("TLW_control");
unregister_sidebar_widget("TLW_sidebar");
}

?>