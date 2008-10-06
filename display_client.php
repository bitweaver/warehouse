<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_warehouse/display_client.php,v 1.1 2008/10/06 07:49:14 lsces Exp $
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
 *
 * @package warehouse
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

include_once( WAREHOUSE_PKG_PATH.'Client.php' );

$gBitSystem->verifyPackage( 'warehouse' );

$gBitSystem->verifyPermission( 'p_warehouse_view' );

if( !empty( $_REQUEST['client_id'] ) ) {
	$gClient = new Client($_REQUEST['client_id'],$_REQUEST['content_id']);
	$gClient->loadClient();
} else {
	$gClient = new Client();
}

$gBitSmarty->assign_by_ref( 'clientInfo', $gClient->mInfo );
//if ( $gClient->isValid() ) {
	$gBitSystem->setBrowserTitle("Client Activity Record");
	$gBitSystem->display( 'bitpackage:warehouse/show_client.tpl');
//} else {
//	header ("location: ".WAREHOUSE_PKG_URL."index.php");
//	die;
//}
?>
