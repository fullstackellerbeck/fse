<?	include( "inc/init.php" );

		if( !$compare_id && $continue ) {
			$productInsertResult = $db->query( "insert into products_compare ( product_id ) values ( '$product_id' )" );
			
			$compare_id = $db->lastID();
			$justAdded = true;
		}
		
		if( $continue ) {
			$nutRemoveResult = $db->query( "delete from products_compare_attribs where compare_id='$compare_id'" );
			
			for( $i = 0; $i < sizeof( $attribId ); $i++ ) {
				if( $yvesValue[ $i ] || $otherValue[ $i ] ) {
					$query = "insert into products_compare_attribs ".
					         "          ( compare_id, attribute_id, yves_value, other_value ) ".
					         "   values ( '$compare_id', '" . $attribId[ $i ] . "', '" . $yvesValue[ $i ] . "', '" . $otherValue[ $i ] . "' )";
					
					$nutInsertResult = $db->query( $query );
					echo( $db->errorMsg() );
				}
			}
		}		?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">

<?	if( $justAdded ) {	?>
			<script language="javascript">
				top.document.bunny.compare_id.value = '<?= $compare_id; ?>';
			</script>
<?	}	?>
	</head>
	
	<body style="width: 448px; background-color: #f9f9f9; margin-top: 0px;">
		<div style="height: 15px; border: 1px solid #ddd; margin-bottom: 10px; padding: 5px 0px 3px 0px; border-top: 0px; border-left: 0px; border-right: 0px;"><center><b>Please remember this information must be submitted seperately.</b></center></div>
		<form name="bunny" action="nutritional_comparison_iframe.php" method="post" style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
	<?	if( $product_id ) {
				$familyResult = $db->query( "select products_family.country_id, products_family.language_id ".
				                            "  from products_family, products ".
				                            " where products.product_id = '$product_id' ".
				                            "   and products.family_id  = products_family.family_id" );
				if( $db->numRows( $familyResult ) ) {
					list( $countryId, $languageId ) = $db->fetchRow( $familyResult );	?>

					<input type="hidden" name="country_id" value="<?= $countryId; ?>">
					<input type="hidden" name="language_id" value="<?= $languageId; ?>">
					<input type="hidden" name="compare_id" value="<?= $compare_id; ?>">
					<input type="hidden" name="product_id" value="<?= $product_id; ?>">
					<input type="hidden" name="jumpto" value="">
					<input type="hidden" name="jumpindex" value="">
					<input type="hidden" name="continue" value="true">
					
					<div style="background-color: transparent; width: 100%;">
						<div class="left" style="width: 168px;">&nbsp;</div>
						<div class="left" style="width: 140px; padding-left: 6px;"><b>Yves product</b></div>
						<div class="left" style="width: 80px; padding-left: 2px;"><b>Other product</b></div>
						<div class="spacer"></div>
					</div>
					<div class="divider" style="margin-bottom: 0px;"></div>
			<?	$bgColor = false;
			
					$nutResult = $db->query( "select attribute_id, name, units ".
					                         "  from nutritional_compare_attribs ".
					                         " where country_id  = '$countryId' ".
					                         "   and language_id = '$languageId' ".
					                         " order by units asc" );
					if( $db->numRows( $nutResult ) ) {
						$attribIndex = 0;
						while( list( $attributeId, $name, $units ) = $db->fetchRow( $nutResult ) ) {
	
							$prodAttribResult = $db->query( "select yves_value, other_value from products_compare_attribs where compare_id = '$compare_id' and attribute_id = '$attributeId'" );
							if( $db->numRows( $prodAttribResult ) ) {
								list( $dbYvesValue, $dbOtherValue ) = $db->fetchRow( $prodAttribResult );
							} else {
								$dbYvesValue  = $yvesValue[ $attribIndex ];
								$dbOtherValue = $otherValue[ $attribIndex ];
							}	?>
							<div style="background-color: <?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>; padding: 3px 10px 2px 10px;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>';">
								<div class="left" style="width: 160px;"><a name="attrib_<?= $attribIndex; ?>"><?= $name; ?></a></div>
								<div class="left" style="width: 145px;">
									<input type="text" name="yvesValue[]" id="attrib_<?= $attribIndex; ?>" class="admintext" style="width: 80px; background-color: #ffffff;" value="<?= $dbYvesValue; ?>">&nbsp;<?= $units ? $units : ($isRDI == "Y" ? "%RDI" : ""); ?>
								</div>
								<div class="left" style="width: 75px;">
									<input type="text" name="otherValue[]" id="attrib_<?= $attribIndex; ?>" class="admintext" style="width: 80px; background-color: #ffffff;" value="<?= $dbOtherValue; ?>">&nbsp;<?= $units ? $units : ($isRDI == "Y" ? "%RDI" : ""); ?>
								</div>
								<div class="spacer"></div>
							</div>
							<div class="spacer"></div>
							<input type="hidden" name="attribId[]" value="<?= $attributeId; ?>">
				<?		$bgColor = !$bgColor;
							$attribIndex++;
						}
					}
				}
			}	?>
			<div class="divider" style="margin-bottom: 0px; margin-top: 0px;"></div>
			<div style="padding: 8px 10px 2px 10px;">
				<div class="left" style="width: 157px;">&nbsp;</div>
				<div style="width: 118px;"><input type="submit" name="continue" value="Continue" class="adminbutton"></div>
				<div class="spacer"></div>
			</div>
			
			<script language="javascript">
				location.href = '#<?= $jumpto; ?>';
			</script>
		</form>
	</body>
</html>
