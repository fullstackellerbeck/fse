<?	header( "Content-type: text/css" );
		ini_set( "include_path", "../" );
		include( "inc/init.php" );	?>
#lItem0 { position:absolute; z-index: 1; background-color: #f3f3f3; }
#lItem1 { position:absolute; z-index: 1; }
#lItem2 { position:absolute; z-index: 1; }
#lItem3 { position:absolute; z-index: 1; }
#lItem4 { position:absolute; z-index: 1; }
#lItem5 { position:absolute; z-index: 1; }
#lItem6 { position:absolute; z-index: 1; }
#lItem7 { position:absolute; z-index: 1; }
#lItem8 { position:absolute; z-index: 1; }
#lItem9 { position:absolute; z-index: 1; }
#lItem10 { position:absolute; z-index: 1; }
#lItem11 { position:absolute; z-index: 1; }
#lItem12 { position:absolute; z-index: 1; }
#lItem13 { position:absolute; z-index: 1; }
#lItem14 { position:absolute; z-index: 1; }
#lItem15 { position:absolute; z-index: 1; }
#lItem16 { position:absolute; z-index: 1; }
#lItem17 { position:absolute; z-index: 1; }
#lItem18 { position:absolute; z-index: 1; }
#lItem19 { position:absolute; z-index: 1; }
#lItem20 { position:absolute; z-index: 1; }
#lItem21 { position:absolute; z-index: 1; }
#floater { position:absolute; z-index: 5; top: 0px; left: 0px; }
#navLocation { position:absolute; z-index: 5; }

<?	$itemCount = 0;

		$familyCountResult = $db->query( "select family_id from products_family where country_id='1' and language_id='1' and live='Y'" );
	
		while( list( $familyId ) = $db->fetchRow( $familyCountResult ) ) {	
			$productCountResult = $db->query( "select count( product_id ) from products where family_id='$familyId' and live='Y'" );
			list( $productCount ) = $db->fetchRow( $productCountResult );
			
			$itemCount += ($productCount + 1);
		}
		
		for( $i = 0; $i < $itemCount; $i++ ) {	?>
			#lItem<?= $i + 22; ?> { position:absolute; z-index: 1; }
<?	}	?>

