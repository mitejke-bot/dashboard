<?php
define('_JEXEC', 1);
//define( 'JPATH_BASE', dirname(dirname(dirname(dirname(dirname(__FILE__))))) );
define( 'JPATH_BASE', '../../../../' );
require_once ( JPATH_BASE .'includes/defines.php' );
require_once ( JPATH_BASE .'includes/framework.php' );
require_once ( dirname(__FILE__) .'/db.php' );
$VTEMSampleData = new VTEMSampleData;
$app = JFactory::getApplication('site');
$vtemInstallData = $app->input->get('vtemInstallData');
if (isset($vtemInstallData) && $vtemInstallData)
	$VTEMSampleData -> installSampleData();