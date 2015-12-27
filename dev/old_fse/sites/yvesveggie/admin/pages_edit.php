<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "name"           => "'$name'",
																						 "file_name"      => "'$file_name'",
																						 "shot_id"        => "'$shot_id'",
																						 "target"         => "'$target'",
																						 "parent_page_id" => "'$parent_page_id'",
	                                           "live"           => "'$live'" ),
																						 array( "page_id", $page_id ),
																						 "pages" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: pages_display.php" );
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
<?	if( $page_id ) {
			$displayResult = $db->query( "select name, file_name, shot_id, target, parent_page_id, live from pages where page_id='$page_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $name, $fileName, $dbShotId, $target, $dbParentPageId, $live ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="pages_edit.php" method="post">
			<input type="hidden" name="page_id" value="<?= $page_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $language_id ? "Edit" : "Add"; ?> a site page</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Page name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Parent page</div>
							<div class="left" style="width: 60%;">
								<select name="parent_page_id" class="adminselect">
									<option value="0"></option>
							<?	$pageResult = $db->query( "select page_id, name from pages" );
									if( $db->numRows( $pageResult ) ) {
										while( list( $pageId, $pageName ) = $db->fetchRow( $pageResult ) ) {	?>
										 <option value="<?= $pageId; ?>"<?= ($pageId == $dbParentPageId ? " selected" : ""); ?>><?= $pageName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer" style="padding-bottom: 8px;"></div>							

							<div class="left" style="width: 22%;">Beauty shot</div>
							<div class="left" style="width: 60%;">
								<select name="shot_id" class="adminselect">
							<?	$shotResult = $db->query( "select shot_id, name from beauty_shots" );
									if( $db->numRows( $shotResult ) ) {
										while( list( $shotId, $shotName ) = $db->fetchRow( $shotResult ) ) {	?>
										 <option value="<?= $shotId; ?>"<?= ($shotId == $dbShotId ? " selected" : ""); ?>><?= $shotName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer" style="padding-bottom: 8px;"></div>							
							
							<div class="left" style="width: 22%;">File name</div>
							<div class="left" style="width: 60%;"><input type="text" name="file_name" class="admintext" value="<?= $fileName; ?>"></div>
							<div class="spacer" style="padding-bottom: 10px;"></div>

							<div class="left" style="width: 22%;">Target</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="target" value="_self"<?= !$target || $target == "_self" ? " checked" : ""; ?> id="tgtSelf"> <label for="tgtSelf">Same window</label> &nbsp&nbsp;
								<input type="radio" name="target" value="_blank"<?= $target == "_blank" ? " checked" : ""; ?> id="tgtBlank"> <label for="tgtBlank">New window</label>
							</div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Live</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="live" id="yes" value="Y"<?= !$live || $live == "Y" ? " checked" : ""; ?>> <label for="yes">Yes</label> &nbsp&nbsp;
								<input type="radio" name="live" id="no" value="N"<?= $live == "N" ? " checked" : ""; ?>> <label for="no">No</label>
							</div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('pages_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
