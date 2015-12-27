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
					<span class="title">Display all cuisines / meals</span>	
					<div class="innercontent">
				<?	$first = true;
						$bgColor = false;
						
						$countryResult = $db->query( "select country_id, name from countries" );
						
						if( $db->numRows( $countryResult ) ) {
							while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
								$languageResult = $db->query( "select language_id, name from language" );
								
								if( $db->numRows( $languageResult ) ) {
									while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
										$mealLanguageCountResult = $db->query( "select count( language_id ) from recipes_meals where country_id = '$countryId' and language_id = '$languageId'" );
										list( $mealLanguageCount ) = $db->fetchRow( $mealLanguageCountResult );
										
										$cuisineLanguageCountResult = $db->query( "select count( language_id ) from recipes_cuisine where country_id = '$countryId' and language_id = '$languageId'" );
										list( $cuisineLanguageCount ) = $db->fetchRow( $cuisineLanguageCountResult );

										if( $mealLanguageCount > 0 || $cuisineLanguageCount > 0 ) {
											echo( (!$first ? "<br>" : "") . "<b>$countryName</b> &#8212; $languageName<br>\n" );

											
											if( $mealLanguageCount > 0 ) {	?>
												<div class="innercontent" style="width: 555px;">
													<div class="left" style="width: 65%;"><b>Meal name</b></div>
													<div class="spacer"></div>
													<div class="divider"></div>								
											<?	$displayResult = $db->query( "select meal_id, name ".
											                                 "  from recipes_meals ".
											                                 " where language_id = '$languageId' ".
											                                 "   and country_id  = '$countryId'" );
													if( $db->numRows( $displayResult ) ) {
														while( list( $mealId, $mealName ) = $db->fetchRow( $displayResult ) ) {	?>
															<div style="padding-top: 3px; padding-bottom: 3px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
																<div class="left" style="width: 75%;"><?= $mealName; ?></div>
																<div class="right" style="width: 15%; text-align: right;"><a href="cuisine_meal_edit.php?meal_id=<?= $mealId; ?>">edit</a> &middot; <a href="javascript:void(delItem('cuisine_meal_display.php','<?= $mealId; ?>','recipes_meals','meal_id'));">delete</a></div>
																<div class="spacer"></div>
															</div>
													<?	$bgColor = !$bgColor;
														}
													}	?>
												</div>												
									<?	}
									
											if( $cuisineLanguageCount > 0 ) {	?>

												<div class="innercontent" style="width: 555px;">
													<div class="left" style="width: 65%;"><b>Cuisine name</b></div>
													<div class="spacer"></div>
													<div class="divider"></div>								
												
											<?	
														$displayResult = $db->query( "select cuisine_id, name ".
												                                 "  from recipes_cuisine ".
												                                 " where language_id = '$languageId' ".
												                                 "   and country_id  = '$countryId'" );
														if( $db->numRows( $displayResult ) ) {
															while( list( $cuisineId, $cuisineName ) = $db->fetchRow( $displayResult ) ) {	?>
																<div style="padding-top: 3px; padding-bottom: 3px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
																	<div class="left" style="width: 75%;"><?= $cuisineName; ?></div>
																	<div class="right" style="width: 15%; text-align: right;"><a href="cuisine_meal_edit.php?cuisine_id=<?= $cuisineId; ?>">edit</a> &middot; <a href="javascript:void(delItem('cuisine_meal_display.php','<?= $cuisineId; ?>','recipes_cuisine','cuisine_id'));">delete</a></div>
																	<div class="spacer"></div>
																</div>
														<?	$bgColor = !$bgColor;
															}
														}	?>
												</div>

								<?		}
											$first = false;
										}
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
