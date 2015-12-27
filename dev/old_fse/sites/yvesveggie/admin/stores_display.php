<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}

		if( $fold ) {
			$getCurrentResult = $db->query( "select folded from stores_provinces where province_id='$fold'" );
			if( $db->numRows( $getCurrentResult ) ) {
				list( $folded ) = $db->fetchRow( $getCurrentResult );
				$newFolded = ( $folded == "Y" ? "N" : "Y" );
			
				$setFoldedResult = $db->query( "update stores_provinces set folded='$newFolded' where province_id='$fold'" );
			}
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
					<span class="title">Display all stores</span>	
					<div class="innercontent">
						
				<?	$countryResult = $db->query( "select country_id, name, live from countries" );
						if( $db->numRows( $countryResult ) ) {
							while( list( $countryId, $countryName, $countryLive ) = $db->fetchRow( $countryResult ) ) {
								
								$countryCountResult = $db->query( "select count( country_id ) from stores_provinces where country_id='$countryId'" );
								list( $countryCount ) = $db->fetchRow( $countryCountResult );
								
								if( $countryCount > 0 ) {		?>
									<div  style="background-color: #fcfcfc;"><?= $notFirst != false ? "<br>" : ""; ?><b><?= $countryName; ?></b></div>
									<div class="divider"></div>
									
							<?	$provinceResult = $db->query( "select province_id, name, live, folded ".
									                              "  from stores_provinces ".
									                              " where country_id = '$countryId' ".
									                              "   and rel_province_id = '0'" ); 
									
									$notFirst = false;
									if( $db->numRows( $provinceResult ) ) {
										while( list( $provinceId, $provinceName, $provinceLive, $provinceFolded ) = $db->fetchRow( $provinceResult ) ) {
											
//											$provinceCountResult = $db->query( "select count( province_id ) from stores where province_id='$provinceId'" );
	//										list( $provinceCount ) = $db->fetchRow( $provinceCountResult );
											
		//									if( $provinceCount > 0 ) {
												$relResult = $db->query( "select province_id, name from stores_provinces where country_id = '$countryId' and rel_province_id = '$provinceId'" );
												if( $relResult && $db->numRows( $relResult ) ) {
													while( list( $relProvinceId, $relName ) = $db->fetchRow( $relResult ) ) {
														$relProvs .= ( $relProvs ? ", " : "" ) . '<a href="stores_province_edit.php?province_id=' . $relProvinceId . '">' . $relName . '</a>';
													}
												 
												}	?>
												<div class="parentrow" style="padding-top: 3px; padding-bottom: 3px;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='transparent';">
													<div class="left" style="width: 82%;"><a href="stores_display.php?fold=<?= $provinceId; ?>"><img src="images/<?= $provinceFolded == "Y" ? "folded.gif" : "unfolded.gif"; ?>" width="5" height="5" border="0" style="padding: 0px 1px 1px 1px;"></a>&nbsp;<a href="stores_display.php?fold=<?= $provinceId; ?>"><?= $provinceName; ?></a> <?= $relProvs ? "<i>($relProvs)</i>" : ""; ?></div>
													<div class="right" style="width: 15%; padding-right: 8px; text-align: right;"><a href="stores_province_edit.php?province_id=<?= $provinceId; ?>">edit</a> &middot; <a href="javascript:void(delItem('stores_display.php','<?= $provinceId; ?>','stores_provinces','province_id'));">delete</a></div>
													<div class="spacer"></div>
												</div>
												
										<?	if( $provinceFolded != "Y" ) {	?>
													<div class="innercontent" style="width: 556px; background-color: #ffffff;">
														<div class="left" style="width: 50%;"><b>Store name</b></div>
														<div class="left" style="width: 20%;"><b>Live</b></div>
														<div class="spacer"></div>
														<div class="divider"></div>
	
												<?	$storeResult = $db->query( "select store_id, name, live from stores where province_id = '$provinceId'" );
														if( $db->numRows( $storeResult ) ) {
															$bgColor = false;
															while( list( $storeId, $storeName, $storeLive ) = $db->fetchRow( $storeResult ) ) {	?>
																<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
																	<div class="left" style="width: 50%;"><?= $storeName; ?></div>
																	<div class="left" style="width: 20%;"><?= $storeLive == "Y" ? "Yes" : "No"; ?></div>
																	<div class="right" style="width: 15%; text-align: right;"><a href="stores_edit.php?store_id=<?= $storeId; ?>">edit</a> &middot; <a href="javascript:void(delItem('stores_display.php','<?= $storeId; ?>','stores','store_id'));">delete</a></div>
																	<div class="spacer"></div>
																</div>
													<?		$bgColor = !$bgColor;
															}
														}	?>				
														<div class="spacer"></div>
													</div>
									<?		}
									
												unset( $relProvs );									
											//}
										}
									
										$notFirst = true;
									}
								}
							}
					}	?>	
				</div>
			</div>
		</form>
	</body>
</html>
