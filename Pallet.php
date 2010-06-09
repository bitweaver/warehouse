<?php
/**
 * @version $Header$ 
 *
 * Copyright ( c ) 2006 bitweaver.org
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 *
 * @package warehouse
 */

/**
 * required setup
 */
require_once( LIBERTY_PKG_PATH.'LibertyContent.php' );		// IRList base class

define('PALLET_CONTENT_TYPE_GUID', 'pallet' );

/**
 * @package warehouse
 */
class Pallet extends LibertyContent {
	var $mPalletId;

	/**
	 * Constructor 
	 * 
	 * Build an Warehouse object based on LibertyContent
	 * @param integer Warehouse identifer
	 * @param integer Base content_id identifier 
	 */
	function Pallet( $pPalletId = NULL, $pContentId = NULL ) {
		LibertyContent::LibertyContent();
		$this->registerContentType( PALLET_CONTENT_TYPE_GUID, array(
				'content_type_guid' => PALLET_CONTENT_TYPE_GUID,
				'content_name' => 'Pallet Location',
				'handler_class' => 'Pallet',
				'handler_package' => 'warehouse',
				'handler_file' => 'Pallet.php',
				'maintainer_url' => 'http://lsces.co.uk'
			) );
		$this->mPalletId = $pPalletId;
		$this->mContentId = (int)$pContentId;
		$this->mContentTypeGuid = PALLET_CONTENT_TYPE_GUID;
	}

	/**
	 * Load an Pallet content Item
	 *
	 * (Describe Pallet object here )
	 */
	function load($pContentId = NULL) {
		if ( $pContentId ) $this->mContentId = (int)$pContentId;
/*		if( @$this->verifyId( $this->mIRId ) || @$this->verifyId( $this->mContentId ) ) {
			$lookupColumn = @$this->verifyId( $this->mIRId ) ? 'ir_id' : 'content_id';

			$bindVars = array(); $selectSql = ''; $joinSql = ''; $whereSql = '';
			array_push( $bindVars, $lookupId = @BitBase::verifyId( $this->mIRId )? $this->mIRId : $this->mContentId );
			$this->getServicesSql( 'content_load_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

			$query = "select wh.*, lc.*,
				uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name,
				uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name,
				uux.`login` AS closed_user, uuc.`real_name` AS closed_real_name
				$selectSql
				FROM `".BIT_DB_PREFIX."warehouse_list` wh
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON ( lc.`content_id` = ir.`content_id` ) $joinSql
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON (uue.`user_id` = lc.`modifier_user_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON (uuc.`user_id` = lc.`user_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uux ON (uux.`user_id` = ir.`closed_user_id`)
				WHERE wh.`$lookupColumn`=? $whereSql";
			$result = $this->mDb->query( $query, $bindVars );

			if ( $result && $result->numRows() ) {
				$this->mInfo = $result->fields;
				$this->mContentId = (int)$result->fields['content_id'];
				$this->mPalletId = (int)$result->fields['warehouse'];
				$this->mPalletName = $result->fields['title'];
				$this->mInfo['creator'] = (isset( $result->fields['creator_real_name'] ) ? $result->fields['creator_real_name'] : $result->fields['creator_user'] );
				$this->mInfo['editor'] = (isset( $result->fields['modifier_real_name'] ) ? $result->fields['modifier_real_name'] : $result->fields['modifier_user'] );
				$this->mInfo['display_url'] = $this->getDisplayUrl();
			}
		}
		LibertyContent::load();
 */
		$query = "SELECT pal.* FROM `warehouse_pallet` pal
				  WHERE pal.`pallet` = ?";
		$result = $this->mDb->query($query, array( $this->mPalletId ));
			if ( $result && $result->numRows() ) {
				$this->mInfo = $result->fields;
				$this->mContentId = 0;
				$this->mPalletName = $result->fields['pallet'];
			}
		return;
	}

