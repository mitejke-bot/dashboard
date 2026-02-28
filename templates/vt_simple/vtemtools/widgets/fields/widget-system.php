<?php
				
/////////////////////////WIDGET CONTENT///////////////////////////////////////////////////////////
	$widgetHelp = '<div id="vtemHelp" class="widget-content clearfix">'.JText::_('TPL_VTEM_WIDGET_QUICKHELP_LABEL').'</div>';
	$widgetBody = '<div id="vtemMainBody" class="widget-content clearfix">
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGID_LABEL').'</label>
							<input type="text" value="" name="tagid" class="widget-box">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGCLASS_LABEL').'</label>
							<input type="text" value="" name="class" class="widget-box">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_WIDGET_RESPONSIVELAYOUT_LABEL').'</label>
							<select name="responsive" class="widget-box">
								<option value="0">'.JText::_('JNO').'</option>
								<option value="1">'.JText::_('JYES').'</option>
							</select>
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_WIDGET_LAYOUTTYPE_LABEL').'</label>
							<select name="layoutmode" class="widget-box">
								<option value="full">Full</option>
								<option value="boxed">Boxed</option>
							</select>
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_WIDGET_LAYOUTWIDTH_LABEL').'</label>
							<input type="text" value="1170px" name="layoutwidth" class="widget-box">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_WIDGET_FONTFAMILY_LABEL').'</label>
							<input type="text" value="Arial, Helvetica, sans-serif" name="font_family" class="widget-box">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_WIDGET_FONTSIZE_LABEL').'</label>
							<select name="font_size" class="widget-box">
								<option value="10px">10px</option>
								<option value="11px">11px</option>
								<option value="12px">12px</option>
								<option value="13px">13px</option>
								<option value="14px">14px</option>
								<option value="15px">15px</option>
								<option value="16px">16px</option>
								<option value="17px">17px</option>
								<option value="18px">18px</option>
								<option value="19px">19px</option>
								<option value="20px">20px</option>
							</select>
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGBACKGROUND_LABEL').'</label>
							<input type="text" value="#FFFFFF" name="background" class="widget-box tinycolor">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGCOLOR_LABEL').'</label>
							<input type="text" value="#333333" name="color" class="widget-box tinycolor">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGATTRIBUTES_LABEL').'</label>
							<input type="text" value="" name="extend" class="widget-box" placeholder=\'title="Your title"\'>
						</div>
					</div>';
	$widgetSection = '<div id="section" class="widget-content clearfix">
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGID_LABEL').'</label>
							<input type="text" value="" name="tagid" class="widget-box">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGCLASS_LABEL').'</label>
							<input type="text" value="" name="class" class="widget-box">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_FULLWIDTH_LABEL').'</label>
							<select name="full-width" class="widget-box">
								<option value="0">'.JText::_('JNO').'</option>
								<option value="1">'.JText::_('JYES').'</option>
							</select>
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGATTRIBUTES_LABEL').'</label>
							<input type="text" value="" name="extend" class="widget-box" placeholder=\'title="Your title"\'>
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGBACKGROUND_LABEL').'</label>
							<input type="text" value="rgba(255, 255, 255, 0)" name="background" class="widget-box tinycolor">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_TAGCOLOR_LABEL').'</label>
							<input type="text" value="#333333" name="color" class="widget-box tinycolor">
						</div>
						<hr/>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_WIDGETFEATURED_HEADLINE_LABEL').'</label>
							<input type="text" value="" name="headline" class="widget-box">
						</div>
						<div class="control-group">
							<label>'.JText::_('TPL_VTEM_WIDGETFEATURED_DESC_LABEL').'</label>
							<textarea type="text" value="" name="desc" class="widget-box"></textarea>
						</div>
					</div>';
	$widgetMenu = '<div id="widget-menu" class="widget-content clearfix">
					  <ul class="tabs-nav clearfix">
						<li><a href="#widget-menu8">'.JText::_('TPL_VTEM_TABOPTIONS_LABEL').'</a></li>
						<li><a href="#widget-menu9">'.JText::_('TPL_VTEM_TABADVANCED_LABEL').'</a></li>
					  </ul>
					  <div id="widget-menu8" class="tab-content clearfix" data-name="options">
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETMENU_NAME_LABEL').'</label>
								<select name="menuname" class="widget-box">
								'.JHtml::_('select.options', JHtml::_('menu.menus'), 'value', 'text').'
								</select>
							</div>
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETMENU_TRIGGER_LABEL').'</label>
								<select name="trigger" class="widget-box">
									<option value="hover">Mouse Hover</option>
									<option value="click">Mouse Click</option>
								</select>
							</div>
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETMENU_ORIENTATION_LABEL').'</label>
								<select name="orientation" class="widget-box">
									<option value="Horizontal">Horizontal</option>
									<option value="Vertical">Vertical</option>
									<option value="Overlay">Overlay</option>
								</select>
							</div>
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETMENU_TRANSITION_LABEL').'</label>
								<select name="transition" class="widget-box">
									<option value="fade">Fade</option>
									<option value="slide">Slide</option>
								</select>
							</div>
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETMENU_STARTLEVEL_LABEL').'</label>
								<input type="text" value="0" name="startLevel" class="widget-box">
							</div>
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETMENU_ENDLEVEL_LABEL').'</label>
								<input type="text" value="10" name="endLevel" class="widget-box">
							</div>
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETMENU_SUBMENUWIDTH_LABEL').'</label>
								<input type="text" value="220" name="subMenuWidth" class="widget-box">
							</div>
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETMENU_CANVAS_LABEL').'</label>
								<select name="mobilecanvas" class="widget-box">
									<option value="0">'.JText::_('JNO').'</option>
									<option value="1">'.JText::_('JYES').'</option>
								</select>
							</div>
						</div>'.
						$basicTabContent.
					'</div>';
	$widgetModule = '<div id="widget-module" class="widget-content clearfix">
						  <ul class="tabs-nav clearfix">
							<li><a href="#widget-menu8">'.JText::_('TPL_VTEM_TABOPTIONS_LABEL').'</a></li>
							<li><a href="#widget-menu9">'.JText::_('TPL_VTEM_TABADVANCED_LABEL').'</a></li>
						  </ul>
						  <div id="widget-menu8" class="tab-content clearfix" data-name="options">
								<div class="control-group">
									<label>'.JText::_('TPL_VTEM_WIDGETMODULE_TRIGGER_LABEL').'</label>';
									$template = simplexml_load_file(JPATH_SITE.'/templates/'.$this->form->getValue('template').'/templateDetails.xml');
									$options_pos = $select_positions = array();
									foreach($template->positions[0] as $position)  $options_pos[] =  (string) $position;
									$options_pos = array_unique($options_pos);
									foreach($options_pos as $option) $select_positions[] = JHTML::_( 'select.option', $option, $option );
									$widgetModule .= JHTML::_('select.genericlist', $select_positions, 'module-positions', 'class="widget-box"', 'value', 'text').'
								</div>
								<div class="control-group">
									<label>'.JText::_('TPL_VTEM_WIDGETMODULESTYLE_TRIGGER_LABEL').'</label>
									<select name="module-style" class="widget-box">
										<option value="panel">Panel</option>
										<option value="block">Block</option>
										<option value="basic">Basic</option>
										<option value="no">None</option>
									</select>
								</div>
							</div>'.
							$basicTabContent.
					'</div>';
	$widgetComponent = '<div id="widget-component" class="widget-content clearfix">
					  <ul class="tabs-nav clearfix">
						<li><a href="#widget-menu8">'.JText::_('TPL_VTEM_TABOPTIONS_LABEL').'</a></li>
						<li><a href="#widget-menu9">'.JText::_('TPL_VTEM_TABADVANCED_LABEL').'</a></li>
					  </ul>
					  <div id="widget-menu8" class="tab-content clearfix" data-name="options">
					  		<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETCOMPONET_SHOWONHOME_LABEL').'</label>
								<select name="showcomonhome" class="widget-box">
									<option value="0">'.JText::_('JNO').'</option>
									<option value="1">'.JText::_('JYES').'</option>
								</select>
							</div>
							<div class="control-group">
								<p class="alert alert-warning">'.JText::_('TPL_VTEM_WIDGETCOMPONET_NAME_LABEL').'</p>
							</div>
						</div>'.
						$basicTabContent.
					'</div>';
	$widgetMessages = '<div id="widget-messages" class="widget-content clearfix">
					  <ul class="tabs-nav clearfix">
						<li><a href="#widget-menu8">'.JText::_('TPL_VTEM_TABOPTIONS_LABEL').'</a></li>
						<li><a href="#widget-menu9">'.JText::_('TPL_VTEM_TABADVANCED_LABEL').'</a></li>
					  </ul>
					  <div id="widget-menu8" class="tab-content clearfix" data-name="options">
							<div class="alert alert-warning">'.
							JText::_('TPL_VTEM_WIDGETMESSAGES_NAME_LABEL').'
							</div>
						</div>'.
						$basicTabContent.
					'</div>';
	$widgetLogo = '<div id="widget-logo" class="widget-content clearfix">
					  <ul class="tabs-nav clearfix">
						<li><a href="#widget-menu8">'.JText::_('TPL_VTEM_TABOPTIONS_LABEL').'</a></li>
						<li><a href="#widget-menu9">'.JText::_('TPL_VTEM_TABADVANCED_LABEL').'</a></li>
					  </ul>
					  <div id="widget-menu8" class="tab-content clearfix" data-name="options">
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETLOGO_TYPE_LABEL').'</label>
								<select name="logotype" class="widget-box select-group">
									<option value="0">Template</option>
									<option value="1">Image</option>
								</select>
							</div>
							<div class="control-group logotype-1">
								<label>'.JText::_('TPL_VTEM_WIDGETLOGO_IMAGE_LABEL').'</label>
								<div class="media input-group input-append">
									<input type="text" value="images/joomla_green.gif" name="logourl" class="widget-box form-control">
									<a class="input-group-addon add-on modal" href="#" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">'.JText::_('JLIB_FORM_BUTTON_SELECT').'</a>
								</div>
							</div>
						</div>'.
						$basicTabContent.
					'</div>';
	$widgetCopyright = '<div id="widget-copyright" class="widget-content clearfix">
					  <ul class="tabs-nav clearfix">
						<li><a href="#widget-menu8">'.JText::_('TPL_VTEM_TABOPTIONS_LABEL').'</a></li>
						<li><a href="#widget-menu9">'.JText::_('TPL_VTEM_TABADVANCED_LABEL').'</a></li>
					  </ul>
					  <div id="widget-menu8" class="tab-content clearfix" data-name="options">
							<div class="control-group">
								<label>'.JText::_('TPL_VTEM_WIDGETCOPYRIGHT_TEXT_LABEL').'</label>
								<textarea name="copyright" class="widget-box">Copyright © %now% Joomla. All Rights Reserved.</textarea>
							</div>
						</div>'.
						$basicTabContent.
					'</div>';
	$widgetTotop = '<div id="widget-totop" class="widget-content clearfix">
					  <ul class="tabs-nav clearfix">
						<li><a href="#widget-menu8">'.JText::_('TPL_VTEM_TABOPTIONS_LABEL').'</a></li>
						<li><a href="#widget-menu9">'.JText::_('TPL_VTEM_TABADVANCED_LABEL').'</a></li>
					  </ul>
					  <div id="widget-menu8" class="tab-content clearfix" data-name="options">
							<div class="alert alert-warning">'.
							JText::_('TPL_VTEM_WIDGETTOTOP_NAME_LABEL').'
							</div>
						</div>'.
						$basicTabContent.
					'</div>';
					
