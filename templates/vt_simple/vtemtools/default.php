<?php
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
$document = JFactory::getDocument();
$lang = JFactory::getLanguage();
$pageview = $app->input->getCmd('view', '');
$pageoption = $app->input->getCmd('option', '');
$pagelayout = $app->input->getCmd('layout', '');
$pagetask = $app->input->getCmd('task', '');
$pageID = $app->input->getCmd('Itemid', '');
$this->language  = $document->language;
$this->direction = $document->direction;
$template_baseurl = $this->baseurl.'/templates/'.$this->template;
$layoutscript = json_decode($this->params->get("layoutscript", '{"children":[],"attributes":{"tagid":"vtem","class":"site-body","extend":""}}'), true);
$Default_TemplateStyle = $this->params->get("TemplateStyle", "style1");
$GoogleAnalytics = $this->params->get("GoogleAnalytics", 0);
$gacode = $this->params->get("gacode", "UA-17014902-1");
$webfont = $this->params->get("webfont", 0);
$googlefont = $this->params->get("googlefont", "Open+Sans");
$googlefontelements = $this->params->get("googlefontelements", "h3");
$vtemlogo = $this->params->get("vtemlogo", 1);
///  Cookies  ///////////////////////////
$cookie_prefix = $this->template;
$cookie_time = time()+30000000;
$vtem_temp = array('TemplateStyle','Layout');
$TemplateStyle = $Default_TemplateStyle;
foreach ($vtem_temp as $tprop) {
    $vtem_session = JFactory::getSession();
	if (isset($_REQUEST[$tprop])) {
	    $$tprop = JRequest::getString($tprop, null, 'get');
    	$vtem_session->set($cookie_prefix.$tprop, $$tprop);
    	setcookie ($cookie_prefix. $tprop, $$tprop, $cookie_time, '/', false);   
    	global $$tprop; 
    }
}
foreach ($vtem_temp as $tprop) {
    $vtem_session = JFactory::getSession();
    if ($vtem_session->get($cookie_prefix.$tprop)) {
        $$tprop = $vtem_session->get($cookie_prefix.$tprop);
    } elseif (isset($_COOKIE[$cookie_prefix. $tprop])) {
    	$$tprop = JRequest::getVar($cookie_prefix. $tprop, '', 'COOKIE', 'STRING');
    }    
}
//////////////////////////////
require_once (dirname(__FILE__).DS.'generate.php');
require_once (dirname(__FILE__).DS.'header.php');
///  Renderer Layout  //////////////////////////////////////////////////////////////////////////////////////////
$vtemRender = new VTEMTheme;
$mainurl = $_SERVER['PHP_SELF'].$vtemRender->rebuildQueryString($vtem_temp);
$homepage = false;
if ($app->getMenu()->getActive() == $app->getMenu()->getDefault($lang->getTag())) //Multi-lingual $app->getMenu()->getDefault($lang->getTag())
	$homepage = true;
$bodyID = 'vtem'.str_replace(' ', '-', $layoutscript['attributes']['tagid']);
$bodyClass = 'site '.($pageoption ? $pageoption : '').
			($pagelayout ? ' layout-'.$pagelayout : '').
			($pageview ? ' opt-'.$pageview : '').
			($pageID ? ' menuid'.$pageID : '').
			($pagetask ? ' task-'.$pagetask : '').
			($TemplateStyle ? ' template-'.$TemplateStyle : '').
			(isset($layoutscript['attributes']['class']) ? ' '.$layoutscript['attributes']['class'] : '').
			(isset($layoutscript['attributes']['layoutmode']) ? ' layout-mode-'.$layoutscript['attributes']['layoutmode'] : '').
			(isset($tplon) ? ' tpl-on' : '').
			($homepage ? ' homepage ' : ' no-homepage ').
			'blog-basic'; // Add style for content (blog-basic, blog-classic, blog-simple)
$bodyAttr = stripslashes($layoutscript['attributes']['extend']);
$bodyItems = '';
foreach ($layoutscript['children'] as $key => $sections) :
	if ($vtemRender->blocks($sections['children'], $homepage) != '') {
	$bodyItems .= '<div id="'.($sections['attributes']['tagid'] != '' ? $sections['attributes']['tagid'] : $sections['type'].$sections['id']).'" 
							class="vtem-'.$sections['type'].' '.$sections['attributes']['class'].' clearfix" '.
							'style="background-color:'.(isset($sections['attributes']['background']) ? $sections['attributes']['background'] : '#fff').'; color:'.(isset($sections['attributes']['color']) ? $sections['attributes']['color'] : '#333').';"'.
							stripslashes($sections['attributes']['extend']).'>
						<div class="vtem-'.$sections['type'].'-inside '.($sections['attributes']['full-width'] ? 'container-fluid' : 'container').' clearfix">';
							if (isset($sections['attributes']['headline']) && $sections['attributes']['headline'] != '' || isset($sections['attributes']['desc']) && $sections['attributes']['desc'] != '')
								$bodyItems .= '<div class="section-title clearfix">'.($sections['attributes']['headline'] != '' ? '<h1>'.$sections['attributes']['headline'].'</h1>' : '').($sections['attributes']['desc'] != '' ? '<h4>'.$sections['attributes']['desc'].'</h4>' : '').'</div>';
							$bodyItems .= '<div class="row section-content clearfix">';
								$bodyItems .= $vtemRender->blocks($sections['children'], $homepage);
	$bodyItems .= 			'</div>
						</div>
					</div>';
	}
endforeach;