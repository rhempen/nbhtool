<?php

$GLOBALS['LIB_DIR'] = '../../nbhtool/';
$GLOBALS['CONF_DIR'] = '../../config/qss/';

require($GLOBALS['LIB_DIR'].'core/load.php');

\Controller\dispatch(\Acl\verify(\RT::start()));

?>
