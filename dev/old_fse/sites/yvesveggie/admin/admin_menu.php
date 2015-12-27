			<?	if( session_is_registered( "userId" ) ) {
						if( $menu && $menuOpen != $menu ) {
							$menuOpen = $menu;
							session_register( "menuOpen" );
						}	elseif( $menuOpen == $menu ) {
							$menuOpen = "";
							session_register( "menuOpen" );
						}
					}	?>
					
					<span class="menutitle"><a href="<?= "$sName?menu=admin"; ?>"><img src="images/<?= $menuOpen == "admin" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=admin"; ?>">Admin users</a></span><br>
			<?	if( $menuOpen == "admin" && session_is_registered( "userId" ) && session_is_registered( "md5Token" ) ) {	?>
						<div class="menuitems">
							<a href="admin_display.php"<?= $sName == "admin_display.php" ? " class=\"on\"" : ""; ?>>Display all admin users</a><br>
							<a href="admin_edit.php"<?= $sName == "admin_edit.php" ? " class=\"on\"" : ""; ?>><?= $user_id ? "Edit" : "Add"; ?> an admin user</a>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>
			 
					<span class="menutitle"><a href="<?= "$sName?menu=langs"; ?>"><img src="images/<?= $menuOpen == "langs" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=langs"; ?>">Languages / Countries</a></span><br>
			<?	if( $menuOpen == "langs" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {	?>
						<div class="menuitems">
							<p class="itemspace">
								<a href="country_language_display.php"<?= $sName == "country_language_display.php" ? " class=\"on\"" : ""; ?>>Display countries &amp; languages</a><br>
							</p>
							<a href="country_edit.php"<?= $sName == "country_edit.php" ? " class=\"on\"" : ""; ?>><?= $country_id ? "Edit" : "Add"; ?> a country</a><br>
							<a href="language_edit.php"<?= $sName == "language_edit.php" ? " class=\"on\"" : ""; ?>><?= $language_id ? "Edit" : "Add"; ?> a language</a>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>
			 
					<span class="menutitle"><a href="<?= "$sName?menu=pages"; ?>"><img src="images/<?= $menuOpen == "pages" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=pages"; ?>">Pages / Navigation</a></span><br>
			<?	if( $menuOpen == "pages" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {	?>
						<div class="menuitems">
							<p class="itemspace"><a href="pages_display.php"<?= $sName == "pages_display.php" ? " class=\"on\"" : ""; ?>>Display all site pages</a><br>
							<a href="pages_edit.php"<?= $sName == "pages_edit.php" ? " class=\"on\"" : ""; ?>><?= $page_id ? "Edit" : "Add"; ?> a site page</a></p>
							
							<p class="itemspace"><a href="pages_nav_display.php"<?= $sName == "pages_nav_display.php" ? " class=\"on\"" : ""; ?>>Display navigation set-up</a><br>
							<a href="pages_nav_edit.php"<?= $sName == "pages_nav_edit.php" ? " class=\"on\"" : ""; ?>><?= $nav_id ? "Edit" : "Add"; ?> a nav item</a></p>
							
							<p class="itemspace"><a href="pages_content_display.php"<?= $sName == "pages_content_display.php" ? " class=\"on\"" : ""; ?>>Display all pages and content</a><br>
							<a href="pages_content_edit.php"<?= $sName == "pages_content_edit.php" ? " class=\"on\"" : ""; ?>><?= $content_id ? "Edit" : "Add"; ?> content to a page</a></p>

							<p class="itemspace"><a href="pages_misc_display.php"<?= $sName == "pages_misc_display.php" ? " class=\"on\"" : ""; ?>>Display miscellaneous copy</a><br>
							<a href="pages_misc_edit.php"<?= $sName == "pages_misc_edit.php" ? " class=\"on\"" : ""; ?>><?= $copy_id ? "Edit" : "Add"; ?> miscellaneous copy</a></p>

							<p class="itemspace"><a href="beauty_shot_display.php"<?= $sName == "beauty_shot_display.php" ? " class=\"on\"" : ""; ?>>Display beauty shots</a><br>
							<a href="beauty_shot_edit.php"<?= $sName == "beauty_shot_edit.php" ? " class=\"on\"" : ""; ?>><?= $shot_id ? "Edit" : "Add"; ?> a beauty shot</a></p>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>

					<span class="menutitle"><a href="<?= "$sName?menu=prods"; ?>"><img src="images/<?= $menuOpen == "prods" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=prods"; ?>">Products / Reviews</a></span><br>
			<?	if( $menuOpen == "prods" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {	?>
						<div class="menuitems">
							<p class="itemspace"><a href="product_display.php"<?= $sName == "product_display.php" ? " class=\"on\"" : ""; ?>>Display all products</a><br>
							<a href="product_edit.php"<?= $sName == "product_edit.php" ? " class=\"on\"" : ""; ?>><?= $product_id ? "Edit" : "Add"; ?> a product</a></p>
							
							<p class="itemspace"><a href="product_family_display.php"<?= $sName == "product_family_display.php" ? " class=\"on\"" : ""; ?>>Display all product families</a><br>
							<a href="product_family_edit.php"<?= $sName == "product_family_edit.php" ? " class=\"on\"" : ""; ?>><?= $family_id ? "Edit" : "Add"; ?> a product family</a></p>
														
							<p class="itemspace"><a href="product_nutrition_display.php"<?= $sName == "product_nutrition_display.php" ? " class=\"on\"" : ""; ?>>Display all nutritional attribs</a><br>
							<a href="product_nutrition_edit.php"<?= $sName == "product_nutrition_edit.php" ? " class=\"on\"" : ""; ?>><?= $attribute_id ? "Edit" : "Add"; ?> nutritional attrib</a></p>

							<p class="itemspace"><a href="product_compare_nutrition_display.php"<?= $sName == "product_compare_nutrition_display.php" ? " class=\"on\"" : ""; ?>>Display all comparative attribs</a><br>
							<a href="product_compare_nutrition_edit.php"<?= $sName == "product_compare_nutrition_edit.php" ? " class=\"on\"" : ""; ?>><?= $attribute_id ? "Edit" : "Add"; ?> comparative attrib</a></p>

							<p class="itemspace"><a href="product_review_display.php"<?= $sName == "product_review_display.php" ? " class=\"on\"" : ""; ?>>Display all product reviews</a><br>
							<a href="product_review_edit.php"<?= $sName == "product_review_edit.php" ? " class=\"on\"" : ""; ?>><?= $review_id ? "Edit" : "Add"; ?> a product review</a></p>

							<p class="itemspace"><a href="product_compare_display.php"<?= $sName == "product_compare_display.php" ? " class=\"on\"" : ""; ?>>Display all comparisons</a><br>
							<a href="product_compare_edit.php"<?= $sName == "product_compare_edit.php" ? " class=\"on\"" : ""; ?>><?= $compare_id ? "Edit" : "Add"; ?> a product comparison</a></p>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>
					
					<span class="menutitle"><a href="<?= "$sName?menu=recipes"; ?>"><img src="images/<?= $menuOpen == "recipes" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=recipes"; ?>">Recipes</a></span><br>
			<?	if( $menuOpen == "recipes" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {
						if( $queryS[ "tableName" ] == "recipes_cuisine" || $cuisine_id ) {
							$thisE = "cuisine";
						} elseif( $queryS[ "tableName" ] == "recipes_meals" || $meal_id ) {
							$thisE = "meal";
						} 	?>
						<div class="menuitems">
							<p class="itemspace">
								<a href="recipes_display.php"<?= $sName == "recipe_display.php" ? " class=\"on\"" : ""; ?>>Display all recipes</a><br>
								<a href="cuisine_meal_display.php"<?= $sName == "cuisine_meal_display.php" ? " class=\"on\"" : ""; ?>>Display all cuisines / meals</a>
							</p>
							<a href="recipes_edit.php"<?= $sName == "recipes_edit.php" ? " class=\"on\"" : ""; ?>><?= $recipe_id ? "Edit" : "Add"; ?> a recipe</a><br>
							<a href="cuisine_meal_edit.php?tableName=recipes_cuisine"<?= $sName == "cuisine_meal_edit.php" && $thisE == "cuisine" ? " class=\"on\"" : ""; ?>><?= $cuisine_id ? "Edit" : "Add"; ?> a cuisine type</a><br>
							<a href="cuisine_meal_edit.php?tableName=recipes_meals"<?= $sName == "cuisine_meal_edit.php" && $thisE == "meal" ? " class=\"on\"" : ""; ?>><?= $meal_id ? "Edit" : "Add"; ?> a meal type</a><br>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>

					<span class="menutitle"><a href="<?= "$sName?menu=stores"; ?>"><img src="images/<?= $menuOpen == "stores" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=stores"; ?>">Stores</a></span><br>
			<?	if( $menuOpen == "stores" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {	?>
						<div class="menuitems">
							<p class="itemspace"><a href="stores_display.php"<?= $sName == "stores_display.php" ? " class=\"on\"" : ""; ?>>Display all stores</a></p>
							<a href="country_edit.php"<?= $sName == "country_edit.php" ? " class=\"on\"" : ""; ?>><?= $country_id ? "Edit" : "Add"; ?> a country</a><br>
							<a href="stores_province_edit.php"<?= $sName == "stores_province_edit.php" ? " class=\"on\"" : ""; ?>><?= $province_id ? "Edit" : "Add"; ?> a state / province</a><br>
							<a href="stores_edit.php"<?= $sName == "stores_edit.php" ? " class=\"on\"" : ""; ?>><?= $store_id ? "Edit" : "Add"; ?> a store</a><br>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>

					<span class="menutitle"><a href="<?= "$sName?menu=media"; ?>"><img src="images/<?= $menuOpen == "media" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=media"; ?>">Media Releases</a></span><br>
			<?	if( $menuOpen == "media" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {	?>
						<div class="menuitems">
							<a href="media_display.php"<?= $sName == "media_display.php" ? " class=\"on\"" : ""; ?>>Display all releases</a><br>
							<a href="media_edit.php"<?= $sName == "media_edit.php" ? " class=\"on\"" : ""; ?>><?= $release_id ? "Edit" : "Add"; ?> a release</a>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>

					<span class="menutitle"><a href="<?= "$sName?menu=faq"; ?>"><img src="images/<?= $menuOpen == "faq" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=faq"; ?>">FAQ</a></span><br>
			<?	if( $menuOpen == "faq" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {	?>
						<div class="menuitems">
							<a href="faq_display.php"<?= $sName == "faq_display.php" ? " class=\"on\"" : ""; ?>>Display all FAQs</a><br>
							<a href="faq_edit.php"<?= $sName == "faq_edit.php" ? " class=\"on\"" : ""; ?>><?= $faq_id ? "Edit" : "Add"; ?> a FAQ</a>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>

					<span class="menutitle"><a href="<?= "$sName?menu=contact"; ?>"><img src="images/<?= $menuOpen == "contact" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=contact"; ?>">Contact us</a></span><br>
			<?	if( $menuOpen == "contact" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {	?>
						<div class="menuitems">
							<p class="itemspace">
								<a href="contact_display.php"<?= $sName == "contact_display.php" ? " class=\"on\"" : ""; ?>>Display all inquiries</a><br>
								<a href="contact_edit.php"<?= $sName == "contact_edit.php" ? " class=\"on\"" : ""; ?>><?= $faq_id ? "Edit" : "Add"; ?> an inquiry</a>
							</p>
							
							<a href="contact_subject_display.php"<?= $sName == "contact_subject_display.php" ? " class=\"on\"" : ""; ?>>Display all subjects</a><br>
							<a href="contact_subject_edit.php"<?= $sName == "contact_subject_edit.php" ? " class=\"on\"" : ""; ?>><?= $subjectModify_id ? "Edit" : "Add"; ?> a subject</a>
						</div><br>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>

					<span class="menutitle"><a href="<?= "$sName?menu=questionnaire"; ?>"><img src="images/<?= $menuOpen == "questionnaire" ? "unfolded.gif" : "folded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a> <a href="<?= "$sName?menu=questionnaire"; ?>">Questionnaire</a></span><br>
			<?	if( $menuOpen == "questionnaire" && session_is_registered( "userId" ) && session_is_registered( "md5Token" )  ) {	?>
						<div class="menuitems">
							<p class="itemspace">
								<a href="export_questionnaire.php"<?= $sName == "export_questionnaire.php" ? " class=\"on\"" : ""; ?>>Export all questionnaire responses</a><br>
								<a href="#" onclick="delAllItem('blank.php','questionnaire');"<?= $sName == "#" ? " class=\"on\"" : ""; ?>>Delete questionnaire responses</a>
							</p>							
						</div>
			<?	}	else { ?>
						<div class="spacer" style="padding-bottom: 5px;"></div>
			<?	}	?>
					