<?	// page initialization stuff
		// ellerbeck

		require( "inc/class.objectivedb.php" );
		require( "inc/functions.php" );
		
		global $copyArr, $buttonArr, $trans, $queryArr;
		
		$db = new objectiveDb( "mysql" );
		$db->connect( "localhost", "root", "N3verm0r3!", "yves" ); // kl33nex
		//$db->connect( "208.35.60.218", "yves", "kl33nex", "yves" ); // kl33nex
		//$db->connect( "localhost", "yves", "kl33nex", "yves" );

		session_name( "yves" );
		session_start();
		
		$scriptName = basename( $_SERVER[ "PHP_SELF" ] );
		parse_str( $_SERVER[ "QUERY_STRING" ], $queryArr );

		$_SESSION['scriptName'] = "";		

		if( $sess_language_id ) {
			$seperatorRes = $db->query( "select number_seperator from language where language_id = '$sess_language_id'" );
			if( $db->numRows( $seperatorRes ) ) {
				list( $numSeperator ) = $db->fetchRow( $seperatorRes );
				
				$_SESSION['numSeperator'] = "";
			}
		}
				
		// reomves all 'tag' like characters from the html translation table
		foreach( get_html_translation_table( HTML_ENTITIES ) as $key => $value ) {
			if( $key != "\"" && $key != "<" && $key != ">" && $key != "&" ) {
				$trans[ $key ] = $value;
			}
		}

		// grabs the miscellaneous content for all pages for the current
		// country_id and language_id
		if( $sess_language_id && $sess_country_id ) {
			$copyResult = $db->query( "select attrib, value ".
			                          "  from pages_misc_copy ".
			                          " where country_id  = '$sess_country_id' ".
			                          "   and language_id = '$sess_language_id'" );
			                          
			if( $db->numRows( $copyResult ) ) {
				while( list( $copyKey, $copyValue ) = $db->fetchRow( $copyResult ) ) {
					$copyArr[ $copyKey ] = $copyValue;
				}
			}

			$buttonResult = $db->query( "select attrib, file_name ".
			                            "  from pages_buttons ".
			                            " where country_id  = '$sess_country_id' ".
			                            "   and language_id = '$sess_language_id'" );
			                          
			if( $db->numRows( $buttonResult ) ) {
				while( list( $buttonKey, $fileName ) = $db->fetchRow( $buttonResult ) ) {
					if( $fileName && file_exists( realpath( $fileName ) ) ) {
						list( $width, $height, $type, $htmlWh ) = getimagesize( realpath( $fileName ) );
					}

					$buttonArr[ $buttonKey ] = array( $fileName, $width, $height );
				}
			}
		}
				
		if( $delTable && $idColumn && $idNum ) {
			$delResult = $db->query( "delete from $delTable where $idColumn = '$idNum'" );
		}			?>
