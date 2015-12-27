<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "name"        => "'$name'",
																						 "province_id" => "'$provinceId'",
	                                           "live"        => "'$live'" ),
																						 array( "store_id", $store_id ),
																						 "stores" );
	
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
	
	<body onload="document.bunny.name.focus();">
<?	if( $store_id ) {
			$displayResult = $db->query( "select province_id, name, live from stores where store_id='$store_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $provinceId, $name, $live ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form action="stores_edit.php" name="bunny" method="post">
			<input type="hidden" name="store_id" value="<?= $store_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $store_id ? "Edit" : "Add"; ?> a store</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
			
							<div class="left" style="width: 22%;">Name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Province / State</div>
							<div class="left" style="width: 60%;">
								<select name="provinceId" class="adminselect">
							<?	$countryResult = $db->query( "select province_id, name from stores_provinces" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $dbProvinceId, $provinceName ) = $db->fetchRow( $countryResult ) ) {	?>
										 <option value="<?= $dbProvinceId; ?>"<?= ($provinceId == $dbProvinceId ? " selected" : ""); ?>><?= $provinceName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">Live</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="live" id="yes" value="Y"<?= !$live || $live == "Y" ? " checked" : ""; ?>><label for="yes">Yes</label> &nbsp&nbsp;
								<input type="radio" name="live" id="no" value="N"<?= $live == "N" ? " checked" : ""; ?>><label for="no">No</label>
							</div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel( 'stores_display.php' );">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
