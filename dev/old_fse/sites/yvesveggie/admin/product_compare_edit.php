<?	include( "inc/init.php" );
		
	/*	if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		} */
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "product_id" => "'$product_id'",
	                                           "other_name" => "'$other_name'",
	                                           "live"       => "'$live'" ),
																						 array( "compare_id", $compare_id ),
																						 "products_compare" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: product_compare_display.php" );
		}	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">
		<script language="javascript" src="js/functions.js"></script>
	</head>
	
	<body>
<?	if( $compare_id ) {
			$displayResult = $db->query( "select product_id, other_name, live from products_compare where compare_id='$compare_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $productId, $otherName, $live ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="product_compare_edit.php" method="post">
			<input type="hidden" name="compare_id" value="<?= $compare_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $compare_id ? "Edit" : "Add"; ?> a product comparison</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Yves product</div>
							<div class="left" style="width: 60%;">
								<select name="product_id" class="adminselect" onchange="document.work.location.href='nutritional_comparison_iframe.php?product_id=' + document.bunny.product_id.options[ document.bunny.product_id.selectedIndex ].value + (document.bunny.compare_id.value ? '&compare_id=' + document.bunny.compare_id.value : '');">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $dbCountryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
											
											$languageResult = $db->query( "select language_id, name from language" );
											if(	 $db->numRows( $languageResult ) ) {
												while( list( $dbLanguageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
													
													$languageCountryCountResult = $db->query( "select count( family_id ) ".
													                                          "  from products_family ".
													                                          " where country_id = '$dbCountryId' ".
													                                          "   and language_id = '$dbLanguageId'" );
													
													list( $familyCount ) = $db->fetchRow( $languageCountryCountResult );
													
													if( $familyCount > 0 ) {	?>
														<optgroup label="<?= "$countryName - $languageName"; ?>">
													<?	$famResult = $db->query( "select family_id, name ".
													                             "  from products_family ".
													                             " where country_id  = '$dbCountryId' ".
													                             "   and language_id = '$dbLanguageId'" );
													    
													    if( $db->numRows( $famResult ) ) {
													    	while( list( $dbFamilyId, $familyName ) = $db->fetchRow( $famResult ) ) {	?>
													    		<optgroup label="    <?= $familyName; ?>">

																<?	$productResult = $db->query( "select product_id, name ".
																                                "   from products ".
																                                "  where family_id = '$dbFamilyId'" );
																		if( $db->numRows( $productResult ) ) {
																			while( list( $dbProductId, $productName ) = $db->fetchRow( $productResult ) ) {	?>
																				<option value="<?= $dbProductId; ?>"<?= ($productId == $dbProductId ? " selected" : ""); ?>><?= $productName; ?></option>
																	<?		if( !$productId && !$selectedProductId ) {
																					$selectedProductId = $dbProductId;
																				} elseif( $productId ) {
																					$selectedProductId = $productId;
																				}
																			}
																		}	?>
																	</optgroup>
														<?	}
															}	?>
														</optgroup>
											<?	}
												}
											}
										}
									}	?>
								</select>
							</div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Other product</div>
							<div class="left" style="width: 60%;"><input type="text" name="other_name" class="admintext" value="<?= $otherName; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Live</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="live" id="yes" value="Y"<?= $live == "Y" || !$live ? " checked" : ""; ?>> <label for="yes">Yes</label> &nbsp&nbsp;
								<input type="radio" name="live" id="no" value="N"<?= $live == "N" ? " checked" : ""; ?>> <label for="no">No</label>
							</div>
							<div class="spacer"></div>

						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('product_compare_display.php');">
						</div>
						<div class="spacer"></div>
					</div>

					<div class="innercontent">					
						<div class="left" style="width: 17%; padding-right: 3px;">Nutritional comparison</div>
						<div class="left" style="width: 70%;"><iframe src="nutritional_comparison_iframe.php<?= ($productId ? "?product_id=$productId" : "") . ($compare_id ? "&compare_id=$compare_id" : ""); ?>" name="work" width="465" height="260" marginwidth="4" marginheight="0" frameborder="0">The Yves Veggie Admin tools use technology your browser does not support. Click <a href="http://www.webstandards.org/upgrade/" target="upgrade">here</a> for details.</iframe></div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
			<script language="Javascript">
				document.work.location.href='nutritional_comparison_iframe.php?product_id=' + document.bunny.product_id.options[ document.bunny.product_id.selectedIndex ].value + (document.bunny.compare_id.value ? '&compare_id=' + document.bunny.compare_id.value : '');
			</script>
		</form>
	</body>
</html>
