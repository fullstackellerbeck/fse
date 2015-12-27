<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
			header( "Location: login.php" );
		}
		
		header('Content-Type: text/x-csv' );
		header('Content-Disposition: inline; filename="reviews.csv"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		require( "inc/class.objectivedb.php" );
		require( "inc/functions.php" );
		
		$db = new objectiveDb( "mysql" );
		$db->connect( "208.35.60.218", "yves", "kl33nex", "yves" ); // kl33nex

		
		$reviewResult = $db->query( "select products.name, products_family.country_id, products_family.language_id, products_review.first_name, products_review.last_name, products_review.email, products_review.review, products_review.date_modified " .
		                            "  from products, products_family, products_review " .
		                            " where products_review.product_id = products.product_id ".
		                            "   and products.family_id         = products_family.family_id ".
		                            " order by products_family.country_id, products_family.language_id" );
		
		$csvBuffer = "country, language, product_name, first_name, last_name, email, review, date\n";
		
		if( $db->numRows( $reviewResult ) ) {
			while( list( $productName, $countryId, $languageId, $firstName, $lastName, $email, $review, $reviewDate ) = $db->fetchRow( $reviewResult ) ) {
				
				$countryResult = $db->query( "select name from countries where country_id = '$countryId'" );
				if( $db->numRows( $countryResult ) ) {
					list( $countryName ) = $db->fetchRow( $countryResult );
				}
				
				$languageResult = $db->query( "select name from language where language_id = '$languageId'" );
				if( $db->numRows( $languageResult ) ) {
					list( $languageName ) = $db->fetchRow( $languageResult );
				}
				
				$csvBuffer .= printCSV( array( $countryName, $languageName, $productName, $firstName, $lastName, $email, $review, $reviewDate ) );
			}
		}
		
		echo( $csvBuffer ); ?>