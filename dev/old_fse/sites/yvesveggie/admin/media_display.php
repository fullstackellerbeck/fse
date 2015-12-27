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
				<span class="title">Display all releases</span>	
				<div class="innercontent">
			<?	$first = true;
					$bgColor = false;
					
					$countryResult = $db->query( "select country_id, name from countries" );
					
					if( $db->numRows( $countryResult ) ) {
						while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
							$languageResult = $db->query( "select language_id, name from language" );
							
							if( $db->numRows( $languageResult ) ) {
								while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
									$languageCountResult = $db->query( "select count( release_id ) from media_releases where country_id = '$countryId' and language_id = '$languageId'" );
									list( $languageCount ) = $db->fetchRow( $languageCountResult );
									
									if( $languageCount > 0 ) {
										echo( (!$first ? "<br>" : "") . "<b>$countryName</b> &#8212; $languageName<br>\n" );	?>

										<div class="innercontent" style="width: 555px;">
											<div class="left" style="width: 30%;"><b>Title</b></div>
											<div class="left" style="width: 50%; padding-left: 15px;"><b>Content</b></div>
											<div class="spacer"></div>
											<div class="divider"></div>
										
									<?	$displayResult = $db->query( "select release_id, title, content ".
									                                 "  from media_releases ".
									                                 " where country_id  = '$countryId' ".
									                                 "   and language_id = '$languageId' ".
									                                 " order by release_id" );
											if( $db->numRows( $displayResult ) ) {
												$bgColor = false;
												while( list( $releaseId, $title, $content ) = $db->fetchRow( $displayResult ) ) {	?>
													<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">									
														<div class="left" style="width: 30%;"><?= truncWords( $title, 8 ); ?></div>
														<div class="left" style="padding-left: 15px; width: 50%;"><?= truncWords( $content, 15 ); ?></div>
														<div class="right" style="width: 15%; text-align: right;"><a href="media_edit.php?release_id=<?= $releaseId; ?>">edit</a> &middot; <a href="javascript:void(delItem('media_display.php','<?= $releaseId; ?>','media_releases','release_id'));">delete</a></div>
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
