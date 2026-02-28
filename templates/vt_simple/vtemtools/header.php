<?php
defined('_JEXEC') or die('Restricted access');
JHtml::_('jquery.framework');
JHtml::_('bootstrap.framework');
$document->addStyleSheet($template_baseurl.'/vtemtools/extends/bootstrap/css/bootstrap.min.css');
$document->addStyleSheet($template_baseurl.'/css/template.css');
$document->addStyleSheet($template_baseurl.'/css/styles/'.$TemplateStyle.'.css');
$document->addScript($template_baseurl.'/vtemtools/widgets/js/global.js');
$document->addScript($template_baseurl.'/vtemtools/widgets/js/jquery.omenu.js');
$document->addScript($template_baseurl.'/js/init.js');
if (!$vtemlogo) $tplon = 1;
$vtOutoutHead = "\r\n";
$vtOutoutHead .= '<jdoc:include type="head" />'."\n";

////////// BEGIN RESPONSIVE LAYOUT ///////////////////////////
if(isset($layoutscript['attributes']['responsive']) && $layoutscript['attributes']['responsive']) 
	$vtOutoutHead .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">'."\n".
     			 	 '<link rel="stylesheet" href="'.$template_baseurl.'/css/responsive.css" type="text/css" />'."\n";
else 
	$vtOutoutHead .= '<style type="text/css">.container{width: 970px !important;}</style>'."\n";
////////// END RESPONSIVE LAYOUT ///////////////////////////

////////// BEGIN GOOGLE FONTS ///////////////////////////
if($webfont == 1)
	$document->addStyleSheet('//fonts.googleapis.com/css?family='.$googlefont.':400,300,700,600&subset=latin,latin-ext,cyrillic-ext,greek-ext,greek,cyrillic');
$vtOutoutHead .= '<style type="text/css">body{font-family:'.(isset($layoutscript['attributes']['font_family']) ? $layoutscript['attributes']['font_family'] : 'Arial,sans-serif').' !important; font-size:'.(isset($layoutscript['attributes']['font_size']) ? $layoutscript['attributes']['font_size']: '14px').' !important; background-color:'.(isset($layoutscript['attributes']['background']) ? $layoutscript['attributes']['background']: '#fff').'; color:'.(isset($layoutscript['attributes']['color']) ? $layoutscript['attributes']['color']: '#333').'} '.($webfont ? $googlefontelements.'{font-family:'.str_replace("+", " ", $googlefont).', sans-serif;}' : '').((isset($layoutscript['attributes']['layoutwidth']) && $layoutscript['attributes']['layoutwidth'] != '') ? '@media (min-width: 1200px){.container{width:'.$layoutscript['attributes']['layoutwidth'].'}}' : '').'</style>'."\n";
////////// END GOOGLE FONTS ///////////////////////////

////////// BEGIN GOOGLE ANALYTICS ///////////////////////////
if ($GoogleAnalytics == 1)
	$document->addScriptDeclaration("(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', '".$gacode."', 'auto');
ga('send', 'pageview');");
////////// END GOOGLE ANALYTICS ///////////////////////////

$vtOutoutHead .= "\r\n";