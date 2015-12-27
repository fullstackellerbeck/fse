<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}			?>		
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
					<span class="title">Display all site pages</span>	
						<div class="innercontent" style="width: 577px;">
							<div class="left" style="width: 35%; padding-right: 4px;"><b>Page name</b></div>
							<div class="left" style="width: 45%;"><b>File name</b></div>
							<div class="spacer"></div>
							<div class="divider"></div>								
						
					<?	$bgColor = false;
							
							$displayResult = $db->query( "select pages.page_id, pages.name, pages.file_name from pages where parent_page_id = '0'" );
							if( $db->numRows( $displayResult ) ) {
								while( list( $pageId, $name, $fileName ) = $db->fetchRow( $displayResult ) ) {	?>
									<div style="padding-top: 2px; padding-bottom: 3px; width: 578px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
										<div class="left" style="width: 35%; padding-right: 5px;"><?= $name; ?></div>
										<div class="left" style="width: 45%;"><?= truncChars( $fileName, 45 ); ?></div>
										<div class="right" style="width: 15%; text-align: right; padding-right: 5px;"><a href="pages_edit.php?page_id=<?= $pageId; ?>">edit</a> &middot; <a href="javascript:void(delItem('pages_display.php','<?= $pageId; ?>','pages','page_id'));">delete</a></div>
										<div class="spacer"></div>
							<?	$bgColor = !$bgColor;

									$childResult = $db->query( "select page_id, name, file_name ".
									                           "  from pages ".
									                           " where parent_page_id = '$pageId'" );
								  if( $db->numRows( $childResult ) ) {	?>
								  	<div class="innercontent" style="width: 555px;">
									<?	while( list( $childPageId, $childName, $childFileName ) = $db->fetchRow( $childResult ) ) {	?>
												<div style="padding-top: 1px; padding-bottom: 2px;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='#ffffff';">
													<div class="left" style="width: 35%;"><?= $childName; ?></span></div>
													<div class="left" style="width: 45%;"><?= truncChars( $childFileName, 40 ); ?></span></div>
													<div class="right" style="width: 15%; text-align: right; padding-left: 8px; padding-right: 2px;"><a href="pages_edit.php?page_id=<?= $childPageId; ?>">edit</a> &middot; <a href="javascript:void(delItem('pages_display.php','<?= $childPageId; ?>','pages','page_id'));">delete</a></div>
													<div class="spacer"></div>
												
	
										<?	$childCountResult = $db->query( "select count( page_id ) from pages where parent_page_id = '$childPageId'" );
												if( $db->numRows( $childCountResult ) ) {
													list( $childCount ) = $db->fetchRow( $childCountResult );
													
													if( $childCount > 0 ) {
														$childResult = $db->query( "select page_id, name, file_name ".
														                           "  from pages ".
														                           " where parent_page_id = '$childPageId'" );
													  if( $db->numRows( $childResult ) ) {	?>
			
													  	<div class="innercontent" style="width: 534px;">
													<?	while( list( $childPageId, $childName, $childFileName ) = $db->fetchRow( $childResult ) ) {	?>
																<div style="padding-top: 1px; padding-bottom: 0px;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='#ffffff';">
																	<div class="left" style="width: 35%;"><?= $childName; ?></span></div>
																	<div class="left" style="width: 45%;"><?= truncChars( $childFileName, 40 ); ?></span></div>
																	<div class="right" style="width: 15%; text-align: right;"><a href="pages_edit.php?page_id=<?= $childPageId; ?>">edit</a> &middot; <a href="javascript:void(delItem('pages_display.php','<?= $childPageId; ?>','pages','page_id'));">delete</a></div>
																	<div class="spacer"></div>
																</div>
													<?	}	?>
															</div>
												<?	}
													}	?>
												
													</div>												
										<?	}
											}	?>
										</div>
							<?	}	?>
								</div>

						<?	}
							}	?>
						</div>
								
						<div class="spacer"></div>
					</div>					
			</div>
		</form>
	</body>
</html>
