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
				<span class="title">Display all nutritional attribs</span>	
				<div class="innercontent">
			<?	$first = true;
					$bgColor = false;
					
					$countryResult = $db->query( "select country_id, name from countries" );
					
					if( $db->numRows( $countryResult ) ) {
						while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {
							$languageResult = $db->query( "select language_id, name from language" );
							
							if( $db->numRows( $languageResult ) ) {
								while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {
									$languageCountResult = $db->query( "select count( attribute_id ) from nutritional_compare_attribs where country_id = '$countryId' and language_id = '$languageId'" );
									list( $languageCount ) = $db->fetchRow( $languageCountResult );
									
									if( $languageCount > 0 ) {
										echo( (!$first ? "<br>" : "") . "<b>$countryName</b> &#8212; $languageName<br>\n" );	?>

										<div class="innercontent" style="width: 555px;">
											<div class="left" style="width: 40%;"><b>Name</b></div>
											<div class="left" style="width: 19%; padding-left: 5px;"><b>Units</b></div>
											<div class="left" style="width: 10%; padding-left: 5px;"><b>Units</b></div>
											<div class="spacer"></div>
											<div class="divider"></div>
										
									<?	$displayResult = $db->query( "select attribute_id, name, units, priority ".
									                                 "  from nutritional_compare_attribs ".
									                                 " where country_id  = '$countryId' ".
									                                 "   and language_id = '$languageId' " .
									                                 " order by priority asc" );
											if( $db->numRows( $displayResult ) ) {
												$bgColor = false;
												while( list( $attribId, $name, $units, $priority ) = $db->fetchRow( $displayResult ) ) {	?>
													<div style="padding-top: 3px; padding-bottom: 0px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">									
														<div class="left" style="width: 40%;"><?= $name; ?></div>
														<div class="left" style="padding-left: 5px; width: 19%;"><?= $units; ?></div>
														<div class="left" style="padding-left: 5px; width: 10%;"><?= $priority; ?></div>
														<div class="right" style="width: 15%; text-align: right;"><a href="product_compare_nutrition_edit.php?attribute_id=<?= $attribId; ?>">edit</a> &middot; <a href="javascript:void(delItem('product_compare_nutrition_display.php','<?= $attribId; ?>','nutritional_compare_attribs','attribute_id'));">delete</a></div>
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
