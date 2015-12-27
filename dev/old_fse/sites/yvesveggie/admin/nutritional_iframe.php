<?	include( "inc/init.php" );

		if( !$product_id && $continue ) {
			$productInsertResult = $db->query( "insert into products ( family_id ) values ( '$family_id' )" );
			
			$product_id = $db->lastID();
			$justAdded = true;
		}
		
		if( $country_id && $language_id && $product_id ) {
			$nutRemoveResult = $db->query( "delete from products_nutritional_attribs where product_id='$product_id'" );
			
			for( $i = 0; $i < sizeof( $attrib ); $i++ ) {
				if( $attrib[ $i ] != "" ) {
					$nutInsertResult = $db->query( "insert into products_nutritional_attribs ".
					                               "          ( product_id, attribute_id, value ) ".
					                               "   values ( '$product_id', '" . $attribId[ $i ] . "', '" . $attrib[ $i ] . "' )" );
				                               
				}
			}
		}	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">

<?	if( $justAdded ) {	?>
			<script language="javascript">
				top.document.bunny.product_id.value = '<?= $product_id; ?>';
			</script>
<?	}	?>
	</head>
	
	<body style="width: 448px; background-color: #f9f9f9; margin-top: 0px;">
		<form name="bunny" action="nutritional_iframe.php" method="post">
	<?	if( $family_id ) {
				$familyResult = $db->query( "select country_id, language_id from products_family where family_id='$family_id'" );
				if( $db->numRows( $familyResult ) ) {
					list( $countryId, $languageId ) = $db->fetchRow( $familyResult );	?>

					<input type="hidden" name="family_id" value="<?= $family_id; ?>">
					<input type="hidden" name="country_id" value="<?= $countryId; ?>">
					<input type="hidden" name="language_id" value="<?= $languageId; ?>">
					<input type="hidden" name="product_id" value="<?= $product_id; ?>">
					<input type="hidden" name="jumpto" value="">
					<input type="hidden" name="jumpindex" value="">
					<input type="hidden" name="continue" value="true">
					
			<?	$bgColor = false;
			
					$nutResult = $db->query( "select attribute_id, name, units, is_rdi from nutritional_attribs where country_id = '$countryId' and language_id = '$languageId' order by priority asc, is_rdi desc" );
					if( $db->numRows( $nutResult ) ) {
						$attribIndex = 0;
						while( list( $attributeId, $name, $units, $isRDI ) = $db->fetchRow( $nutResult ) ) {
							if( $product_id ) {
								$nutAttribResult = $db->query( "select value from products_nutritional_attribs where product_id = '$product_id' and attribute_id = '$attributeId'" );
								if( $db->numRows( $nutAttribResult ) ) {
									list( $dValue ) = $db->fetchRow( $nutAttribResult );
								} else {
									unset( $dValue );
								}
							}		?>
							<div style="padding-top: 6px; padding-bottom: 3px; background-color: <?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>; padding: 2px 10px 2px 10px;" onmouseover="this	.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>';">
								<div class="left" style="width: 130px;"><a name="attrib_<?= $attribIndex; ?>"><?= $name; ?></a></div>
								<div class="left" style="width: 270px;">
									<input type="text" name="attrib[]" id="attrib_<?= $attribIndex; ?>" class="admintext" style="width: 200px; background-color: #ffffff;" value="<?= $dValue; ?>" onchange="document.bunny.jumpto.value='attrib_<?= $attribIndex; ?>';document.bunny.jumpindex.value='<?= $attribIndex; ?>';document.bunny.submit();">&nbsp;<?= $units ? $units : ($isRDI == "Y" ? "%RDI" : ""); ?>
									<input type="hidden" name="attribId[]" value="<?= $attributeId; ?>">
								</div>
								<div class="spacer"></div>
							</div>
							<div class="spacer"></div>
				<?		$bgColor = !$bgColor;
							$attribIndex++;
						}
					}
				}
			}	?>
			<script language="javascript">
				location.href = '#<?= $jumpto; ?>';
				document.bunny.attrib_<?= $jumpindex + 1; ?>.focus();
			</script>
		</form>
	</body>
</html>