$widgetModal = '<div id="vtem-modal" class="vtem-container-modal" style="display:none">'.
					$widgetHelp.
					$widgetBody.
					$widgetSection.
					$widgetMenu.
					$widgetModule.
					$widgetComponent.
					$widgetMessages.
					$widgetLogo.
					$widgetCopyright.
					$widgetTotop.
					(isset($widgetExtendsItem) ? $widgetExtendsItem : '').
				'</div>';

////////////////////////// WIDGET TOOLS////////////////////////////////////////////////////////

$widgetSystems = '
	<div data-name="widget-module" data-type="system" data-title="'.JText::_('TPL_VTEM_WIDGET_MODULE_POS_LABEL').'">
		<strong class="fa fa-cubes"></strong> <span>'.JText::_('TPL_VTEM_WIDGET_MODULE_POS_LABEL').' <small class="module-position-name"></small><i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b><em>12</em></span>
	</div>
	<div data-name="widget-component" data-type="system" data-title="'.JText::_('TPL_VTEM_WIDGET_COMPONENT_LABEL').'">
		<strong class="fa fa-magic"></strong> <span>'.JText::_('TPL_VTEM_WIDGET_COMPONENT_LABEL').' <i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b><em>12</em></span>
	</div>
	<div data-name="widget-messages" data-type="system" data-title="'.JText::_('TPL_VTEM_WIDGET_SYSTEM_MESS_LABEL').'">
		<strong class="fa fa-exclamation-triangle"></strong> <span>'.JText::_('TPL_VTEM_WIDGET_SYSTEM_MESS_LABEL').' <i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b><em>12</em></span>
	</div>
	<div data-name="widget-menu" data-type="system" data-title="'.JText::_('TPL_VTEM_WIDGET_MENU_LABEL').'">
		<strong class="fa fa-navicon"></strong> <span>'.JText::_('TPL_VTEM_WIDGET_MENU_LABEL').' <i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b><em>12</em></span>
	</div>
	<div data-name="widget-logo" data-type="system" data-title="'.JText::_('TPL_VTEM_WIDGET_LOGO_LABEL').'">
		<strong class="fa fa-rocket"></strong> <span>'.JText::_('TPL_VTEM_WIDGET_LOGO_LABEL').' <i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b><em>12</em></span>
	</div>
	<div data-name="widget-copyright" data-type="system" data-title="'.JText::_('TPL_VTEM_WIDGET_COPYRIGHT_LABEL').'">
		<strong class="fa fa-copyright"></strong> <span>'.JText::_('TPL_VTEM_WIDGET_COPYRIGHT_LABEL').' <i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b><em>12</em></span>
	</div>
	<div data-name="widget-totop" data-type="system" data-title="'.JText::_('TPL_VTEM_WIDGET_TOTOP_LABEL').'">
		<strong class="fa fa-upload"></strong> <span>'.JText::_('TPL_VTEM_WIDGET_TOTOP_LABEL').' <i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b><em>12</em></span>
	</div>
';