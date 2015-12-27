<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}

		if( $fold ) {
			$getCurrentResult = $db->query( "select folded from stores_provinces where province_id='$fold'" );
			if( $db->numRows( $getCurrentResult ) ) {
				list( $folded ) = $db->fetchRow( $getCurrentResult );
				$newFolded = ( $folded == "Y" ? "N" : "Y" );
			
				$setFoldedResult = $db->query( "update stores_provinces set folded='$newFolded' where province_id='$fold'" );
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
				<div class="contentbox">
					<span class="title">Display all recipes</span>	
					<div class="innercontent">
						
				<?	$countryResult = $db->query( "select country_id, name, live from countries" );
						if( $db->numRows( $countryResult ) ) {
							while( list( $countryId, $countryName, $countryLive ) = $db->fetchRow( $countryResult ) ) {
								
								$languageResult = $db->query( "select language_id, name from language" );
								while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
								
									$clCountResult = $db->query( "select count( recipe_id ) from recipes where country_id='$countryId' and language_id='$languageId'" );
									list( $countryLangCount ) = $db->fetchRow( $clCountResult );
									
									if( $countryLangCount > 0 ) {		
										?>
										<?= $notFirst != false ? "<br>" : ""; ?><?= "<b>$countryName</b> &#8212; $languageName"; ?>
										
								<?	$recipeResult = $db->query( "select recipe_id, name, servings, cuisine_id, meal_id ".
										                              "  from recipes ".
										                              " where country_id  = '$countryId' ".
										                              "   and language_id = '$languageId'".
										                              " order by name" ); 
										
										$notFirst = false;
										$bgColor = false;
										if( $db->numRows( $recipeResult ) ) {	?>
											<div class="innercontent" style="width: 556px; background-color: #ffffff;">
												<div class="left" style="width: 40%;"><b>Recipe name</b></div>
												<div class="left" style="padding-left: 5px; width: 40%;"><b>Meal / Cuisine type</b></div>
												<div class="spacer"></div>
												<div class="divider"></div>
									
									<?		while( list( $recipeId, $recipeName, $recipeServings, $cuisineId, $mealId ) = $db->fetchRow( $recipeResult ) ) {
													$mealResult = $db->query( "select name from recipes_meals where meal_id = '$mealId'" );
													if( $db->numRows( $mealResult ) ) {
														list( $mealName ) = $db->fetchRow( $mealResult );
													}
													
													$cuisineResult = $db->query( "select name from recipes_cuisine where cuisine_id = '$cuisineId'" );
													if( $db->numRows( $cuisineResult ) ) {
														list( $cuisineName ) = $db->fetchRow( $cuisineResult );
													}	?>
													<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#dddddd';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
														<div class="left" style="width: 40%;"><?= $recipeName; ?></div>
														<div class="left" style="width: 40%; padding-left: 5px;"><?= "$mealName &#8212; $cuisineName"; ?></div>
														<div class="right" style="width: 15%; text-align: right;"><a href="recipes_edit.php?recipe_id=<?= $recipeId; ?>">edit</a> &middot; <a href="javascript:void(delCascadeItem('recipes_display.php','<?= $recipeId; ?>','recipes','recipe_id', new Array('recipes_ingredients','recipes_nutritional','recipes_nutritional_calories')));">delete</a></div>
														<div class="spacer"></div>
													</div>
									<?			$bgColor = !$bgColor;
												}	?>
												<div class="spacer"></div>
											</div>
								<?	}
										
										$notFirst = true;
									}
								}
							}
					}	?>	
				</div>
			</div>
		</form>
	</body>
</html>
