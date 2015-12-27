<?	// objectiveDb database abstraction class
		// chris ellerbeck
		// copyright (c)  2001.
		//
		// this currently supports only mysql. more will be added with time

		class objectiveDb {
			var $mySQL = "false", $oracle = "false", $dbHandle, $debug, $lastQuery;
			
			function dbClass( $dbType, $debug = false ) {
				if( $dbType == "mysql" ) $this->mySQL = true;
				$this->debug = $debug;			
			}
			
			function connect( $hostAddr, $user, $pass, $dbName ) {
				if( $this->mySQL ) {
					$this->dbHandle = mysql_connect( $hostAddr, $user, $pass );
					mysql_select_db( $dbName, $this->dbHandle );
				}
				
				return( $this->dbHandle );
			}
			
			function setdbHandle( $handle ) {
				return( $this->dbHandle = $handle );
			}
	
			function getdbHandle() {
				return( $this->dbHandle );
			}
			
			function getlastQuery() {
				return( $this->lastQuery );
			}
	
			function query( $sql ) {
				if( $this->mySQL ) {
					$this->lastQuery = $sql;
					$result = mysql_query( $sql, $this->dbHandle );
				}
				
				return( $result );
			}
			
			function changeDB( $dbName ) {
				if( $this->mySQL ) $result = mysql_select_db( $dbName, $this->dbHandle );
				return( $result );
			}
			
			function fetchRow( $queryResult, $fetch_assoc=false ) {
				if( $this->mySQL ) {
					if( $fetch_assoc )
						$result = mysql_fetch_array( $queryResult, MYSQL_ASSOC );
					else
						$result = mysql_fetch_array( $queryResult );

					echo( $this->errorMsg() );
				}
						
				return( $result );
			}
	
			function numRows( $queryResult ) {
				if( $this->mySQL ) $result = mysql_num_rows( $queryResult );
				return( $result );
			}
			
			function numFields( $queryResult ) {
				if( $this->mySQL ) $result = mysql_num_fields( $queryResult );
				return( $result );
			}
	
			function fieldinfoArray( $queryResult, $fieldOffset ){
				if( $this->mySQL ) {				
					$infoArray = array( "name"  => mysql_field_name( $queryResult, $fieldOffset ),
															"type"  => mysql_field_type( $queryResult, $fieldOffset ),
															"len"   => mysql_field_len( $queryResult, $fieldOffset ),
															"flags" => mysql_field_flags( $queryResult, $fieldOffset ) );
				}
						
				return( $infoArray );
			}
			
			function resetResult( $queryResult ) {
				if( $this->mySQL ) {
					if( mysql_num_rows( $queryResult ) ) {
						$result = mysql_data_seek( $queryResult, 0 );
					} else {
						$result = false;
					}
				}
					
				return( $result );
			}
			
			function lastID() {
				if( $this->mySQL ) $result = mysql_insert_id( $this->dbHandle );
				return( $result );
			}
	
			function errorMsg() {
				if( $this->mySQL ) $result = mysql_error( $this->dbHandle );
				return( $result );
			}
			
			function createInsert( $columnArray, $primary, $tableName ) {
				// add slashes if magic quotes is off, trim each value
				if( !get_magic_quotes_gpc() ) {
					while( list( $key, $value ) = each( $columnArray ) )
						$columnArray[ $key ] = trim( addslashes( $value ) );
				} else {
					while( list( $key, $value ) = each( $columnArray ) )
						$columnArray[ $key ] = trim( $value );
				}
	
				reset( $columnArray );
	
				// generate query
				list( $pri_key, $pri_value ) = $primary;			
	
				if( $pri_value ) {
					list( $key, $value ) = each( $columnArray );
					$query = "update $tableName set $key=$value";
		
					while( list( $key, $value ) = each( $columnArray ) )
						$query .= ", $key=$value";
					
					$query .= " where $pri_key='$pri_value'";
				} else {
					list( $key, $value ) = each( $columnArray );
					$column_names  = $key;
					$column_values = $value;
									
					while( list( $key, $value ) = each( $columnArray ) ) {
						$column_names  .= ", $key";
						$column_values .= ", $value";
					}
					
					$query .= "insert into $tableName ($column_names) values ($column_values)";
				}
		
				return( $query );
			}

			function createSearch( $keywords, $tableName, $tableInfo, $colOrderBy ) {
				list( $primaryKey, $columns, $uri, $rTableName, $rPrimaryKey, $rColumns, $searchId ) = $tableInfo;
				
				for( $keywordIndx = 0; $keywordIndx < sizeof( $keywords ); $keywordIndx++ ) {
					$modChar = substr( $keywords[ $keywordIndx ], 0, 1 );
					$currentKey = $keywords[ $keywordIndx ];
					
					if( ($modChar != "+") && ($modChar != "-") ) {
						$keyOperator = "or";
					} else {
						$currentKey = substr( $currentKey, 1, strlen( $currentKey ) );						
						$keyOperator = ( $modChar != "+" ? "not in" : "and" );
					}

					$searchKeys[ $currentKey ] = $keyOperator;
				}
				
				arsort( $searchKeys );
				$keywordKeys      = array_keys( $searchKeys );
				$keywordOperators = array_values( $searchKeys );
				
				$columns = @array_merge( array_keys( $columns ), array_keys( $rColumns ) );
				$colString = implode( ",", $columns );
	
				$query = "select $tableName.$primaryKey,$colString from ". ( $rTableName ? "$tableName, $rTableName" : "$tableName" ) ." where ( ";

				for( $keyIndex = 0; $keyIndex < sizeof( $searchKeys ); $keyIndex++ ) {
					$query .= " ( ";
					
					while( list( $columnIndex, $columnName ) = each( $columns ) ) {
						$query .= ( $columnIndex > 0 ? " or " : "" ) ."$columnName like '%". $keywordKeys[ $keyIndex ] ."%'";
					}
					
					$query .= " ) ". (($keyIndex + 1) < sizeof( $searchKeys ) ? $keywordOperators[ $keyIndex + 1 ] : "");
					reset( $columns );
				}
	
				$search_result = $this->query( $query .= ( $rTableName ? ") and ($tableName.$rPrimaryKey = $rTableName.$rPrimaryKey" : "" ) . ") ". ( $colOrderBy ? "order by $colOrderBy" : "" ) );
				if( $this->numRows( $search_result ) ) {
					$columns = array_merge( array( "$tableName.$primaryKey" ), $columns );				
					while( $fetchedArr = $this->fetchRow( $search_result ) ) {
						
						for( $resultIndx = 0; $resultIndx < sizeof( $columns ); $resultIndx++ ) {	
							list( $realColName_key, $realColName_value ) = each( $columns );
							$resultArr[ $columns[ $resultIndx ] ] = $fetchedArr[ $resultIndx ];
						}
						
						reset( $columns );
						$returnArr[] = $resultArr;
					}
				}
	
				return( $returnArr );
			}
		}		?>