<?php
/**
 * @copyright	Copyright (C) 2008 - 2009  All rights reserved.
 * @license		
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
/*
 * Panel (chosen panel tag and font header tags)
 */
function modChrome_panel($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	$moduleClass    = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = !empty($headerClass) ? htmlspecialchars($headerClass) : '';

	if (!empty ($module->content)) : 
		echo '<'.$moduleTag.' class="vtem-moduletable mod-panel panel panel-default clearfix moduletable'.htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass.'">';
			if ((bool) $module->showtitle)
				echo '<'.$headerTag.' class="moduletable-title panel-heading '.$headerClass.'">'.$module->title.'</'.$headerTag.'>';
			echo '<div class="moduletable-content panel-body">'.$module->content.'</div> ';
		echo '</'.$moduleTag.'>';
	endif;
}
/*
 * Block (chosen Block tag and font header tags)
 */
function modChrome_block($module, &$params, &$attribs)
{
	$moduleTag     = $params->get('module_tag', 'div');
	$bootstrapSize = (int) $params->get('bootstrap_size', 0);
	$moduleClass   = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';
	$headerTag     = htmlspecialchars($params->get('header_tag', 'h3'));
	$headerClass   = htmlspecialchars($params->get('header_class'));

	if ($module->content) :
		echo '<' . $moduleTag . ' class="vtem-moduletable mod-block well clearfix moduletable'.htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass . '">';
			if ($module->showtitle)
				echo '<' . $headerTag . ' class="moduletable-title block-title ' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
			echo '<div class="moduletable-content block-body">'.$module->content.'</div> ';
		echo '</' . $moduleTag . '>';
	endif;
}
/*
 * Basic (chosen Basic tag and font header tags)
 */
function modChrome_basic($module, &$params, &$attribs)
{
	$moduleTag     = $params->get('module_tag', 'div');
	$bootstrapSize = (int) $params->get('bootstrap_size', 0);
	$moduleClass   = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';
	$headerTag     = htmlspecialchars($params->get('header_tag', 'h3'));
	$headerClass   = htmlspecialchars($params->get('header_class'));

	if ($module->content) :
		echo '<' . $moduleTag . ' class="vtem-moduletable mod-basic clearfix moduletable'.htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass . '">';
			if ($module->showtitle)
				echo '<' . $headerTag . ' class="moduletable-title basic-title ' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
			echo '<div class="moduletable-content basic-body">'.$module->content.'</div> ';
		echo '</' . $moduleTag . '>';
	endif;
}
/*
 * none (output raw module content)
 */
function modChrome_no($module, &$params, &$attribs)
{
	if ($module->content)
	{
		echo $module->content;
	}
}
?>