<?	// page initialization stuff
		// ellerbeck

		require( "inc/class.objectivedb.php" );
		require( "inc/functions.php" );
		
		$db = new objectiveDb( "mysql" );
		//$db->connect( "localhost", "root", "", "yves" ); // kl33nex
		$db->connect( "208.35.60.218", "yves", "kl33nex", "yves" ); // kl33nex
		//$db->connect( "localhost", "yves", "kl33nex", "yves" ); // kl33nex
		
		session_name( "yves" );
		session_start();

		foreach( get_html_translation_table( HTML_ENTITIES ) as $key => $value ) {
			if( $key != "\"" && $key != "<" && $key != ">" && $key != "&" ) {
				$trans[ $key ] = $value;
			}
		}

		global $db, $md5Token, $userId, $trans;

		$sName = basename( $_SERVER[ "PHP_SELF" ] );
		parse_str( $_SERVER[ "QUERY_STRING" ], $queryS );
		
		if( $delTable && $idColumn && $idNum ) {
			if( !checkLogin( $sName ) ) {
			 	header( "Location: login.php" );
			} else {
				$delResult = $db->query( "delete from $delTable where $idColumn = '$idNum'" );
			}
		}

		if( $delCascadeTable && $idColumn && $idNum && $otherTables ) {
			if( !checkLogin( $sName ) ) {
			 	header( "Location: login.php" );
			} else {
				$delResult = $db->query( "delete from $delCascadeTable where $idColumn = '$idNum'" );
				
				$otherArr = explode( " ", $otherTables );
				foreach( $otherArr as $otherTableName ) {
					$delResult = $db->query( "delete from $otherTableName where $idColumn = '$idNum'" );
				}
			}
		}
		
		if( $delAllTable ) {
			if( !checkLogin( $sName ) ) {
			 	header( "Location: login.php" );
			} else {
				$delResult = $db->query( "delete from $delAllTable" );
			}
		}
		
		if( $logoff ) {
			session_destroy();
			header( "Location: login.php" );
		}
						?>