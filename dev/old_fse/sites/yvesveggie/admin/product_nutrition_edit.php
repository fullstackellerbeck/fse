<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue || $new ) {
			if( $new ) {
				unset( $attribute_id );
			}
			
			$pageQuery = $db->createInsert( array( "name"           => "'$name'",
																						 "country_id"     => "'$country_id'",
	                                           "language_id"    => "'$language_id'",
	                                           "units"          => "'$units'",
	                                           "priority"       => "'$priority'",
	                                           "is_rdi"         => "'$is_rdi'",
	                                           "live"           => "'$live'",
	                                           "p_attribute_id" => "'$p_attribute_id'" ),
																						 array( "attribute_id", $attribute_id ),
																						 "nutritional_attribs" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: product_nutrition_display.php" );
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
<?	if( $attribute_id ) {
			$displayResult = $db->query( "select name, units, priority, is_rdi, live, p_attribute_id, country_id, language_id from nutritional_attribs where attribute_id = '$attribute_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $name, $units, $priority, $isRDI, $live, $pAttributeId, $dbCountryId, $dbLanguageId ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="product_nutrition_edit.php" method="post">
			<input type="hidden" name="attribute_id" value="<?= $attribute_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $nav_id ? "Edit" : "Add"; ?> a nutritional attribute</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Country</div>
							<div class="left" style="width: 60%;">
								<select name="country_id" class="adminselect">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {	?>
										 <option value="<?= $countryId; ?>"<?= ($countryId == $dbCountryId ? " selected" : ""); ?>><?= $countryName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">Language</div>
							<div class="left" style="width: 60%;">
								<select name="language_id" class="adminselect">
							<?	$languageResult = $db->query( "select language_id, name from language" );
									if( $db->numRows( $languageResult ) ) {
										while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {	?>
										 <option value="<?= $languageId; ?>"<?= ($languageId == $dbLanguageId ? " selected" : ""); ?>><?= $languageName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer" style="padding-bottom: 5px;"></div>							

							<div class="left" style="width: 22%;">Name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Units</div>
							<div class="left" style="width: 60%;"><input type="text" name="units" class="admintext" value="<?= $units; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Priority</div>
							<div class="left" style="width: 60%;"><input type="text" name="priority" class="admintext" value="<?= $priority; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Is RDI?</div>
							<div class="left" style="width: 60%;">
								<select name="is_rdi" class="adminselect">
									<option value="Y"<?= ($isRDI == 'Y' ? ' selected' : ''); ?>>Yes</option>
									<option value="N"<?= ($isRDI == 'N' ? ' selected' : ''); ?>>No</option>
								</select>
							</div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Live?</div>
							<div class="left" style="width: 60%;">
								<select name="live" class="adminselect">
									<option value="Y"<?= ($live == 'Y' ? ' selected' : ''); ?>>Yes</option>
									<option value="N"<?= ($live == 'N' ? ' selected' : ''); ?>>No</option>
								</select>
							</div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Parent attribute</div>
							<div class="left" style="width: 60%;">
								<select name="p_attribute_id" class="adminselect">
									<option value="0"<?= ($pAttributeId == 0 ? ' selected' : ''); ?>>(is a parent attribute)</option>
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $dbCountryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
											
											$languageResult = $db->query( "select language_id, name from language" );
											if(	 $db->numRows( $languageResult ) ) {
												while( list( $dbLanguageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
													
													$languageCountryCountResult = $db->query( "select count( attribute_id ) ".
													                                          "  from nutritional_attribs ".
													                                          " where country_id = '$dbCountryId' ".
													                                          "   and language_id = '$dbLanguageId'" );
													
													list( $attribCount ) = $db->fetchRow( $languageCountryCountResult );
													
													if( $attribCount > 0 ) {	?>
														<optgroup label="<?= "$countryName - $languageName"; ?>">
													<?	$pAttResult = $db->query( "select attribute_id, name, is_rdi from nutritional_attribs where country_id = '$dbCountryId' and language_id = '$dbLanguageId' order by is_rdi desc" );
															if( $pAttResult && $db->numRows( $pAttResult ) ) {
																while( list( $dbPAttributeId, $dbPName, $dbIsRDI ) = $db->fetchRow( $pAttResult ) ) {	?> 
																	<option value="<?= $dbPAttributeId; ?>"<?= ($dbPAttributeId == $pAttributeId ? ' selected' : ''); ?>><?= $dbPName; ?><?= ($dbIsRDI == 'Y' ? " (RDI)" : ""); ?></option>
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
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="submit" name="new" value="Insert as new" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('product_nutrition_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
