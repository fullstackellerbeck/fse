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
					<span class="title">Display all contact us subjects</span>	
					<div class="innercontent">
				<?	$countryResult = $db->query( "select country_id, name from countries" );
						if( $db->numRows( $countryResult ) ) {
							while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
								
								$languageResult = $db->query( "select language_id, name from language" );
								if( $db->numRows( $languageResult ) ) {
									while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
										
										$languageCountryCountResult = $db->query( "select count( subject_id ) ".
										                                          "  from contact_us_subjects ".
										                                          " where country_id  = '$countryId' ".
										                                          "   and language_id = '$languageId'" );
										
										list( $subjectCount ) = $db->fetchRow( $languageCountryCountResult );
										
										if( $subjectCount > 0 ) {	?>
											<?= $notFirst ? "<br>" : ""; ?><?= "<b>$countryName</b> &#8212; $languageName"; ?>
											<div class="innercontent" style="width: 550px;">
												<div class="left" style="width: 35%; padding-right: 8px;"><b>Subject</b></div>
												<div class="left" style="width: 40%;"><b>Forwarded to</b></div>
												<div class="spacer"></div>
												<div class="divider"></div>
		
										<?	$bgColor = false;
												$subjectResult = $db->query( "select subject_id, name, action from contact_us_subjects where country_id='$countryId' and language_id='$languageId'" );
												if( $db->numRows( $subjectResult ) ) {
													while( list( $subjectId, $subjectName, $subjectAction ) = $db->fetchRow( $subjectResult ) ) {	?>
														<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
															<div class="left" style="width: 35%; padding-right: 8px;"><?= $subjectName; ?></div>
															<div class="left" style="width: 40%;"><?= $subjectAction; ?></div>
															<div class="right" style="width: 15%; text-align: right;"><a href="contact_subject_edit.php?subject_id=<?= $subjectId; ?>">edit</a> &middot; <a href="javascript:void(delItem('contact_subject_display.php','<?= $subjectId; ?>','contact_us_subjects','subject_id'));">delete</a></div>
															<div class="spacer"></div>
														</div>
											<?		$bgColor = !$bgColor;
													}
												}	?>				
												<div class="spacer"></div>
											</div>
							<?		}
							
										$notFirst = true;
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
