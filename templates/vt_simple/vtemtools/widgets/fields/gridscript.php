<?php
defined('JPATH_BASE') or die();
jimport('joomla.html.html');
jimport('joomla.form.formfield');
class JFormFieldGridscript extends JFormField
{   
    protected $type = 'Gridscript';
	protected function getInput()
	{
		require_once realpath(JPATH_ADMINISTRATOR . '/components/com_menus/helpers/menus.php');
		require_once (dirname(__FILE__).'/widget-asset.php');
		if (file_exists(dirname(__FILE__).'/widget-extend.php'))
			require_once (dirname(__FILE__).'/widget-extend.php');
		require_once (dirname(__FILE__).'/widget-system.php');
	    $doc = JFactory::getDocument();
		$template = $this->form->getValue('template');
		JHtml::_('jquery.framework');
		JHtml::_('behavior.modal');
		$doc->addScriptDeclaration('var vtemInstallDataPath = "'.JURI::root().'templates/'.$template.'/vtemtools/sampleData/";');
	    $doc->addScript(JURI::root().'templates/'.$template.'/vtemtools/widgets/js/jquery-ui-1.11.4.min.js');
		$doc->addScript(JURI::root().'/media/editors/tinymce/tinymce.min.js');
	    $doc->addScript(JURI::root().'templates/'.$template.'/vtemtools/widgets/js/admin.js');
		$doc->addScript(JURI::root().'templates/'.$template.'/vtemtools/widgets/js/tinyColorPicker.min.js');
		$doc->addScript(JURI::root().'templates/'.$template.'/vtemtools/widgets/js/sampleData.js');
		$doc->addStyleSheet(JURI::root().'templates/'.$template.'/vtemtools/extends/font-awesome/css/font-awesome.min.css');
	    $doc->addStyleSheet(JURI::root().'templates/'.$template.'/vtemtools/widgets/css/admin.css');
		$render = json_decode($this->value, true);
		$html = '';
		$html .= $widgetModal;
		$html .= '<div id="'.$this->id.'" class="container layout-container">
					<div class="widget-tools clearfix">
						<span class="tools-title">'.JText::_('TPL_VTEM_WIDGET_TOOLBOX_LABEL').'</span>
						<div class="widget-tools-content clearfix">
						<div class="widget-system widget-tool-list widget-items clearfix">'.$widgetSystems.'</div>
						<hr/>
						<div class="widget-extend widget-tool-list widget-items clearfix">'.(isset($widgetExtends) ? $widgetExtends : '<p class="alert alert-warning text-center" role="alert">'.JText::_('TPL_VTEM_WIDGET_NO_WIDGETEXTEND').'</p>').'</div>
						</div>
					</div>
					<div class="layout-build build-control clearfix" data-name="vtemMainBody">
						<div class="layout-title clearfix"><span>'.JText::_('TPL_VTEM_WIDGET_LAYOUT_LABEL').'</span>
							<i id="vtem-help" class="vtem-button help build-control tip" title="'.JText::_('TPL_VTEM_WIDGET_HELP_LABEL').'" data-name="vtemHelp"><i class="fa fa-question-circle config"></i></i>
							<i id="vtem-conf" class="fa fa-cog vtem-button config tip" title="'.JText::_('TPL_VTEM_WIDGET_CONF_LABEL').'"></i>
							<i id="vtem-add-row" class="fa fa-plus vtem-button tip" title="'.JText::_('TPL_VTEM_WIDGET_SECTION_LABEL').'"></i>
						</div>
						<div id="layout-main" class="layout-main clearfix">';
						foreach ($render as $key => $sections) :
							if ($sections && is_array($sections) && $key == 'children') {
								foreach ($sections as $key => $section) :
								$html .= '<div class="vtem-section build-control widget-items" data-name="'.$section['type'].'" data-id="'.$section['id'].'">
												<div class="section-title clearfix"><i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b></div>
												<div class="section-content clearfix">';
												if ($section && is_array($section)){
													foreach ($section as $key => $blocks) :
													if ($blocks && is_array($blocks) && $key == 'children') {
														foreach ($blocks as $key => $block) :
														$html .= '<div class="'.str_replace('col-md-', 'vtem-grid-',(isset($block['attributes']['grid']) ? $block['attributes']['grid'] : 'col-md-12')).' build-control" data-name="'.$block['widget'].'" data-id="'.$block['blockid'].'" data-type="'.$block['type'].'">';
															switch ($block['widget']) {
																case 'widget-module' :
																	$html .= '<strong class="fa fa-cubes"></strong>';
																	break;
																case 'widget-component' :
																	$html .= '<strong class="fa fa-magic"></strong>';
																	break;
																case 'widget-messages' :
																	$html .= '<strong class="fa fa-exclamation-triangle"></strong>';
																	break;
																case 'widget-menu' :
																	$html .= '<strong class="fa fa-navicon"></strong>';
																	break;
																case 'widget-logo' :
																	$html .= '<strong class="fa fa-rocket"></strong>';
																	break;
																case 'widget-copyright' :
																	$html .= '<strong class="fa fa-copyright"></strong>';
																	break;
																case 'widget-totop' :
																	$html .= '<strong class="fa fa-upload"></strong>';
																	break;
																case 'widget-customhtml' :
																	$html .= '<strong class="fa fa-html5"></strong>';
																	break;
																case 'widget-featuredcontent' :
																	$html .= '<strong class="fa fa-dropbox"></strong>';
																	break;
																case 'widget-slideshow' :
																	$html .= '<strong class="fa fa-slideshare"></strong>';
																	break;
																case 'widget-carousel' :
																	$html .= '<strong class="fa fa-exchange"></strong>';
																	break;
																case 'widget-accordion' :
																	$html .= '<strong class="fa fa-tasks"></strong>';
																	break;
																case 'widget-tabs' :
																	$html .= '<strong class="fa fa-folder"></strong>';
																	break;
																case 'widget-testimonial' :
																	$html .= '<strong class="fa fa-comments"></strong>';
																	break;
																case 'widget-social' :
																	$html .= '<strong class="fa fa-users"></strong>';
																	break;
																case 'widget-image' :
																	$html .= '<strong class="fa fa-picture-o"></strong>';
																	break;
																case 'widget-video' :
																	$html .= '<strong class="fa fa-video-camera"></strong>';
																	break;
																case 'widget-gmap' :
																	$html .= '<strong class="fa fa-map-marker"></strong>';
																	break;
																case 'widget-gallery' :
																	$html .= '<strong class="fa fa-th-large"></strong>';
																	break;
																case 'widget-gridstack' :
																	$html .= '<strong class="fa fa-th-list"></strong>';
																	break;
															}
															$html .= '<span>
																		'.$block['title'].'
																		<small class="module-position-name">'.(array_key_exists('module-positions', $block['options']) ? '['.$block['options']['module-positions'].']' : '').'</small>
																		<i class="fa fa-cog vtem-button config"></i>
																		<b class="fa fa-trash vtem-button delete"></b>
																		<em>'.(str_replace('col-md-', '' , (isset($block['attributes']['grid']) ? $block['attributes']['grid'] : 'col-md-12'))).'</em>
																	</span>
																</div>';
														endforeach;
													}
													endforeach;
												}
									$html .= ' </div>
											</div>';
							endforeach;
							}
						endforeach;
		$html .= 		'</div>
					</div>
				</div>';
		$html .= '<textarea name="'.$this->name.'" id="layoutscript">'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'</textarea>';
		return $html;
	}
}
