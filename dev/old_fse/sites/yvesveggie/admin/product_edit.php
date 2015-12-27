<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pathResult = $db->query( "select countries.image_path, countries.thumb_path ".
			                          "  from countries, products_family ".
			                          " where products_family.family_id  = '$family_id' ".
			                          "   and products_family.country_id = countries.country_id" );
			
			if( $db->numRows( $pathResult ) ) {
				list( $imagePath, $thumbPath ) = $db->fetchRow( $pathResult );
			}
	
			if( $_FILES[ 'userfile' ][ 'name' ][ 0 ] ) {
				move_uploaded_file( $_FILES[ 'userfile' ][ 'tmp_name' ][ 0 ], realpath( "../" . $imagePath . $_FILES[ 'userfile' ][ 'name' ][ 0 ] ) );
			}
			
			if( $_FILES[ 'userfile' ][ 'name' ][ 1 ] ) {
				move_uploaded_file( $_FILES[ 'userfile' ][ 'tmp_name' ][ 1 ], realpath( "../" . $thumbPath . $_FILES[ 'userfile' ][ 'name' ][ 1 ] ) );
			}

			$pageQuery = $db->createInsert( array( "name"         => "'$name'",
	                                           "live"         => "'$live'",
	                                           "image"        => "'" . ($_FILES[ 'userfile' ][ 'name' ][ 0 ] ? "$imagePath" . $_FILES[ 'userfile' ][ 'name' ][ 0 ] : $image) . "'",
	                                           "thumb_image"  => "'" . ($_FILES[ 'userfile' ][ 'name' ][ 1 ] ? "$thumbPath" . $_FILES[ 'userfile' ][ 'name' ][ 0 ] : $thumb_image) . "'",
	                                           "serving_size" => "'$serving_size'",
	                                           "per_pack"     => "'$per_pack'",
	                                           "description"  => "'$description'",
	                                           "ingredients"  => "'$ingredients'",
	                                           "family_id"    => "'$family_id'",
	                                           "shot_id"      => "'$shot_id'",
	                                           "priority"     => "'$priority'" ),
																						 array( "product_id", $product_id ),
																						 "products" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: product_display.php" );
		}	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">
		<script language="javascript" src="js/functions.js"></script>
	</head>
	
	<body onload="document.bunny.name.focus();">
<?	if( $product_id ) {
			$displayResult = $db->query( "select name, live, image, thumb_image, serving_size, per_pack, description, ingredients, family_id, shot_id, priority from products where product_id='$product_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $name, $live, $image, $thumbImage, $servingSize, $perPack, $description, $ingredients, $familyId, $dbShotId, $priority ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="product_edit.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="300000">
			<input type="hidden" name="product_id" value="<?= $product_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $language_id ? "Edit" : "Add"; ?> a language</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Product name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">Product family</div>
							<div class="left" style="width: 60%;">
								<select name="family_id" class="adminselect" onchange="document.work.location.href='nutritional_iframe.php?family_id=' + document.bunny.family_id.options[ document.bunny.family_id.selectedIndex ].value + (document.bunny.product_id.value ? '&product_id=' + document.bunny.product_id.value : '');">
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
													<?	$familyResult = $db->query( "select family_id, name ".
													                                "  from products_family ".
													                                " where country_id = '$dbCountryId' ".
													                                "   and language_id = '$dbLanguageId'" );
															if( $db->numRows( $familyResult ) ) {
																while( list( $dbFamilyId, $familyName ) = $db->fetchRow( $familyResult ) ) {	?>
																	<option value="<?= $dbFamilyId; ?>"<?= ($familyId == $dbFamilyId ? " selected" : ""); ?>><?= $familyName; ?></option>
														<?		if( !$familyId && !$selectedFamilyId ) {
																		$selectedFamilyId = $dbFamilyId;
																	} elseif( $familyId ) {
																		$selectedFamilyId = $familyId;
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
							<div class="spacer" style="padding-bottom: 8px;"></div>

							<div class="left" style="width: 22%;">Beauty shot</div>
							<div class="left" style="width: 60%;">
								<select name="shot_id" class="adminselect">
							<?	$shotResult = $db->query( "select shot_id, name from beauty_shots" );
									if( $db->numRows( $shotResult ) ) {
										while( list( $shotId, $shotName ) = $db->fetchRow( $shotResult ) ) {	?>
										 <option value="<?= $shotId; ?>"<?= ($shotId == $dbShotId ? " selected" : ""); ?>><?= $shotName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer" style="padding-bottom: 8px;"></div>							

							<div class="left" style="width: 22%;">Upload image</div>
							<div class="left" style="width: 60%;"><input type="file" name="userfile[]" class="adminfile"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Image</div>
							<div class="left" style="width: 60%;"><input type="text" name="image" class="admintext" value="<?= $image; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Upload thumb	</div>
							<div class="left" style="width: 60%;"><input type="file" name="userfile[]" class="adminfile"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Thumb Image</div>
							<div class="left" style="width: 60%;"><input type="text" name="thumb_image" class="admintext" value="<?= $thumbImage; ?>"></div>
							<div class="spacer" style="padding-bottom: 8px;"></div>

							<div class="left" style="width: 22%;">Serving size</div>
							<div class="left" style="width: 60%;"><input type="text" name="serving_size" class="admintext" value="<?= $servingSize ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Servings per pack</div>
							<div class="left" style="width: 60%;"><input type="text" name="per_pack" class="admintext" value="<?= $perPack; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Priority</div>
							<div class="left" style="width: 60%;"><input type="text" name="priority" class="admintext" value="<?= $priority; ?>"></div>
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
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('product_display.php');">
						</div>
						<div class="spacer"></div>
					</div>

					<div class="innercontent">
							<div class="left" style="width: 17%; padding-right: 3px;">Description</div>
							<div class="left" style="width: 70%;"><textarea name="description" class="admintextarea" style="height: 70px; width: 465px;"><?= $description; ?></textarea></div>
							<div class="spacer"></div>
					</div>

					<div class="innercontent">
							<div class="left" style="width: 17%; padding-right: 3px;">Ingredients</div>
							<div class="left" style="width: 70%;"><textarea name="ingredients" class="admintextarea" style="height: 110px; width: 465px;"><?= $ingredients; ?></textarea></div>
							<div class="spacer"></div>
					</div>

					<div class="innercontent">					
							<div class="left" style="width: 17%; padding-right: 3px;">Nutritional information</div>
							<div class="left" style="width: 70%;"><iframe src="nutritional_iframe.php?family_id=<?= $selectedFamilyId; ?><?= $product_id ? "&product_id=$product_id" : ""; ?>" name="work" width="465" height="145" marginwidth="4" marginheight="0" frameborder="0">The Yves Veggie Admin tools use technology your browser does not support. Click <a href="http://www.webstandards.org/upgrade/" target="upgrade">here</a> for details.</iframe></div>
							<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
