<?php
# pull header and footer from parent website
#$url = 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'."{$_SERVER['HTTP_HOST']}/home/blank";
$header_file = $_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/blocks/header.tpl.php';
$footer_file = $_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/blocks/footer.tpl.php';
$time_header_file_modified = (file_exists($header_file) ? filemtime($header_file) : '0');
#if(time() - $time_header_file_modified >= 60*60*24){ # refresh header every 24 hours
#if(time() - $time_header_file_modified >= 60*60*1){ # refresh header every 1 hour
if(time() - $time_header_file_modified >= 1){ # refresh header every 1 second
  $url = $parent_url . '/blank';
  $html = file_get_contents($url);
  $html = str_replace(array("\r", "\n"), '', $html);
  $html = preg_replace("/href=\"\/\//", "href=\"https:///", $html);
  $html = preg_replace("/href=\"\//", "href=\"".$parent_url."/", $html);
  $html = preg_replace("/src=\"\//", "src=\"".$parent_url."/", $html);
  $header = $footer = $html;
  $header = preg_replace("/<!--main\scontent-->.*/", "<div>", $header);
  $header = preg_replace("/Blank/", $T['title'], $header);
  $footer = preg_replace("/.*<!--end\smain\scontent-->/", "</div>", $footer);
#  $footer = preg_replace("/<!--\/\/--><!\[CDATA\[\/\/\s><!--function\sgoogleTranslateElementInit/", "function googleTranslateElementInit", $footer);
#  $footer = preg_replace("/'google_translate_element'\);}\/\/--><!\]\]>/", "'google_translate_element');}", $footer);
  file_put_contents($header_file, $header);
  file_put_contents($footer_file, $footer);
}
require_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/blocks/header.tpl.php');
?>
