<?	include( "inc/init.php" );

		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $fold ) {
			$getCurrentResult = $db->query( "select folded from products_family where family_id='$fold'" );
			if( $db->numRows( $getCurrentResult ) ) {
				list( $folded ) = $db->fetchRow( $getCurrentResult );
				$newFolded = ( $folded == "Y" ? "N" : "Y" );
			
				$setFoldedResult = $db->query( "update products_family set folded='$newFolded' where family_id='$fold'" );
			}
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
		<form name="login" action="login.php" method="post">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox" style="height: 253px;">
					<span class="title">Display all products</span>	
					<div class="innercontent">
				<?	$countryResult = $db->query( "select country_id, name from countries" );
						if( $db->numRows( $countryResult ) ) {
							while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
								$languageResult = $db->query( "select language_id, name from language" );
								if( $db->numRows( $languageResult ) ) {
									while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
										
										$checkFamilyResult = $db->query( "select family_id from products_family where country_id='$countryId' and language_id='$languageId' order by priority" );
										if( $db->numRows( $checkFamilyResult ) ) {
											$foundItems = false;

											while( list( $checkFamilyId ) = $db->fetchRow( $checkFamilyResult ) ) {
												$countProductResult = $db->query( "select count( product_id ) from products where family_id='$checkFamilyId'" );
												list( $countProducts ) = $db->fetchRow( $countProductResult );
												
												if( $countProducts > 0 ) {
													$foundItems = true;
												}
											}
											
											if( $foundItems ) {
												echo( "<div style=\"background-color: #fcfcfc;\">" . ($notFirst ? "<br>" : "") . "<b>$countryName</b> &#8212; $languageName</div><div class=\"divider\" style=\"padding-top: 3px;\"></div>" );
											}
										}
											
										$familyResult = $db->query( "select family_id, name, folded ".
								                                "  from products_family ".
								                                " where country_id  = '$countryId' ".
								                                "   and language_id = '$languageId' ".
								                                " order by name" );
										if( $db->numRows( $familyResult ) ) {
											while( list( $familyId, $familyName, $familyFolded ) = $db->fetchRow( $familyResult ) ) {
												$familyCountResult = $db->query( "select count( product_id ) from products where family_id = '$familyId'" );
												list( $familyCount ) = $db->fetchRow( $familyCountResult );
												
												if( $familyCount > 0 ) {	?>
													<div class="parentrow" style="padding-top: 3px; padding-bottom: 3px;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='transparent';">
														<div class="left" style="width: 83%;"><a href="product_display.php?fold=<?= $familyId; ?>"><img src="images/<?= $familyFolded == "Y" ? "folded.gif" : "unfolded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"</a>&nbsp;<a href="product_display.php?fold=<?= $familyId; ?>"><?= $familyName; ?></a></div>
														<div class="right" style="width: 15%; padding-right: 9px; text-align: right;"><a href="product_family_edit.php?family_id=<?= $familyId; ?>">edit</a> &middot; <a href="javascript:void(delItem('product_display.php','<?= $familyId; ?>','products_family','family_id'));">delete</a></div>
														<div class="spacer"></div>
													</div>

											<?	if( $familyFolded == "N" ) {	?>
														<div class="innercontent" style="width: 555px; background-color: #ffffff;">
															<div class="left" style="width: 28%; padding-right: 3px;"><b>Product name</b></div>
															<div class="left" style="width: 53%; margin-left: 5px;"><b>Description</b></div>
															<div class="spacer"></div>
															<div class="divider"></div>
					
													<?	$bgColor = false;
															$productResult = $db->query( "select product_id, name, live, description ".
													                                 "  from products ".
													                                 " where family_id   = '$familyId'" .
													                                 " order by priority" );
													    if( $db->numRows( $productResult ) ) {
													    	while( list( $productId, $productName, $productLive, $productDescription ) = $db->fetchRow( $productResult ) ) {	?>
																	<div style="padding-top: 6px; padding-bottom: 6px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
																		<div class="left" style="width: 28%; padding-right: 8px;"><?= $productName; ?></div>
																		<div class="left" style="width: 53%;"><?= truncWords( strip_tags( $productDescription ), 15 ); ?></div>
																		<div class="right" style="width: 15%; text-align: right;"><a href="product_edit.php?product_id=<?= $productId; ?>">edit</a> &middot; <a href="javascript:void(delItem('product_display.php','<?= $productId; ?>','products','product_id'));">delete</a></div>
																		<div class="spacer"></div>	
																	</div>
														<?		$bgColor = !$bgColor;
																}
															}	?>
														</div>
										<?		}
												}
											}
										}	?>
										
							<?		$notFirst = true;
									}
								}
							}
						}	?>
						<div class="spacer"></div>
					</div>
					
				</div>
			</div>
		</form>
	</body>
</html>
