<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "name"        => "'$name'",
																						 "country_id"  => "'$country_id'",
																						 "language_id" => "'$language_id'",
																						 "cuisine_id"  => "'$cuisine_id'",
																						 "meal_id"     => "'$meal_id'",
																						 "directions"  => "'" . addslashes( $content ) . "'",
																						 "servings"    => "'$servings'" ),
																						 array( "recipe_id", $recipe_id ),
																						 "recipes" );
	
			$pageResult = $db->query( $pageQuery );
			unset( $_SESSION[ "new_recipe_id" ] );
			session_unregister( $new_recipe_id );
			
			header( "Location: recipes_display.php" );
		}	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>

		<script language="javascript" src="js/functions.js"></script>
		<link rel="stylesheet" type="text/css" href="css/common.css">
	</head>
	
	<body>
<?	if( $recipe_id ) {
			$displayResult = $db->query( "select name, country_id, language_id, cuisine_id, meal_id, directions, servings from recipes where recipe_id='$recipe_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $name, $dbBigCountryId, $dbBigLanguageId, $dbCuisineId, $dbMealId, $directions, $servings ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="recipes_edit.php" method="post">
			<input type="hidden" name="recipe_id" value="<?= $recipe_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $recipe_id ? "Edit" : "Add"; ?> a recipe</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Servings</div>
							<div class="left" style="width: 60%;"><input type="text" name="servings" class="admintext" value="<?= $servings; ?>"></div>
							<div class="spacer" style="padding-bottom: 5px;"></div>
							
							<div class="left" style="width: 22%;">Country</div>
							<div class="left" style="width: 60%;">
								<select name="country_id" class="adminselect" onchange="document.ingredients.location.href='recipes_ingredients_iframe.php?country_id=' + document.bunny.country_id.options[ document.bunny.country_id.selectedIndex ].value + '&language_id=' + document.bunny.language_id.options[ document.bunny.language_id.selectedIndex ].value + (document.bunny.recipe_id.value ? '&recipe_id=' + document.bunny.recipe_id.value : '');">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {	?>
										 <option value="<?= $countryId; ?>"<?= ($countryId == $dbBigCountryId ? " selected" : ""); ?>><?= $countryName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">Language</div>
							<div class="left" style="width: 60%;">
								<select name="language_id" class="adminselect" onchange="document.ingredients.location.href='recipes_ingredients_iframe.php?country_id=' + document.bunny.country_id.options[ document.bunny.country_id.selectedIndex ].value + '&language_id=' + document.bunny.language_id.options[ document.bunny.language_id.selectedIndex ].value + (document.bunny.recipe_id.value ? '&recipe_id=' + document.bunny.recipe_id.value : '');">
							<?	$languageResult = $db->query( "select language_id, name from language" );
									if( $db->numRows( $languageResult ) ) {
										while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {	?>
										 <option value="<?= $languageId; ?>"<?= ($languageId == $dbBigLanguageId ? " selected" : ""); ?>><?= $languageName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer"></div>
														
							<div class="left" style="width: 22%;">Meal type</div>
							<div class="left" style="width: 60%;">
								<select name="meal_id" class="adminselect">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $dbCountryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
											
											$languageResult = $db->query( "select language_id, name from language" );
											if(	 $db->numRows( $languageResult ) ) {
												while( list( $dbLanguageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
													
													$languageCountryCountResult = $db->query( "select count( meal_id ) ".
													                                          "  from recipes_meals ".
													                                          " where country_id = '$dbCountryId' ".
													                                          "   and language_id = '$dbLanguageId'" );
													
													list( $mealCount ) = $db->fetchRow( $languageCountryCountResult );
													
													if( $mealCount > 0 ) {	?>
														<optgroup label="<?= "$countryName - $languageName"; ?>">
													<?	$familyResult = $db->query( "select meal_id, name ".
													                                "  from recipes_meals ".
													                                " where country_id = '$dbCountryId' ".
													                                "   and language_id = '$dbLanguageId'" );
															if( $db->numRows( $familyResult ) ) {
																while( list( $mealId, $mealName ) = $db->fetchRow( $familyResult ) ) {	?>
																	<option value="<?= $mealId; ?>"<?= ($mealId == $dbMealId ? " selected" : ""); ?>><?= $mealName; ?></option>
														<?		if( !$mealId && !$selectedMealId ) {
																		$selectedMealId = $dbMealId;
																	} elseif( $mealId ) {
																		$selectedMealId = $mealId;
																	}
																}
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

							<div class="left" style="width: 22%;">Cuisine type</div>
							<div class="left" style="width: 60%;">
								<select name="cuisine_id" class="adminselect">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $dbCountryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
											
											$languageResult = $db->query( "select language_id, name from language" );
											if(	 $db->numRows( $languageResult ) ) {
												while( list( $dbLanguageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
													
													$languageCountryCountResult = $db->query( "select count( cuisine_id ) ".
													                                          "  from recipes_cuisine ".
													                                          " where country_id = '$dbCountryId' ".
													                                          "   and language_id = '$dbLanguageId'" );
													
													list( $mealCount ) = $db->fetchRow( $languageCountryCountResult );
													
													if( $mealCount > 0 ) {	?>
														<optgroup label="<?= "$countryName - $languageName"; ?>">
													<?	$cuisineResult = $db->query( "select cuisine_id, name ".
													                                "  from recipes_cuisine ".
													                                " where country_id = '$dbCountryId' ".
													                                "   and language_id = '$dbLanguageId'" );
															if( $db->numRows( $cuisineResult ) ) {
																while( list( $cuisineId, $cuisineName ) = $db->fetchRow( $cuisineResult ) ) {	?>
																	<option value="<?= $cuisineId; ?>"<?= ($cuisineId == $dbCuisineId ? " selected" : ""); ?>><?= $cuisineName; ?></option>
														<?		if( !$cuisineId && !$selectedCuisineId ) {
																		$selectedCuisineId = $dbCuisineId;
																	} elseif( $cuisineId ) {
																		$selectedCuisineId = $cuisineId;
																	}
																}
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
						</div>

						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('recipes_display.php');">
						</div>
						<div class="spacer"></div>
					</div>

					<div class="innercontent">
							<div class="left" style="width: 17%; padding-right: 3px;">Directions</div>
							<div class="left" style="width: 70%;"><textarea name="content" class="admintextarea" style="height: 120px; width: 465px;"><?= $directions; ?></textarea></div>
							<div class="spacer" style="padding-bottom: 5px;"></div>
					</div>
					
					<div class="innercontent">
							<div class="left" style="width: 17%; padding-right: 3px;">
								<p class="itemspace">Ingredients</p>
							</div>
							<div class="left" style="width: 70%;">			
								<iframe src="recipes_ingredients_iframe.php<?= $recipe_id ? "?recipe_id=$recipe_id" : ""; ?><?= $dbBigCountryId ? "&country_id=$dbBigCountryId" : ""; ?><?= $dbBigLanguageId ? "&language_id=$dbBigLanguageId" : ""; ?>" name="ingredients" width="465" height="105" marginwidth="4" marginheight="0" frameborder="0" style="border: 1px solid #bbb;">The Yves Veggie Admin tools use technology your browser does not support. Click <a href="http://www.webstandards.org/upgrade/" target="upgrade">here</a> for details.</iframe>
							</div>
							<div class="spacer"></div>
					</div>					

					<div class="innercontent">
							<div class="left" style="width: 17%; padding-right: 3px;">
								<p class="itemspace">Nutritional</p>
							</div>
							<div class="left" style="width: 70%;">			
								<iframe src="recipes_nutritional_iframe.php<?= $recipe_id ? "?recipe_id=$recipe_id" : ""; ?>" name="nutritional" width="465" height="105" marginwidth="4" marginheight="0" frameborder="0" style="border: 1px solid #bbb;">The Yves Veggie Admin tools use technology your browser does not support. Click <a href="http://www.webstandards.org/upgrade/" target="upgrade">here</a> for details.</iframe>
							</div>
							<div class="spacer"></div>
					</div>					

					<div class="innercontent">
							<div class="left" style="width: 17%; padding-right: 3px;">
								<p class="itemspace">Calories</p>
							</div>
							<div class="left" style="width: 70%;">			
								<iframe src="recipes_nutritional_calories_iframe.php<?= $recipe_id ? "?recipe_id=$recipe_id" : ""; ?>" name="cal" width="465" height="105" marginwidth="4" marginheight="0" frameborder="0" style="border: 1px solid #bbb;">The Yves Veggie Admin tools use technology your browser does not support. Click <a href="http://www.webstandards.org/upgrade/" target="upgrade">here</a> for details.</iframe>
							</div>
							<div class="spacer"></div>
					</div>					
				</div>
			</div>
		</form>
	</body>
</html>
