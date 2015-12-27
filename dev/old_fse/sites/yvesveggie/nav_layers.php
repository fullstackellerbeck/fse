
  	<DIV ID="lItem0" NAME="lItem0"></DIV>
		<DIV ID="lItem1" NAME="lItem1"></DIV>
		<DIV ID="lItem2" NAME="lItem2"></DIV>
		<DIV ID="lItem3" NAME="lItem3"></DIV>
		<DIV ID="lItem4" NAME="lItem4"></DIV>
		<DIV ID="lItem5" NAME="lItem5"></DIV>
		<DIV ID="lItem6" NAME="lItem6"></DIV>
		<DIV ID="lItem7" NAME="lItem7"></DIV>
		<DIV ID="lItem8" NAME="lItem8"></DIV>
		<DIV ID="lItem9" NAME="lItem9"></DIV>
		<DIV ID="lItem10" NAME="lItem10"></DIV>
		<DIV ID="lItem11" NAME="lItem11"></DIV>
		<DIV ID="lItem12" NAME="lItem12"></DIV>
		<DIV ID="lItem13" NAME="lItem13"></DIV>
		<DIV ID="lItem14" NAME="lItem14"></DIV>
		<DIV ID="lItem15" NAME="lItem15"></DIV>
		<DIV ID="lItem16" NAME="lItem16"></DIV>
		<DIV ID="lItem17" NAME="lItem17"></DIV>
		<DIV ID="lItem18" NAME="lItem18"></DIV>
		<DIV ID="lItem19" NAME="lItem19"></DIV>
		<DIV ID="lItem20" NAME="lItem20"></DIV>
		<DIV ID="lItem21" NAME="lItem21"></DIV>
		
<?	$itemCount = 0;

		$familyCountResult = $db->query( "select family_id from products_family where country_id='1' and language_id='1' and live='Y'" );
	
		while( list( $familyId ) = $db->fetchRow( $familyCountResult ) ) {	
			$productCountResult = $db->query( "select count( product_id ) from products where family_id='$familyId' and live='Y'" );
			list( $productCount ) = $db->fetchRow( $productCountResult );
			
			$itemCount += ($productCount + 1);
		}
		
		for( $i = 0; $i < $itemCount; $i++ ) {	?>
		<DIV ID="lItem<?= $i + 22; ?>" NAME="lItem<?= $i + 21; ?>"></DIV>
<?	}	?>

		<DIV ID="floater" NAME="floater" onmouseover="clearTimeout( timeOverId );" onmouseout="timeOverId = timeOut();"></DIV>
