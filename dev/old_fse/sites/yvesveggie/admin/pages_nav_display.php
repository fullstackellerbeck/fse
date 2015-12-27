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
					<span class="title">Display navigation set-up</span>	
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

											<div class="innercontent" style="width: 556px;">
												<div class="left" style="width: 35%; padding-right: 5px;"><b>Menu name</b></div>
												<div class="left" style="width: 35%;"><b>Nav type</b></div>
												<div class="left" style="width: 10%;"><b>Priority</b></div>
												<div class="spacer"></div>
												<div class="divider"></div>								
											
										<?	$displayResult = $db->query( "select pages_nav.nav_id, pages_nav.page_id, pages_nav.name, pages_nav.base_image, pages_nav.type, pages.file_name, pages_nav.position ".
										                                 "  from pages_nav, pages ".
										                                 " where pages_nav.page_id     = pages.page_id ".
										                                 "   and pages.parent_page_id  = '0' ".
										                                 "   and pages_nav.language_id = '$languageId' ".
										                                 "   and pages_nav.country_id  = '$countryId' ".
										                                 " order by pages_nav.position asc" );
												if( $db->numRows( $displayResult ) ) {
													while( list( $navId, $pageId, $name, $baseImage, $type, $fileName, $position ) = $db->fetchRow( $displayResult ) ) {	?>
														<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#f4f2e8"; ?>;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#f4f2e8"; ?>';">
															<div class="left" style="width: 35%; padding-right: 5px;"><?= $name; ?></div>
															<div class="left" style="width: 35%;"><?= ucfirst( $type ); ?></div>
															<div class="left" style="width: 10%;"><?= $position; ?></div>
															<div class="right" style="width: 15%; text-align: right; padding-right: 5px;"><a href="pages_nav_edit.php?nav_id=<?= $navId; ?>">edit</a> &middot; <a href="javascript:void(delItem('pages_nav_display.php','<?= $navId; ?>','pages_nav','nav_id'));">delete</a></div>
															<div class="spacer"></div>
													<?	$bgColor = !$bgColor;
															
															$childResult = $db->query( "select pages_nav.nav_id, pages_nav.page_id, pages_nav.name, pages_nav.base_image, pages_nav.type, pages_nav.position ".
															                           "  from pages_nav, pages ".
															                           " where pages_nav.page_id     = pages.page_id ".
															                           "   and pages.parent_page_id  = '$pageId' ".
															                           "   and pages_nav.language_id = '$languageId' ".
											                                   "   and pages_nav.country_id  = '$countryId' ".
											                                   " order by pages_nav.position asc" );
														  
														  if( $db->numRows( $childResult ) ) {	?>
														  	<div class="innercontent" style="width: 534px;">
														<?	while( list( $childNavId, $childPageId, $childName, $childBaseImage, $childType, $childPosition ) = $db->fetchRow( $childResult ) ) {	?>
																	<div style="padding-top: 1px; padding-bottom: 1px;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='transparent';">
																		<div class="left" style="width: 35%;"><?= $childName; ?></div>
																		<div class="left" style="width: 35%; padding-right: 5px;"><?= ucfirst( $childType ); ?></div>
																		<div class="left" style="width: 10%;"><?= $childPosition; ?></div>
																		<div class="right" style="width: 15%; text-align: right;"><a href="pages_nav_edit.php?nav_id=<?= $childNavId; ?>">edit</a> &middot; <a href="javascript:void(delItem('pages_nav_display.php','<?= $childNavId; ?>','pages_nav','nav_id'));">delete</a></div>
																		<div class="spacer"></div>
																	</div>
														<?	}	?>
																</div>
													<?	}		?>
														</div>
											<?	}
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
