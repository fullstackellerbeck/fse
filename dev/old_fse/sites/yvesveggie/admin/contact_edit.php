<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "country_id"  => "'$country_id'",
	                                           "language_id" => "'$language_id'",
	                                           "subject_id"  => "'$subject_id'",
	                                           "first_name"  => "'$first_name'",
	                                           "last_name"   => "'$last_name'",
	                                           "email"       => "'$email'",
	                                           "message"     => "'$message'" ),
																						 array( "contact_id", $contact_id ),
																						 "contact_us" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: contact_display.php" );
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
<?	if( $contact_id ) {
			$displayResult = $db->query( "select country_id, language_id, subject_id, first_name, last_name, email, message from contact_us where contact_id = '$contact_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $mainCountryId, $mainLanguageId, $mainSubjectId, $firstName, $lastName, $email, $message ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="contact_edit.php" method="post">
			<input type="hidden" name="contact_id" value="<?= $contact_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $faq_id ? "Edit" : "Add"; ?> an inquiry</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Country</div>
							<div class="left" style="width: 60%;">
								<select name="country_id" class="adminselect">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {	?>
										 <option value="<?= $countryId; ?>"<?= ($countryId == $mainCountryId ? " selected" : ""); ?>><?= $countryName; ?></option>
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
										 <option value="<?= $languageId; ?>"<?= ($languageId == $mainLanguageId ? " selected" : ""); ?>><?= $languageName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer"></div>							

							<div class="left" style="width: 22%;">Message subject</div>
							<div class="left" style="width: 60%;">
								<select name="subject_id" class="adminselect" onchange="document.work.location.href='nutritional_iframe.php?family_id=' + document.bunny.family_id.options[ document.bunny.family_id.selectedIndex ].value + (document.bunny.product_id.value ? '&product_id=' + document.bunny.product_id.value : '');">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $dbCountryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
											
											$languageResult = $db->query( "select language_id, name from language" );
											if(	 $db->numRows( $languageResult ) ) {
												while( list( $dbLanguageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
													$languageCountryCountResult = $db->query( "select count( subject_id ) ".
													                                          "  from contact_us_subjects ".
													                                          " where country_id = '$dbCountryId' ".
													                                          "   and language_id = '$dbLanguageId'" );
													
													list( $familyCount ) = $db->fetchRow( $languageCountryCountResult );											
													if( $familyCount > 0 ) {	?>
														<optgroup label="<?= "$countryName - $languageName"; ?>">
													<?	$familyResult = $db->query( "select subject_id, name ".
													                                "  from contact_us_subjects ".
													                                " where country_id  = '$dbCountryId' ".
													                                "   and language_id = '$dbLanguageId'" );
															if( $db->numRows( $familyResult ) ) {
																while( list( $dbSubjectId, $subjectName ) = $db->fetchRow( $familyResult ) ) {	?>
																	<option value="<?= $dbSubjectId; ?>"<?= ($mainSubjectId == $dbSubjectId ? " selected" : ""); ?>><?= $subjectName; ?></option>
														<?	}
															}	?>
														</optgroup>
										<?		}
												}
											}
										}
									}	?>
								</select>
							</div>
							<div class="spacer" style="padding-bottom: 8px;"></div>

							<div class="left" style="width: 22%;">First name</div>
							<div class="left" style="width: 60%;"><input type="text" name="first_name" class="admintext" value="<?= $firstName; ?>"></div>
							<div class="spacer"></div>
	
							<div class="left" style="width: 22%;">Last name</div>
							<div class="left" style="width: 60%;"><input type="text" name="last_name" class="admintext" value="<?= $lastName; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">E-mail</div>
							<div class="left" style="width: 60%;"><input type="text" name="email" class="admintext" value="<?= $email; ?>"></div>
							<div class="spacer" style="padding-bottom: 8px;"></div>

							<div class="left" style="width: 22%;">Message</div>
							<div class="left" style="width: 60%;"><textarea name="message" class="admintextarea"><?= $message; ?></textarea></div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('contact_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
