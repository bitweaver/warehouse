<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_warehouse/display_release.php,v 1.2 2009/10/01 13:45:53 wjames5 Exp $
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
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
	$gClient->load();
	$gClient->getRelease($_REQUEST['release_id']);
} else {
// get client from release no - tidy up later!
	$gClient = new Client();
	$gClient->getRelease($_REQUEST['release_id']);
	$gClient->load();
	$gClient->getRelease($_REQUEST['release_id']);
}

$gBitSmarty->assign_by_ref( 'clientInfo', $gClient->mInfo );
//if ( $gClient->isValid() ) {
	$gBitSystem->setBrowserTitle("Release Record");
	$gBitSystem->display( 'bitpackage:warehouse/show_release.tpl');
//} else {
//	header ("location: ".WAREHOUSE_PKG_URL."index.php");
//	die;
//}
?>
