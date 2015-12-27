<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
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
				<div class="contentbox">
					<div>
						<div class="left"><span class="title">Display all product reviews</span></div>
						<div class="right"><a href="export_products_review.php">export</a> &middot; <a href="#" onclick="delAllItem('product_review_display.php','products_review');">delete all</a></div>
					<div class="spacer"></div>
					</div>
					
					<div class="innercontent">
			<?	$first = true;
					
					$countryResult = $db->query( "select country_id, name from countries" );
					
					if( $db->numRows( $countryResult ) ) {
						while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
							$languageResult = $db->query( "select language_id, name from language" );
							
							if( $db->numRows( $languageResult ) ) {
								while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
									$languageCountResult = $db->query( "select count( products.product_id ) ".
																										 "  from products_review, products, products_family ".
																										 " where products_review.product_id  = products.product_id ".
																										 "   and products.family_id          = products_family.family_id ".
									                                   "   and products_family.country_id  = '$countryId' ".
									                                   "   and products_family.language_id = '$languageId'" );
									list( $languageCount ) = $db->fetchRow( $languageCountResult );
									
									if( $languageCount > 0 ) {
										echo( (!$first ? "<br>" : "") . "<b>$countryName</b> &#8212; $languageName<br>\n" );

										$reviewResult = $db->query( "select products_review.review_id, products_review.first_name, products_review.last_name, products_review.email ".
																								 "  from products_review, products, products_family ".
																								 " where products_review.product_id  = products.product_id ".
																								 "   and products.family_id          = products_family.family_id ".
										                             "   and products_family.country_id  = '$countryId' ".
										                             "   and products_family.language_id = '$languageId'" );
										if( $db->numRows( $reviewResult ) ) {	?>
				
											<b><?= $productName; ?></b>
											<div class="innercontent" style="width: 555px;">
												<div class="left" style="width: 40%;"><b>Reviewer's name</b></div>
												<div class="left" style="width: 30%;"><b>E-mail</b></div>
												<div class="spacer"></div>
												<div class="divider"></div>
												
											<?	$bgColor = false;
													while( list( $reviewId, $firstName, $lastName, $email ) = $db->fetchRow( $reviewResult ) ) {	?>					
														<div style="padding-top: 3px; padding-bottom: 3px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
															<div class="left" style="width: 40%;"><?= "$firstName $lastName"; ?></div>
															<div class="left" style="width: 30%;"><?= $email; ?></div>
															<div class="right" style="width: 15%; text-align: right;"><a href="product_review_edit.php?review_id=<?= $reviewId; ?>">edit</a> &middot; <a href="javascript:void(delItem('product_review_display.php','<?= $reviewId; ?>','products_review','review_id'));">delete</a></div>
															<div class="spacer"></div>
														</div>
											<?		$bgColor = !$bgColor;
													}
												}	?>
											</div>
						<?				$first = false;
										}
									}
								}
							}
						}
						
						if( $first ) {	?>
							<p style="margin: 0px; padding: 5px 0px 5px 0px; text-align: center;"><i>There are no product reviews available.</i></p>
				<?	}	?>
						<div class="spacer"></div>
					</div>
					
				</div>
			</div>
		</form>
	</body>
</html>