	/**
	* verify, clean up and prepare data to be stored
	* @param $pParamHash all information that is being stored. will update $pParamHash by reference with fixed array of itmes
	* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
	* @access private
	**/
	function verify( &$pParamHash ) {
		// make sure we're all loaded up if everything is valid
		if( $this->isValid( $this->mContentId ) && empty( $this->mInfo ) ) {
			$this->load();
		}

		// It is possible a derived class set this to something different
		if( empty( $pParamHash['content_type_guid'] ) ) {
			$pParamHash['content_type_guid'] = $this->mContentTypeGuid;
		}

		if( $this->isValid( $this->mContentId ) ) {
			$pParamHash['content_id'] = $this->mContentId;
		} else {
			unset( $pParamHash['content_id'] );
		}
			
		// content store
		// check for name issues, first truncate length if too long
		if( !empty( $pParamHash['title'] ) )  {
			if( empty( $this->mContentId ) ) {
				if( empty( $pParamHash['title'] ) ) {
					$this->mErrors['title'] = 'You must enter a name for this incident report.';
				} else {
					$pParamHash['content_store']['title'] = substr( $pParamHash['title'], 0, 160 );
				}
			} else {
				$pParamHash['content_store']['title'] = ( isset( $pParamHash['title'] ) ) ? substr( $pParamHash['title'], 0, 160 ) : $this->mPalletName;
			}
		} elseif( empty( $pParamHash['title'] ) ) {
			// no name specified
			$this->mErrors['title'] = 'You must specify a name';
		}

		// Secondary store entries
		$pParamHash['secondary_store']['status'] = !empty( $pParamHash['status'] ) ? $pParamHash['status'] : 'O';
		$pParamHash['secondary_store']['priority'] = !empty( $pParamHash['priority'] ) ? $pParamHash['priority'] : '1';
		$pParamHash['secondary_store']['project_name'] = !empty( $pParamHash['project_name'] ) ? $pParamHash['project_name'] : 'Develope';
		$pParamHash['secondary_store']['revision'] = !empty( $pParamHash['revision'] ) ? $pParamHash['revision'] : '0.0';
		if ( !empty( $pParamHash['status'] ) and $pParamHash['status'] == 'C' ) {
			global $gBitUser;
			$pParamHash['secondary_store']['closed_user_id'] = $gBitUser->getUserId();
			$pParamHash['secondary_store']['closed'] = 'NOW';
		}
		return( count( $this->mErrors ) == 0 );
	}

	/**
	* Store incident report data
	* @param $pParamHash contains all data to store the IR
	* @param $pParamHash[title] title of the new IR
	* @param $pParamHash[edit] description of the IR
	* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
	* @access public
	**/
	function store( &$pParamHash ) {
		if( $this->verify( $pParamHash ) ) {
			// Start a transaction wrapping the whole insert into liberty 
			$this->mDb->StartTrans();
		    if ( LibertyContent::store( $pParamHash ) ) {
				$table = BIT_DB_PREFIX."irlist_secondary";
				// mContentId will not be set until the secondary data has commited 
				// What happened to THAT rule ???
				if( $this->verifyId( $this->mIRId ) ) {
					if( !empty( $pParamHash['secondary_store'] ) ) {
						$result = $this->mDb->associateUpdate( $table, $pParamHash['secondary_store'], array ( "content_id" => $this->mContentId ) );
					}
				} else {
					$pParamHash['secondary_store']['content_id'] = $pParamHash['content_id'];
					if( @$this->verifyId( $pParamHash['secondary_store']['ir_id'] ) ) {
						$pParamHash['secondary_store']['ir_id'] = $pParamHash['ir_id'];
					} else {
						$pParamHash['secondary_store']['ir_id'] = $this->mDb->GenID( 'ir_id_seq');
					}	
					$pParamHash['secondary_store']['parent_id'] = $pParamHash['secondary_store']['content_id'];
					$this->mIRId = $pParamHash['secondary_store']['ir_id'];
					$this->mContentId = $pParamHash['content_id'];
					$result = $this->mDb->associateInsert( $table, $pParamHash['secondary_store'] );
				}
				// load before completing transaction as firebird isolates results
				$this->load();
				$this->mDb->CompleteTrans();
			} else {
				$this->mDb->RollbackTrans();
			}
		}
		return( count( $this->mErrors ) == 0 );
	}

	/**
	 * Delete content object and all related records
	 */
	function expunge()
	{
		$ret = FALSE;
		if ($this->isValid() ) {
			$this->mDb->StartTrans();
			$query = "DELETE FROM `".BIT_DB_PREFIX."warehouse_pallet` WHERE `content_id` = ?";
			$result = $this->mDb->query($query, array($this->mContentId ) );
			if (LibertyAttachable::expunge() ) {
			$ret = TRUE;
				$this->mDb->CompleteTrans();
			} else {
				$this->mDb->RollbackTrans();
			}
		}
		return $ret;
	}
    
