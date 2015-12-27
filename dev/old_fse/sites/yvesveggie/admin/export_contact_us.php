<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
			header( "Location: login.php" );
		}
		
		header('Content-Type: text/x-csv' );
		header('Content-Disposition: inline; filename="contact_us.csv"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		require( "inc/class.objectivedb.php" );
		require( "inc/functions.php" );
		
		$db = new objectiveDb( "mysql" );
		$db->connect( "208.35.60.218", "yves", "kl33nex", "yves" ); // kl33nex
		
		$reviewResult = $db->query( "select countries.name, language.name,  contact_us_subjects.name, contact_us.first_name, contact_us.last_name, contact_us.email, contact_us.message, contact_us.date_posted" .
		                            "  from language, countries, contact_us, contact_us_subjects " .
		                            " where contact_us.language_id         = language.language_id ".
		                            "   and contact_us.country_id          = countries.country_id ".
		                            "   and contact_us.subject_id          = contact_us_subjects.subject_id ".
		                            " order by contact_us.date_posted" );
		
		$csvBuffer = "country, language, subject, first_name, last_name, email, message, date\n";
		
		if( $db->numRows( $reviewResult ) ) {
			while( list( $countryName, $languageName, $subjectName, $firstName, $lastName, $email, $message, $datePosted ) = $db->fetchRow( $reviewResult ) ) {
								
				$csvBuffer .= printCSV( array( $countryName, $languageName, $subjectName, $firstName, $lastName, $email, $message, $datePosted ) );
			}
		}
		
		echo( $csvBuffer );	?>