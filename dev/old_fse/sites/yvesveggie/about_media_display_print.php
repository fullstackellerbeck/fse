<?	include( "inc/init.php" );	?>										     	
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine</title>

		<link rel="stylesheet" type="text/css" href="css/print.css" />
	</head>
	
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="window.print();">
		<table border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="3"><img src="images/universal/spacer.gif" width="1" height="16" /></td></tr>
			<tr>
				<td><img src="images/universal/spacer.gif" width="12" height="1" /></td>
				<td>
						<?	$releaseResult = $db->query( "select release_date, title, location, content, auto_html from media_releases where release_id = '$release_id'" );
								if( $db->numRows( $releaseResult ) ) {
									list( $releaseDate, $title, $location, $content, $autoHTML ) = $db->fetchRow( $releaseResult );
								}	?>

		            <h3><?= $title; ?></h3>
		            <p>(<?= $location; ?>) &#8212; <?= strtr( stripslashes( $autoHTML == "Y" ? nl2br( $content ) : $content ), $trans ); ?></p>
		            <p>&nbsp;</p>
		            <p class="small">&nbsp;</p>
			    </td></tr>
			    </table>
				</td>
				<td><img src="images/universal/spacer.gif" width="12" height="1" /></td>
			</tr>
			<tr><td colspan="3"><img src="images/universal/spacer.gif" width="1" height="16" /></td></tr>
		</table>
	</body>
</html>
