<?php
/**
 * @version $Header: 
 *
 * Copyright ( c ) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * @package warehouse
 */

/**
 * required setup
 */
require_once( LIBERTY_PKG_PATH.'LibertyContent.php' );		// IRList base class

/**
 * @package warehouse
 */
class Warehouse extends LibertyContent {
	var $mWarehouseId;

	/**
	 * Constructor 
	 * 
	 * Build an Warehouse object based on LibertyContent
	 * @param integer Warehouse identifer
	 * @param integer Base content_id identifier 
	 */
	function Warehouse( $pWarehouseId = NULL, $pContentId = NULL ) {
		LibertyContent::LibertyContent();
		$this->registerContentType( WAREHOUSE_CONTENT_TYPE_GUID, array(
				'content_type_guid' => WAREHOUSE_CONTENT_TYPE_GUID,
				'content_description' => 'Warehosue Location',
				'handler_class' => 'Warehouse',
				'handler_package' => 'warehosue',
				'handler_file' => 'Warehouse.php',
				'maintainer_url' => 'http://www.lsces.co.uk'
			) );
		$this->mWarehouseId = (int)$pWarehouseId;
		$this->mContentId = (int)$pContentId;
		$this->mContentTypeGuid = WAREHOSUE_CONTENT_TYPE_GUID;
	}

	/**
	 * Load an Warehouse content Item
	 *
	 * (Describe Warehouse object here )
	 */
	function load($pContentId = NULL) {
		if ( $pContentId ) $this->mContentId = (int)$pContentId;
		if( @$this->verifyId( $this->mIRId ) || @$this->verifyId( $this->mContentId ) ) {
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
				$this->mWarehouseId = (int)$result->fields['warehouse'];
				$this->mWarehouseName = $result->fields['title'];
				$this->mInfo['creator'] = (isset( $result->fields['creator_real_name'] ) ? $result->fields['creator_real_name'] : $result->fields['creator_user'] );
				$this->mInfo['editor'] = (isset( $result->fields['modifier_real_name'] ) ? $result->fields['modifier_real_name'] : $result->fields['modifier_user'] );
				$this->mInfo['display_url'] = $this->getDisplayUrl();
			}
		}
		LibertyContent::load();
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
				$pParamHash['content_store']['title'] = ( isset( $pParamHash['title'] ) ) ? substr( $pParamHash['title'], 0, 160 ) : $this->mWarehouseName;
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
			$query = "DELETE FROM `".BIT_DB_PREFIX."irlist` WHERE `content_id` = ?";
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
    * Returns Request_URI to an Warehouse content object
    *
    * @param string name of
    * @param array different possibilities depending on derived class
    * @return string the link to display the page.
    */
	function getDisplayUrl( $pContentId=NULL ) {
		global $gBitSystem;
		if( empty( $pContentId ) ) {
			$pContentId = $this->mContentId;
		}

		return IRLIST_PKG_URL.'index.php?content_id='.$pContentId;
	}

	/**
	* Returns HTML link to display an Warehouse object
	* 
	* @param string Not used ( generated locally )
	* @param array mInfo style array of content information
	* @return the link to display the page.
	*/
	function getDisplayLink( $pText, $aux ) {
		if ( $this->mContentId != $aux['content_id'] ) $this->load($aux['content_id']);

		if (empty($this->mInfo['ir_id']) ) {
			$ret = '<a href="'.$this->getDisplayUrl($aux['content_id']).'">'.$aux['title'].'</a>';
		} else {
			$ret = '<a href="'.$this->getDisplayUrl($aux['content_id']).'">'."IR-".$this->mInfo['ir_id'].'-'.$this->mInfo['title'].'</a>';
		}
		return $ret;
	}

	/**
	* Returns title of an Warehouse object
	*
	* @param array mInfo style array of content information
	* @return string Text for the title description
	*/
	function getTitle( $pHash = NULL ) {
		$ret = NULL;
		if( empty( $pHash ) ) {
			$pHash = &$this->mInfo;
		} else {
			if ( $this->mContentId != $pHash['content_id'] ) {
				$this->load($pHash['content_id']);
				$pHash = &$this->mInfo;
			}
		}

		if( !empty( $pHash['title'] ) ) {
			$ret = "IR-".$this->mInfo['ir_id'].'-'.$this->mInfo['title'];
		} elseif( !empty( $pHash['content_description'] ) ) {
			$ret = $pHash['content_description'];
		}
		return $ret;
	}

	/**
	* Returns list of an Warehouse entries
	*
	* @param integer 
	* @param integer 
	* @param integer 
	* @return string Text for the title description
	*/
	function getList(&$pParamHash) {
		global $gBitSystem, $gBitUser;

		if( empty( $pParamHash["sort_mode"] ) ) {
			$pParamHash["sort_mode"] = 'warehouse_desc';
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

		$query = "SELECT wh.*, lc.*, 
				uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name,
				uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name,
				uux.`login` AS closed_user, uuc.`real_name` AS closed_real_name
				$selectSql
				FROM `".BIT_DB_PREFIX."wharehouse_list` wh
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON ( lc.`content_id` = ir.`content_id` ) $joinSql
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON (uue.`user_id` = lc.`modifier_user_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON (uuc.`user_id` = lc.`user_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uux ON (uux.`user_id` = ir.`closed_user_id`)
				WHERE lc.`content_type_guid` = ? $whereSql
				ORDER BY ".$this->mDb->convert_sortmode($sort_mode);

		$result = $this->mDb->query( $query ,$bindVars ,$max_records ,$offset );

		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['display_url'] = $this->getDisplayUrl( $res['content_id'] );
			$ret[] = $res;
		}

		// Get total result count
		$query_cant = "SELECT COUNT(wh.`warehouse`) FROM `".BIT_DB_PREFIX."warehouse_list` wh
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON ( lc.`content_id` = ir.`content_id` ) $joinSql
				WHERE lc.`content_type_guid` = ? $whereSql";
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
	function getClientList( $warehouse = NULL ) {
		if ($warehouse) {
			$mid = "WHERE `project_name` STARTING '$project'";
		} else { $mid = ''; }
		$query = "SELECT cl.* FROM `warehouse_client`
				  $mid ORDER BY cl.`name`";
		$result = $this->mDb->query($query);
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['display_url'] = $this->getDisplayUrl( $res['content_id'] );
			$ret[] = $res;
		}

		$ret["cant"] = count( $ret );
		return $ret;
	}
}
?>