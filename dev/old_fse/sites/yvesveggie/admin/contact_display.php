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
		<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
		<div style="margin: 5px 5px 5px 5px;">
			<div class="menu" style="margin-right: 5px;">
				<? include( "admin_menu.php" ); ?>
			</div>
			<div class="contentbox">
				<div>
					<div style="float: left"><span class="title">Display all releases</span></div>
					<div style="float: right;"><a href="export_contact_us.php">export</a> &middot; <a href="#" onclick="delAllItem('contact_display.php','contact_us');">delete all</a></div>
				</div>
				
				<div class="innercontent">
			<?	$first = true;
					$bgColor = false;
					
					$countryResult = $db->query( "select country_id, name from countries" );
					
					if( $db->numRows( $countryResult ) ) {
						while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
							$languageResult = $db->query( "select language_id, name from language" );
							
							if( $db->numRows( $languageResult ) ) {
								while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
									$languageCountResult = $db->query( "select count( contact_id ) from contact_us where country_id = '$countryId' and language_id = '$languageId'" );
									list( $languageCount ) = $db->fetchRow( $languageCountResult );
									
									if( $languageCount > 0 ) {
										echo( (!$first ? "<br>" : "") . "<b>$countryName</b> &#8212; $languageName<br>\n" );	?>

										<div class="innercontent" style="width: 555px;">
											<div class="left" style="width: 20%;"><b>Full name</b></div>
											<div class="left" style="width: 17%; padding-left: 5px;"><b>Subject</b></div>
											<div class="left" style="width: 30%; padding-left: 5px;"><b>E-mail</b></div>
											<div class="left" style="width: 15%; padding-left: 5px;"><b>Date</b></div>
											<div class="spacer"></div>
											<div class="divider"></div>
										
									<?	$displayResult = $db->query( "select contact_us.contact_id, contact_us_subjects.name, contact_us.first_name, contact_us.last_name, contact_us.email, unix_timestamp( contact_us.date_posted ) ".
									                                 "  from contact_us, contact_us_subjects ".
									                                 " where contact_us.subject_id = contact_us_subjects.subject_id ".
									                                 "   and contact_us.country_id  = '$countryId' ".
									                                 "   and contact_us.language_id = '$languageId' " );
											if( $db->numRows( $displayResult ) ) {
												$bgColor = false;
												while( list( $contactId, $subjectName, $firstName, $lastName, $email, $datePosted ) = $db->fetchRow( $displayResult ) ) {	?>
													<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
														<div class="left" style="width: 20%;"><?= "$firstName $lastName"; ?></div>
														<div class="left" style="padding-left: 5px; width: 17%;"><?= $subjectName; ?></div>
														<div class="left" style="padding-left: 5px; width: 30%;"><?= $email; ?></div>
														<div class="left" style="padding-left: 5px; width: 15%;"><?= date( "M j, Y", $datePosted ); ?></div>
														<div class="right" style="width: 15%; text-align: right;"><a href="contact_edit.php?contact_id=<?= $contactId; ?>">edit</a> &middot; <a href="javascript:void(delItem('contact_display.php','<?= $contactId; ?>','contact_us','contact_id'));">delete</a></div>
														<div class="spacer" style="padding-bottom: 5px;"></div>
													</div>
										<?		$bgColor = !$bgColor;
												}
											}	?>
											
											<div class="spacer"></div>
										</div>
							<?		$first = false;
									}
								}
							}
						}
					}	?>
			</div>
		</div>
	</body>
</html>
