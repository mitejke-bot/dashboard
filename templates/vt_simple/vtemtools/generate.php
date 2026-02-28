<?php
defined( '_JEXEC' ) or die( 'Restricted index access' );
require_once JPATH_SITE . '/components/com_content/helpers/route.php';
JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');
class VTEMTheme {
	//initialize 
	public function __construct(){}
	///  Renderer Blocks  ////////////////////////////////
	public static function blocks($blockName, $homepage) {
		$renderBlock = '';
		foreach ($blockName as $key => $section) :
			if (self::widgets($section, $homepage) != '' && !empty($section['attributes'])) {
			$renderBlock .= '<div id="'.($section['attributes']['tagid'] != '' ? $section['attributes']['tagid'] : 'block'.$section['blockid']).'" 
								style="background-color:'.(isset($section['attributes']['background']) ? $section['attributes']['background'] : 'transparent').'; color:'.(isset($section['attributes']['color']) ? $section['attributes']['color'] : '#333').'" 
								class="vtem-block '.$section['type'].' '.$section['widget'].' '.$section['attributes']['animation'].' '.$section['attributes']['grid'].' '.$section['attributes']['class'].' '.((isset($section['attributes']['hidden-on']) && is_array($section['attributes']['hidden-on'])) ? implode(" ", $section['attributes']['hidden-on']) : '').' '.(isset($section['options']['module-positions']) ? 'position-'.$section['options']['module-positions'] : '').'" '.stripslashes($section['attributes']['extend']).' data-vgrid="'.preg_replace("/[^0-9]/","",$section['attributes']['grid']).'">
								<div class="vtem-block-inside clearfix">';
					$renderBlock .= self::widgets($section, $homepage);
			$renderBlock .= 		'</div>
							</div>';
				
			}
		endforeach;
		return $renderBlock;
	}
	///  Renderer Widgets  //////////////////////////////////////////////////////////////////////////////////////////
	public static function widgets($widgetName, $showOnMenu){
		$renderItem = $extenItem = '';
		switch ($widgetName['widget']) {
			case 'widget-logo' :
					if ($widgetName['options'] && is_array($widgetName['options'])) {
						$renderItem = '<div class="logo'.$widgetName['options']['logotype'].' clearfix">
											<a href="'.JURI::root().'">
												<img src="'.$widgetName['options']['logourl'].'" alt="" class="'.($widgetName['options']['logotype'] ? '' : 'hide').'" />
											</a>
										</div>';
					}
					break;
			case 'widget-module' :
					if ($widgetName['options'] && is_array($widgetName['options']))
						if (count(JModuleHelper::getModules($widgetName['options']['module-positions'])))
							$renderItem = '<jdoc:include type="modules" name="'.$widgetName['options']['module-positions'].'" style="'.$widgetName['options']['module-style'].'" />';
					break;
			case 'widget-menu' :
					if ($widgetName['options'] && is_array($widgetName['options'])) {
						$doc = JFactory::getDocument();
						$renderer = $doc->loadRenderer('module');
						$module = JModuleHelper::getModule('mod_menu', $widgetName['options']['menuname']);
						$attribs['style'] = 'none';
						$module->params	= "menutype=".$widgetName['options']['menuname']."\nshowAllChildren=1\nstartLevel=".$widgetName['options']['startLevel']."\nendLevel=".$widgetName['options']['endLevel']."\nclass_sfx= nav-pills vtem-menu\ntag_id=menu".$widgetName['blockid'];
						$renderItem = $renderer->render($module, $attribs);
						$renderItem .= '<script type="text/javascript">
										jQuery(document).ready(function(){
											jQuery("#menu'.$widgetName['blockid'].'").oMenu({
												orientation: "'.$widgetName['options']['orientation'].'",
												mouseEvent: "'.$widgetName['options']['trigger'].'",
												effect: "'.$widgetName['options']['transition'].'",
												stick: '.$widgetName['options']['mobilecanvas'].',
												subWidth: '.$widgetName['options']['subMenuWidth'].'
											});
										});</script>';
					}
					break;
			case 'widget-messages' :
					if (count(JFactory::getApplication()->getMessageQueue()))
						$renderItem = '<jdoc:include type="message" />';
					break;
			case 'widget-component' :
					if ($showOnMenu && !$widgetName['options']['showcomonhome'])
						$renderItem = '';
					else
						$renderItem = '<jdoc:include type="component" />';
					break;
			case 'widget-copyright' :
					$renderItem = str_replace(array('%now%', '%NOW%', '%Now%'), date('Y'), $widgetName['options']['copyright']);
					break;
			case 'widget-totop' :
					$renderItem = '<a class="vtemgotop pull-right fa fa-angle-up" href="#">&nbsp;</a>';
					break;
			case 'widget-customhtml' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="custom-html-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '').'
									<div class="custom-html-content clearfix">'.$widgetName['content']['blockcontent'].'</div>';
					if ($showOnMenu && $widgetName['content']['blockenable'] == 'homepage')
						$renderItem = $extenItem;
					elseif (!$showOnMenu && $widgetName['content']['blockenable'] == 'nohomepage')
						$renderItem = $extenItem;
					elseif ($widgetName['content']['blockenable'] == 'all')
						$renderItem = $extenItem;
					break;
			case 'widget-featuredcontent' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-featured-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '').'
									<div class="widget-featured-content clearfix">
										<a class="icon clearfix" href="'.$widgetName['content']['blocklink'].'" target="'.$widgetName['content']['blocklinktarget'].'">'.
											($widgetName['content']['blocktype'] == 'icon' ? '<i class="fa '.$widgetName['content']['blocktypeicon'].'"></i>' : '&nbsp;').
											($widgetName['content']['blocktype'] == 'image' ? '<img src="'.$widgetName['content']['blocktypeimage'].'" alt="" />' : '&nbsp;').
										'</a>'.
										($widgetName['content']['blockheadline'] != '' ? '<h4 class="headline clearfix">'.$widgetName['content']['blockheadline'].'</h4>' : '').
										($widgetName['content']['blockcontent'] != '' ? '<div class="description clearfix">'.$widgetName['content']['blockcontent'].'</div>' : '').
										($widgetName['content']['blocklink'] != '' ? '<a class="readmore clearfix" href="'.$widgetName['content']['blocklink'].'" target="'.$widgetName['content']['blocklinktarget'].'">'.$widgetName['content']['blocklinktext'].'</a>' : '').
									'</div>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
			case 'widget-slideshow' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-slideshow-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '').'
									<div id="slider'.$widgetName['blockid'].'" class="vtem_main_slideshow box_skitter vtemskiter-'.$widgetName['options']['blocknavstyle'].' navpos-'.$widgetName['options']['blocknavpos'].'">
										<ul class="skitter-data" style="display:none">';
										foreach ($widgetName['content']['itemList'] as $key => $list) :
										$extenItem .='<li>'.
														($list['addonlink'] !='' ? '<a href="'.$list['addonlink'].'" target="'.$list['addonlinktarget'].'"><img src="'.$list['addonimage'].'" alt=""/></a>' : '<img src="'.$list['addonimage'].'" alt=""/>').
														($list['addoncontent'] !='' ? '<div class="label_text">'.$list['addoncontent'].'</div>' : '').
													'</li>';
										endforeach;
						$extenItem .='</ul></div>
										<script type="text/javascript">
											jQuery(document).ready(function(){
												jQuery("#slider'.$widgetName['blockid'].'").skitter({
													  animation: "'.$widgetName['options']['blockeffect'].'",
													  interval: '.$widgetName['options']['blockdelay'].', 
													  mouseOverButton:false,
													  mouseOutButton:false,
													  width_label: "100%",
													  labelAnimation: "slideUp",
													  target_atual: "_blank",';
													  if ($widgetName['options']['blocknavstyle'] == "dots")
														$extenItem .= 'numbers: false, thumbs: false, dots: true, preview: false,';
													  elseif ($widgetName['options']['blocknavstyle'] == "thumbs")
														$extenItem .= 'numbers: false, thumbs: true, dots: false, preview: false,';
													  elseif ($widgetName['options']['blocknavstyle'] == "dots-preview")
														$extenItem .= 'numbers: false, thumbs: false, dots: true, preview: true,';
													  elseif ($widgetName['options']['blocknavstyle'] == "numbers")
														$extenItem .= 'numbers: true, thumbs: false, dots: false, preview: false,';
													  else
														$extenItem .= 'numbers: false, thumbs: false, dots: false, preview: false,';
													 $extenItem .= 'theme: "default",
													  numbers_align: "'.$widgetName['options']['blocknavpos'].'",
													  enable_navigation_keys: true,
													  auto_play: '.($widgetName['options']['blockautoplay'] ? 'true' : 'false').',
													  stop_over: '.($widgetName['options']['blockpause'] ? 'true' : 'false').',
													  progressbar: '.($widgetName['options']['blockprogressbar'] ? 'true' : 'false').',
													  navigation: '.($widgetName['options']['blocknextprev'] ? 'true' : 'false').',
													  width: "'.$widgetName['options']['blockwidth'].'",
													  height: "'.$widgetName['options']['blockheight'].'"
												});
										   });
										 </script>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-carousel' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-carousel-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '').'
									<div id="carousel'.$widgetName['blockid'].'" class="vtem_main_carousel carousel clearfix">';
									if($widgetName['content']['blockdata'] == 'joomla') {
										foreach (self::getList($widgetName) as $key => $list) :
											$extenItem .= '<div class="carousel-item '.$widgetName['options']['itemanimation'].' clearfix" data-wow-delay="0.'.($key+2).'s">'.$list->displayImage.
															($widgetName['content']['blockitemtitle'] ? '<h4 class="carousel-title"><a href="'.$list->link.'">'.$list->title.'</a></h4>' : '').
															($widgetName['content']['blockitemintro'] ? '<div class="carousel-content">'.($widgetName['content']['blockintrolimit'] != 0 ? self::limit_words($list->introtext, $widgetName['content']['blockintrolimit']) : $list->introtext).'</div>' : '').
															((isset($list->link) && $list->readmore != 0 && $widgetName['content']['blockreadmore']) ? '<a class="readmore" href="'.$list->link.'">'.$list->linkText.'</a>' : '').'</div>';
										endforeach;
									} else {
										foreach ($widgetName['content']['itemList'] as $key => $list) :
										$extenItem .='<div class="carousel-item '.$widgetName['options']['itemanimation'].' clearfix" data-wow-delay="0.'.($key+2).'s">
															<a class="thumbnail" href="'.$list['addonlink'].'" target="'.$list['addontarget'].'"><img alt="" src="'.$list['addonimage'].'"></a>
															'.($list['addontitle'] !='' ? '<h4 class="carousel-title">'.$list['addontitle'].'</h4>' : '').'
															'.($list['addoncontent'] !='' ? '<div class="carousel-content">'.$list['addoncontent'].'</div>' : '').
															($list['addonreadmore'] != '' ? '<a class="readmore" href="'.$list['addonlink'].'" target="'.$list['addontarget'].'">'.$list['addonreadmore'].'</a>' : '').
														'</div>';
										endforeach;
									}
							$extenItem .='</div>
										<script type="text/javascript">
											jQuery(document).ready(function(){
												jQuery("#carousel'.$widgetName['blockid'].'").owlCarousel({
														items: '.$widgetName['options']['blocklarge'].',
														itemsDesktop: [1199, '.$widgetName['options']['blocklarge'].'],
														itemsDesktopSmall: [980, '.$widgetName['options']['blocksmall'].'],
														itemsTablet: [768, '.$widgetName['options']['blocktablet'].'],
														itemsMobile: [479, '.$widgetName['options']['blockphone'].'],
														singleItem: false,
														slideSpeed : 500,
														paginationSpeed : 800,
														autoPlay: '.($widgetName['options']['blockautoplay'] ? $widgetName['options']['blockduration'] : 'false').',
														stopOnHover: '.($widgetName['options']['blockpause'] ? 'true' : 'false').',
														goToFirst: true,
														goToFirstSpeed : 1000,
														navigation : '.($widgetName['options']['blocknextprev'] ? 'true' : 'false').',
														navigationText : [\'<i class="fa fa-chevron-left"></i>\',\'<i class="fa fa-chevron-right"></i>\'],
														goToFirstNav : true,
														scrollPerPage : false,
														pagination : '.($widgetName['options']['blockpagination'] ? 'true' : 'false').',
														paginationNumbers: true,
														responsive: true,
														responsiveRefreshRate : 200
												});
										   });
										 </script>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-accordion' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-accordion-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '');
									$extenItem .= '<div id="'.$widgetName['blockid'].'" class="widget-accordion-content accordion panel-group clearfix">';
										foreach ($widgetName['content']['itemList'] as $key => $list) :
											$extenItem .= '<div class="accordion-group panel panel-default">
																<div id="accordion-title-'.$key.'" class="accordion-heading panel-heading">
																	<a class="accordion-toggle collapsed" data-toggle="collapse" aria-expanded="'.($key == 0 ? 'true' : 'false').'" data-parent="#'.$widgetName['blockid'].'" href="#accordion-item-'.$key.'" aria-controls="accordion-item-'.$key.'" role="button">
																		'.$list['addontitle'].'
																	</a>
																</div>
																<div id="accordion-item-'.$key.'" class="accordion-body panel-collapse collapse '.($key == 0 ? 'in' : '').'" aria-labelledby="accordion-title-'.$key.'" role="tabpanel">
																	<div class="accordion-inner panel-body">
																		'.$list['addoncontent'].'
																	</div>
																</div>
															</div>';
										endforeach;
									$extenItem .= '</div>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-tabs' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-tabs-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '');
									$extenItem .= '<div id="'.$widgetName['blockid'].'" class="widget-tabs-content vtem-tabs clearfix">
													<ul class="nav nav-tabs">';
										foreach ($widgetName['content']['itemList'] as $key => $list) :
											$extenItem .= '<li role="presentation" class="'.($key == 0 ? 'active' : '').'">
																<a href="#tab-item'.$key.'" role="tab" data-toggle="tab">
																	'.$list['addontitle'].'
																</a>
															</li>';
										endforeach;
										$extenItem .= '</ul><div class="tab-content">';
										foreach ($widgetName['content']['itemList'] as $key => $list) :
											$extenItem .= '<div role="tabpanel" class="tab-pane '.($key == 0 ? 'active' : '').'" id="tab-item'.$key.'">
																'.$list['addoncontent'].'
															</div>';
										endforeach;
									$extenItem .= '</div>
											</div>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-testimonial' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-testimonial-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '').'
									<div id="testimonial'.$widgetName['blockid'].'" class="vtem_main_testimonial testimonial clearfix">';
										foreach ($widgetName['content']['itemList'] as $key => $list) :
										$extenItem .='<div class="carousel-item '.$widgetName['options']['itemanimation'].' clearfix" data-wow-delay="0.'.($key+2).'s">
															<div class="desc-quote clearfix">
																<div class="small-text"><i class="fa fa-quote-left"></i> '.$list['addoncontent'].' <i class="fa fa-quote-right"></i></div>
															</div>
															<div class="client-details">
																<div class="client-image"><img alt="" src="'.$list['addonimage'].'" class="img-circle"></div>
																<div class="client-details">
																	<strong class="text-color">'.$list['addontitle'].'</strong>                                      
																	<span>'.$list['addoncompany'].'</span>
																</div>
															</div>
														</div>';
										endforeach;
							$extenItem .='</div>
										<script type="text/javascript">
											jQuery(document).ready(function(){
												jQuery("#testimonial'.$widgetName['blockid'].'").owlCarousel({
														items: '.$widgetName['options']['blocklarge'].',
														itemsDesktop: [1199, '.$widgetName['options']['blocklarge'].'],
														itemsDesktopSmall: [980, '.$widgetName['options']['blocksmall'].'],
														itemsTablet: [768, '.$widgetName['options']['blocktablet'].'],
														itemsMobile: [479, '.$widgetName['options']['blockphone'].'],
														singleItem: false,
														slideSpeed : 500,
														paginationSpeed : 800,
														autoPlay: '.($widgetName['options']['blockautoplay'] ? $widgetName['options']['blockduration'] : 'false').',
														stopOnHover: '.($widgetName['options']['blockpause'] ? 'true' : 'false').',
														goToFirst: true,
														goToFirstSpeed : 1000,
														navigation : '.($widgetName['options']['blocknextprev'] ? 'true' : 'false').',
														navigationText : [\'<i class="fa fa-chevron-left"></i>\',\'<i class="fa fa-chevron-right"></i>\'],
														goToFirstNav : true,
														scrollPerPage : false,
														pagination : '.($widgetName['options']['blockpagination'] ? 'true' : 'false').',
														paginationNumbers: true,
														responsive: true,
														responsiveRefreshRate : 200
												});
										   });
										 </script>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-social' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-social-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '');
									$extenItem .= '<div id="'.$widgetName['blockid'].'" class="widget-social-content vtem-social clearfix">';
										foreach ($widgetName['content']['itemList'] as $key => $list) :
											$extenItem .= '<a href="'.$list['addonlink'].'" target="'.$list['addonlinktarget'].'" title="'.$list['addontitle'].'"><i class="fa '.$list['addonicon'].'"></i>
																'.$list['addontitle'].'
															</a>';
										endforeach;
									$extenItem .= '</div>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-image' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-image-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '').
											'<div id="'.$widgetName['blockid'].'" class="widget-image-content vtem-image clearfix">
													<a href="'.$widgetName['content']['blocklink'].'" target="'.$widgetName['content']['blocklinktarget'].'">
														<img src="'.$widgetName['content']['blocktypeimage'].'" alt="">
													</a>'.
													($widgetName['content']['blockcontent'] != '' ? '<div class="widget-image-caption clearfix">'.$widgetName['content']['blockcontent'].'</div>' : '')
											.'</div>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-video' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-video-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '').
											'<div id="'.$widgetName['blockid'].'" class="widget-video-content vtem-video embed-responsive embed-responsive-16by9 clearfix">'.
													($widgetName['content']['blocklink'] != '' ? '<iframe class="embed-responsive-item" src="'.str_replace('watch?v=', 'embed/',str_replace('vimeo.com', 'player.vimeo.com/video',$widgetName['content']['blocklink'])).'" frameborder="0" allowfullscreen></iframe>' : '')
											.'</div>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-gmap' :
					$doc = JFactory::getDocument();
					$doc->addScript('//maps.google.com/maps/api/js?sensor=false');
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-gmap-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '').
											'<div id="gmap'.$widgetName['blockid'].'" class="widget-gmap-content vtem-gmap clearfix" style="width:'.$widgetName['options']['blockwidth'].'; height:'.$widgetName['options']['blockheight'].'"></div>
											<script type="text/javascript">
											jQuery(document).ready(function(){
												jQuery("#gmap'.$widgetName['blockid'].'").gMap({
														'.($widgetName['options']['blocklacation'] == 'address' ? 'address: "'.$widgetName['options']['blockaddress'].'"' : 'latitude:'.$widgetName['options']['blocklatitude'].', longitude:'.$widgetName['options']['blocklongitude']).', zoom:'.$widgetName['options']['blockzoom'].', maptype:"'.$widgetName['options']['blockmaptype'].'", controls:'.($widgetName['options']['blockcontrol'] ? '{panControl: true, zoomControl: true, mapTypeControl: true, scaleControl: true, streetViewControl: true, overviewMapControl: true}' : 'false').', markers:['.$widgetName['options']['blockmarkers'].']
												});
										   });
										 </script>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-gallery' :
					$doc = JFactory::getDocument();
					$doc->addStyleDeclaration("@media (max-width: 479px) {#gallery".$widgetName['blockid']." > div{width:".(100/$widgetName['options']['blockphone'])."%;}} @media (min-width: 480px) and (max-width: 768px) {#gallery".$widgetName['blockid']." > div{width:".(100/$widgetName['options']['blocktablet'])."%;}} @media (min-width: 769px) and (max-width: 980px) {#gallery".$widgetName['blockid']." > div{width:".(100/$widgetName['options']['blocksmall'])."%;}} @media (min-width: 981px) {#gallery".$widgetName['blockid']." > div{width:".(100/$widgetName['options']['blocklarge'])."%;}}");
					$galleryTag = array();
					$tagActive = '';
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-gallery-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '');
									$extenItem .= '<div class="galleryType'.$widgetName['options']['blockfilter'].'"><div id="gallery'.$widgetName['blockid'].'" class="widget-gallery-content vtem-gallery clearfix" style="margin:-'.$widgetName['options']['blockspacing'].'">';
										foreach ($widgetName['content']['itemList'] as $key => $list) :
											$galleryTag = array_unique(array_merge($galleryTag, explode(',',str_replace(' ','',$list['addontag']))), SORT_REGULAR);
											$extenItem .= '<div class="vtem-gallery-item clearfix '.str_replace(',', ' ', $list['addontag']).'" style="padding:'.$widgetName['options']['blockspacing'].'">
																<a href="'.($widgetName['options']['blocklightbox'] ? $list['addonimage'] : '#').'" class="item-link '.$widgetName['options']['blockimageborder'].'"><img src="'.$list['addonimage'].'" alt="'.$list['addontag'].'" class="item-image lightbox'.$widgetName['options']['blocklightbox'].'" style="width:100%; height:auto;" />'.($widgetName['options']['blocklightbox'] ? '<span class="item-overlay"><i class="fa fa-search">&nbsp;</i></span>' : '').'</a>
																'.($list['addoncontent'] != '' ? '<div class="item-caption">'.$list['addoncontent'].'</div>': '').'
															</div>';
										endforeach;
									$extenItem .= '</div></div>';
									if ($widgetName['options']['blockfilter'] == 'nav') {
										$extenItem .='<div class="gallery-btn clearfix"><div id="galleryBtn'.$widgetName['blockid'].'" class="btn-group filter-options">';
											foreach ($galleryTag as $key => $tag) :
												if ($key == 0) $tagActive = $tag;
												$extenItem .= '<button class="btn btn-default '.($key == 0 ? 'active' : '').'" type="button" data-filter=".'.trim($tag).'">'.$tag.'</button>';
											endforeach;
										$extenItem .='</div></div>';
										$extenItem .="<script type='text/javascript'>jQuery(window).load(function () {
											var gallery".$widgetName['blockid']." = jQuery('#gallery".$widgetName['blockid']."').isotope({itemSelector: '.vtem-gallery-item', layoutMode: 'masonry'});
											gallery".$widgetName['blockid'].".isotope({ filter: '.".trim($tagActive)."' });
											jQuery('#galleryBtn".$widgetName['blockid']."').on( 'click', 'button', function() {
												gallery".$widgetName['blockid'].".isotope({ filter: jQuery(this).attr('data-filter') });
											  	jQuery(this).siblings().removeClass('active').end().addClass('active');
											});
										});</script>";
									}
									if ($widgetName['options']['blocklightbox'])
										$extenItem .="<script type='text/javascript'>jQuery(window).load(function () {jQuery('#gallery".$widgetName['blockid']." a').magnificPopup({type: 'image', gallery:{enabled:true}});});</script>";
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
				case 'widget-gridstack' :
					$extenItem = ($widgetName['content']['blocktitle'] != '' ? '<h3 class="widget-gridstack-title clearfix">'.$widgetName['content']['blocktitle'].'</h3>' : '');
									$extenItem .= '<div id="'.$widgetName['blockid'].'" class="widget-gridstack-content vtem-gridstack clearfix">';
										foreach ($widgetName['content']['itemList'] as $key => $list) :
											$extenItem .= '<div class="widget-gridstack-item clearfix '.$list['addonclass'].' image-'.$list['addonimagealign'].'">'.
													($list['addontype'] == 'image' ? '<a href="'.$list['addonlink'].'" target="'.$list['addonlinktarget'].'" style="width:'.($list['addonimagewidth'] != '' ? $list['addonimagewidth'] : 'auto').'; float:'.$list['addonimagealign'].'; display: inline-block; overflow: hidden;" class="widget-gridstack-link '.$list['blockimageborder'].'"><img src="'.$list['addonimage'].'" alt="" style="width:100%" /></a>':'').'
																	<div class="widget-gridstack-caption clearfix" style="width:calc(100% - '.((trim($list['addonimagewidth']) != '100%') ? $list['addonimagewidth'] : '0').')"><div class="gridstack-caption-inside">
																		'.($list['addonheadline'] != '' ? '<h4>'.$list['addonheadline'].'</h4>':'').'
																		'.($list['addoncontent'] != '' ? '<div>'.$list['addoncontent'].'</div>':'').'
																		'.($list['addonlinktext'] != '' ? '<a class="btn btn-primary readmore" href="'.$list['addonlink'].'" target="'.$list['addonlinktarget'].'">'.$list['addonlinktext'].'</a>' : '').'
																	</div></div>
															</div>';
										endforeach;
									$extenItem .= '</div>';
					$renderItem = self::showOn($extenItem, $showOnMenu, $widgetName['content']['blockenable']);
					break;
		}
		return $renderItem;
	}
	///  Show On  ////////////////////////////////
	public static function showOn($getItem, $showOnMenu, $widgetEnable) {
		$renderItem = '';
		if ($showOnMenu && $widgetEnable == 'homepage')
			$renderItem = $getItem;
		elseif (!$showOnMenu && $widgetEnable == 'nohomepage')
			$renderItem = $getItem;
		elseif ($widgetEnable == 'all')
			$renderItem = $getItem;
		return $renderItem;
	}
	///  Get images in a folder  ////////////////////////////////
	public static function getImages($path, $link, $linktarget, $caption) {
		$filename = '';
		$link = (isset($link) && $link !='') ? explode(';', $link) : false;
		$caption = (isset($caption) && $caption !='') ? explode(';', $caption) : false;
		$files = glob((substr($path, -1, 1) == '/' ? $path : $path.'/').'*.{png,gif,jpg,jpeg}', GLOB_BRACE);
		foreach ($files as $key => $file) {
			$filename .= '<dd>';
				if ($link)
					$filename .= '<a href="'.(isset($link[$key]) ? $link[$key] : '#').'" target="'.$linktarget.'"><img src="'.$file.'" alt="" /></a>';
				else
					$filename .= '<img src="'.$file.'" alt="" />';
				$filename .= $caption ? '<div class="label_text">'.(isset($caption[$key]) ? $caption[$key] : '').'</div>' : '';
			$filename .= '</dd>';
		}
		return $filename;
	}
	
	//Get a list of the latest articles from the article model
	public static function getList($widgetName)
	{
		$app = JFactory::getApplication();
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		$appParams = JFactory::getApplication()->getParams();
		$model->setState('params', $appParams);
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $widgetName['content']['blockcount']);
		$model->setState('filter.published', 1);
		$model->setState('list.select', 'a.fulltext, a.id, a.title, a.alias, a.introtext, a.state, a.catid, a.created, a.created_by, a.created_by_alias,' .
			' a.modified, a.modified_by, a.publish_up, a.publish_down, a.images, a.urls, a.attribs, a.metadata, a.metakey, a.metadesc, a.access,' .
			' a.hits, a.featured, a.language');
		$access     = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);
		$model->setState('filter.category_id', $widgetName['content']['blockcatid']);
		$model->setState('filter.language', $app->getLanguageFilter());
		$ordering = $widgetName['content']['blockordering'];
		$model->setState('list.ordering', $ordering);
		if (trim($ordering) == 'rand()')
			$model->setState('list.direction', '');
		else
		{
			$direction = $widgetName['content']['blockdirection'] ? 'DESC' : 'ASC';
			$model->setState('list.direction', $direction);
		}
		// Retrieve Content
		$items = $model->getItems();
		foreach ($items as &$item)
		{
			$item->readmore = strlen(trim($item->fulltext));
			$item->slug     = $item->id . ':' . $item->alias;
			$item->catslug  = $item->catid . ':' . $item->category_alias;
			if ($access || in_array($item->access, $authorised))
			{
				// We know that user has the privilege to view the article
				$item->link     = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
				$item->linkText = JText::_('TPL_VTEM_WIDGETCONTENT_JREADMORETEXT_LABEL');
			}
			else
			{
				$item->link     = JRoute::_('index.php?option=com_users&view=login');
				$item->linkText = JText::_('TPL_VTEM_WIDGETCONTENT_JREADMOREREGISTER_LABEL');
			}
			$item->displayImage = '';
			$image_type = $widgetName['content']['blockimage'];
			$images = json_decode($item->images);
			if($image_type == 'full' && (isset($images) && $images->image_fulltext!= '')) {
				$item->displayImage = $images->image_fulltext;
			}elseif($image_type == 'intro' && (isset($images) && $images->image_intro!='')) {
				$item->displayImage = $images->image_intro;
			}elseif($image_type == 'first'){
				$imgSPos = JString::strpos($item->introtext,'src="');
				  if($imgSPos){
					 $imgEPos = JString::strpos($item->introtext,'"',$imgSPos+5);
					 } 
				  if($imgSPos > 0) {
					 $item->displayImage = JString::substr($item->introtext, ($imgSPos+5), ($imgEPos-($imgSPos+5)));
				   }
			}
			if($item->displayImage)
			 $item->displayImage ='<a class="thumbnail" href="'.$item->link.'"><img src="'.JURI::root().$item->displayImage.'" alt="" /></a>';
			$item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
		}
		return $items;
	}
	
	public static function limit_words($string, $word_limit)
	{
		$words = explode(" ",strip_tags($string));
		return implode(" ",array_splice($words,0,$word_limit));
	}
	
	//Rebuild String for template styles
	public static function rebuildQueryString($vtem_temp) {
		if (!empty($_SERVER['QUERY_STRING'])) {
			$parts = explode("&", $_SERVER['QUERY_STRING']);
			$newParts = array();
			foreach ($parts as $val) {
				$val_parts = explode("=", $val);
				if (!in_array($val_parts[0], $vtem_temp)) {
					array_push($newParts, $val);
				}
			}
			if (count($newParts) != 0) {
				$qs = implode("&amp;", $newParts);
			} else {
				return "?";
			}
			return "?" . $qs . "&amp;";
		} else {
			return "?";
		} 
	}
}