	/**
	* Returns list of an Pallet entries
	*
	* @param integer 
	* @param integer 
	* @param integer 
	* @return string Text for the title description
	*/
	function getList(&$pParamHash) {
		global $gBitSystem, $gBitUser;

		if( empty( $pParamHash["sort_mode"] ) ) {
			$pParamHash["sort_mode"] = 'pallet_asc';
		}
		LibertyContent::prepGetList( $pParamHash );

		// this will set $find, $sort_mode, $max_records and $offset
		extract( $pParamHash );

		$joinSql = '';
		$selectSql = '';
		$whereSql = '';
		$bindVars = array();
		array_push( $bindVars, $this->mContentTypeGuid );
		$this->getServicesSql( 'content_list_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

		if ($find) {
			$findesc = '%' . strtoupper( $find ) . '%';
			$whereSql = " AND (UPPER(b.`title`) like ? or UPPER(b.`description`) like ?) ";
			$bindVars = array( $bindVars, $findesc, $findesc );
		} 

/* Keep until LC links are available
  		$query = "SELECT wp.*, lc.*, 
				uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name,
				uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name,
				$selectSql
				FROM `".BIT_DB_PREFIX."warehouse_pallet` wp
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON ( lc.`content_id` = wp.`content_id` ) $joinSql
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON (uue.`user_id` = lc.`modifier_user_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON (uuc.`user_id` = lc.`user_id`)
				WHERE lc.`content_type_guid` = ? $whereSql
				ORDER BY ".$this->mDb->convertSortmode($sort_mode);
*/
  		$query = "SELECT wp.* 
				$selectSql
				FROM `".BIT_DB_PREFIX."warehouse_pallet` wp
				ORDER BY ".$this->mDb->convertSortmode($sort_mode);
		$result = $this->mDb->query( $query ,$bindVars ,$max_records ,$offset );

		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['display_url'] = WAREHOUSE_PKG_URL.'index.php?pallet_id='.trim($res['pallet']);
			$ret[] = $res;
		}

		// Get total result count
		$query_cant = "SELECT COUNT(wp.`pallet`) FROM `".BIT_DB_PREFIX."warehouse_pallet` wp";
//				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON ( lc.`content_id` = ir.`content_id` ) $joinSql
//				WHERE lc.`content_type_guid` = ? $whereSql";
		$pParamHash["cant"] = $this->mDb->getOne($query_cant, $bindVars);

		// add all pagination info to pParamHash
		LibertyContent::postGetList( $pParamHash );
		return $ret;
	}

	/**
	* Returns clients using space in a Warehouse
	* if no warehouse is specified, then a list of all clients is returned
	*
	* @param string filter to provide a subset of projects
	* @return array List of client records filtered by warehouse
	*/
	function getStockList( $pallet = NULL ) {
		$query = "SELECT stk.* FROM `warehouse_stock` stk
				  JOIN `warehouse_partlist` pro ON pro.`partno` = stk.`partno`
				  WHERE stk.`pallet` = ? ORDER BY stk.`partno`";
		$result = $this->mDb->query($query, array( $pallet ));
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['pallet_url'] = WAREHOUSE_PKG_URL.'display_pallet.php?pallet_id='.trim($res['pallet']);
			$res['product_url'] = WAREHOUSE_PKG_URL.'display_product.php?product_id='.trim($res['partno']);
			$res['subp'] = trim($res['subp']);
			$ret[] = $res;
		}

		$this->mInfo['stock'] = $ret;
		return $ret;
	}
	function getToPalletList( $pallet = NULL ) {
		$query = "SELECT sm.*, pro.*, rel.`rdate` FROM `warehouse_stockmove` sm
				  JOIN `warehouse_partlist` pro ON pro.`partno` = sm.`partno`
				  JOIN `warehouse_releases` rel ON rel.`release_no` = sm.`release_no` AND rel.`partno` = sm.`partno` AND rel.`batch` = sm.`batch`
				  WHERE sm.`top` = ? ORDER BY sm.`audit` DESC";
		$result = $this->mDb->query($query, array( $pallet ));
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['pallet_url'] = WAREHOUSE_PKG_URL.'display_pallet.php?pallet_no='.trim($res['palletno']);
			$res['product_url'] = WAREHOUSE_PKG_URL.'display_product.php?product_id='.trim($res['partno']);
			$res['batch_url'] = WAREHOUSE_PKG_URL.'display_batch.php?batch_id='.trim($res['batch']);
			$ret[] = $res;
		}

		$this->mInfo['top'] = $ret;
		return $ret;
	}
	function getFromPalletList( $pallet = NULL ) {
		$query = "SELECT sm.*, pro.*, rel.`rdate` FROM `warehouse_stockmove` sm
				  JOIN `warehouse_partlist` pro ON pro.`partno` = sm.`partno`
				  JOIN `warehouse_releases` rel ON rel.`release_no` = sm.`release_no` AND rel.`partno` = sm.`partno` AND rel.`batch` = sm.`batch`
				  WHERE sm.`fromp` = ? ORDER BY sm.`audit` DESC";
		$result = $this->mDb->query($query, array( $pallet ));
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['pallet_url'] = WAREHOUSE_PKG_URL.'display_pallet.php?pallet_no='.trim($res['palletno']);
			$res['product_url'] = WAREHOUSE_PKG_URL.'display_product.php?product_id='.trim($res['partno']);
			$res['batch_url'] = WAREHOUSE_PKG_URL.'display_batch.php?batch_id='.trim($res['batch']);
			$ret[] = $res;
		}
		$this->mInfo['fromp'] = $ret;
		return $ret;
	}

}
?>
