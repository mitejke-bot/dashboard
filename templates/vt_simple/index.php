<?php
/* Design by VTEM http://www.vtem.net  All Rights Reserved */
defined( '_JEXEC' ) or die( 'Restricted access' );
if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'vtemtools'.DS.'default.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <?php echo $vtOutoutHead;?>
    </head>
    <body id="<?php echo $bodyID; ?>" class="<?php echo $bodyClass; ?>" <?php echo $bodyAttr; ?>>
    	<div id="vtem-wrapper" class="vtem-wrapper clearfix">
			<?php
            	echo $bodyItems;
            ?>
        </div>
    </body>
</html>