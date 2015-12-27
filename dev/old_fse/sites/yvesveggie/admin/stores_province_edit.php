<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "name"            => "'$name'",
																						 "country_id"      => "'$country_id'",
																						 "language_id"     => "'$language_id'",
																						 "rel_province_id" => "'$rel_province_id'",
	                                           "live"            => "'$live'" ),
																						 array( "province_id", $province_id ),
																						 "stores_provinces" );
	
			$pageResult = $db->query( $pageQuery );
			header( "Location: stores_display.php" );
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
<?	if( $province_id ) {
			$displayResult = $db->query( "select country_id, language_id, name, live, rel_province_id from stores_provinces where province_id='$province_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $countryId, $languageId, $name, $live, $relProvinceId ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="login" action="stores_province_edit.php" method="post">
			<input type="hidden" name="province_id" value="<?= $province_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $province_id ? "Edit" : "Add"; ?> a Province / State</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Country</div>
							<div class="left" style="width: 60%;">
								<select name="country_id" class="adminselect">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $dbCountryId, $countryName ) = $db->fetchRow( $countryResult ) ) {	?>
										 <option value="<?= $dbCountryId; ?>"<?= ($countryId == $dbcountryId ? " selected" : ""); ?>><?= $countryName; ?></option>
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
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Related Province</div>
							<div class="left" style="width: 60%;">
								<select name="rel_province_id" class="adminselect">
									<option value="0"<?= ($pAttributeId == 0 ? ' selected' : ''); ?>>(is not related to any province)</option>
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $dbCountryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
											
											$languageResult = $db->query( "select language_id, name from language" );
											if(	 $db->numRows( $languageResult ) ) {
												while( list( $dbLanguageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
													
													$languageCountryCountResult = $db->query( "select count( province_id ) ".
													                                          "  from stores_provinces ".
													                                          " where country_id  = '$dbCountryId' ".
													                                          "   and language_id = '$dbLanguageId'" );
													
													list( $provinceCount ) = $db->fetchRow( $languageCountryCountResult );
													
													if( $provinceCount > 0 ) {	?>
														<optgroup label="<?= "$countryName - $languageName"; ?>">
													<?	$pAttResult = $db->query( "select province_id, name from stores_provinces where country_id = '$dbCountryId' and language_id = '$dbLanguageId'" );
															if( $pAttResult && $db->numRows( $pAttResult ) ) {
																while( list( $dbProvinceId, $dbPName ) = $db->fetchRow( $pAttResult ) ) {	?> 
																	<option value="<?= $dbProvinceId; ?>"<?= ($dbProvinceId == $relProvinceId ? ' selected' : ''); ?>><?= $dbPName; ?></option>
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
							<div class="spacer" style="padding-bottom: 8px;"></div>
							
							<div class="left" style="width: 22%;">Live</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="live" value="Y"<?= $live == "Y" || !$live ? " checked" : ""; ?>> Yes &nbsp&nbsp;
								<input type="radio" name="live" value="N"<?= $live == "N" ? " checked" : ""; ?>> No
							</div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('stores_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
