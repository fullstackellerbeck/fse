<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "product_id"    => "'$product_id'",
	                                           "first_name"    => "'$first_name'",
	                                           "last_name"     => "'$last_name'",
	                                           "email"         => "'$email'",
	                                           "review"        => "'$review'" ),
																						 array( "review_id", $review_id ),
																						 "products_review" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: product_review_display.php" );
		}	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">

		<script language="javascript" src="js/functions.js"></script>
	</head>

	<body onload="document.bunny.first_name.focus();">
<?	if( $review_id ) {
			$displayResult = $db->query( "select product_id, first_name, last_name, email, review from products_review where review_id='$review_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $productId, $firstName, $lastName, $email, $review ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="product_review_edit.php" method="post">
			<input type="hidden" name="review_id" value="<?= $review_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $review_id ? "Edit" : "Add"; ?> a product review</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">

							<div class="left" style="width: 22%;">First name</div>
							<div class="left" style="width: 60%;"><input type="text" name="first_name" class="admintext" value="<?= $firstName; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Last name</div>
							<div class="left" style="width: 60%;"><input type="text" name="last_name" class="admintext" value="<?= $lastName; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">E-mail</div>
							<div class="left" style="width: 60%;"><input type="text" name="email" class="admintext" value="<?= $email; ?>"></div>
							<div class="spacer" style="padding-bottom: 5px;"></div>

							<div class="left" style="width: 22%;">Product name</div>
							<div class="left" style="width: 60%;">
								<select name="product_id" class="adminselect">
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
							<div class="spacer" style="padding-bottom: 5px;"></div>

							<div class="left" style="width: 22%;">Review</div>
							<div class="left" style="width: 60%;"><textarea name="review" class="admintextarea"><?= $review; ?></textarea></div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('product_review_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
