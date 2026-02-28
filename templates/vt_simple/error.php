<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $this->title; ?> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/vtemtools/extends/bootstrap/css/bootstrap.min.css" type="text/css" />
	<style type="text/css">
		.error-container{width:500px; padding:50px; margin:100px auto; border:1px solid #ddd; text-align:center; box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);}
		.error-container > h1{font-size:500%; color:#c00; margin-top:0;}
	</style>
</head>

<body class="site error">
	<div class="error-container clearfix">
    	<h1><?php echo $this->error->getCode(); ?></h1>
    	<h3><?php echo JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></h3>
        <p><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></p>
		<p><a href="<?php echo $this->baseurl; ?>/index.php" class="btn btn-primary"><span class="glyphicon glyphicon-menu-left"></span> <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
    </div>
</body>
</html>
