<?	if( file_exists( realpath( $src ) ) ) {
			list( $w, $h, $type, $html ) = getimagesize( realpath( $src ) );
		}	?>
<html>
	<head>
		<title>Yves Veggie Cuisine</title>

		<link rel="stylesheet" href="css/popups.css" type="text/css">
		<script language="javascript">window.resizeTo( <?= $w + 30; ?>, <?= $h + 50; ?> );</script>
	</head>
	
	<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="background-color: #ffffff;" onload="window.focus();">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center" valign="middle"><img src="<?= $src; ?>" width="<?= $w; ?>" height="<?= $h; ?>" border="0"></td>
		  </tr>
		</table>
	</body>
</html>
