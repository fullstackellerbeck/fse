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
					<span class="title">Display all pages / content</span>	
					<div class="innercontent">
				<?	$first = true;
						$bgColor = false;
						
						$countryResult = $db->query( "select country_id, name from countries" );
						
						if( $db->numRows( $countryResult ) ) {
							while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
								$languageResult = $db->query( "select language_id, name from language" );
								
								if( $db->numRows( $languageResult ) ) {
									while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
										$languageCountResult = $db->query( "select count( language_id ) from pages_content where country_id = '$countryId' and language_id = '$languageId'" );
										list( $languageCount ) = $db->fetchRow( $languageCountResult );
										
										if( $languageCount > 0 ) {
											echo( (!$first ? "<br>" : "") . "<b>$countryName</b> &#8212; $languageName<br>\n" );	?>

											<div class="innercontent" style="width: 555px;">
												<div class="left" style="width: 25%;"><b>Page / File name</b></div>
												<div class="left" style="width: 40%;"><b>Content</b></div>
												<div class="spacer"></div>
												<div class="divider"></div>								
											
										<?	$displayResult = $db->query( "select pages.page_id, pages.name, pages.file_name, pages_content.content_id, pages_content.content ".
										                                 "  from pages, pages_content ".
										                                 " where pages.page_id = pages_content.page_id ".
										                                 "   and pages_content.language_id = '$languageId' ".
										                                 "   and pages_content.country_id  = '$countryId' ".
										                                 " order by pages.file_name" );
												if( $db->numRows( $displayResult ) ) {
													while( list( $pageId, $name, $fileName, $contentId, $content ) = $db->fetchRow( $displayResult ) ) {	?>
														<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
															<div class="left" style="width: 25%;"><?= $name; ?><br><span class="small">(<i><?= $fileName; ?></i>)</span></div>
															<div class="left" style="width: 55%;"><?= truncWords( strip_tags( $content ), 15 ); ?></div>
															<div class="right" style="width: 15%; text-align: right;"><a href="pages_content_edit.php?content_id=<?= $contentId; ?>">edit</a> &middot; <a href="javascript:void(delItem('pages_content_display.php','<?= $contentId; ?>','pages_content','content_id'));">delete</a></div>
															<div class="spacer"></div>
														</div>
												<?	$bgColor = !$bgColor;
													}
												}	?>
											</div>
								<?		$first = false;
										}
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
