<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
			header( "Location: login.php" );
		}
		
		header('Content-Type: text/x-csv' );
		header('Content-Disposition: inline; filename="questionnaire.csv"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		require( "inc/class.objectivedb.php" );
		require( "inc/functions.php" );
		
		$db = new objectiveDb( "mysql" );
		$db->connect( "208.35.60.218", "yves", "kl33nex", "yves" ); // kl33nex
		
		$csvBuffer = "gender, age, diet_type, why_buy, prime_consumer, buy_frequency, products, total_qty, consumer_length, comments, taste_panel, email, country, language, date_posted\n";

		$reviewResult = $db->query( "select q.gender, q.age, q.diet_type, q.why_buy, q.prime_consumer, q.buy_frequency, q.products, q.total_qty, ".
		                            "       q.consumer_length, q.comments, q.taste_panel, q.email, countries.name, language.name, q.date_posted ".
		                            "from   questionnaire as q, language, countries " .
		                            "where  q.country_id = countries.country_id ".
		                            "and    q.language_id = language.language_id" );
		
		
		if( $db->numRows( $reviewResult ) ) {
			while( list( $gender, $age, $dietType, $whyBuy, $primeConsumer, $buyFrequency, $products, $totalQty, $consumerLength, $comments, $tastePanel, $email, $countryId, $languageId, $datePosted ) = $db->fetchRow( $reviewResult ) ) {
								
				$csvBuffer .= printCSV( array( $gender, $age, $dietType, $whyBuy, $primeConsumer, $buyFrequency, $products, $totalQty, $consumerLength, $comments, $tastePanel, $email, $countryId, $languageId, $datePosted ) );
			}
		}
		
		echo( $csvBuffer );	?>