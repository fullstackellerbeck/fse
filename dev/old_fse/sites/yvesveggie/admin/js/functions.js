/**
 * Sets/unsets the pointer in browse mode
 *
 * @param   object   the table row
 * @param   object   the color to use for this row
 * @param   object   the background color
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, thePointerColor, theNormalBgColor) {
    var theCells = null;

    if( thePointerColor == '' || typeof(theRow.style) == 'undefined' ) {
    	return false;
    }
    
    if( typeof(document.getElementsByTagName) != 'undefined' ) {
    	theCells = theRow.getElementsByTagName( 'td' );
    } else if ( typeof( theRow.cells ) != 'undefined' ) {
    	theCells = theRow.cells;
    } else {
    	return false;
    }

    var rowCellsCnt  = theCells.length;
    var currentColor = null;
    var newColor     = null;
    
    // Opera does not return valid values with "getAttribute"
    if( typeof(window.opera) == 'undefined' && typeof( theCells[ 0 ].getAttribute ) != 'undefined' && typeof( theCells[ 0 ].getAttribute ) != 'undefined' ) {
	    currentColor = theCells[0].getAttribute('bgcolor');
	    newColor     = ( (currentColor.toLowerCase() == thePointerColor.toLowerCase()) ? theNormalBgColor : thePointerColor );

	    for( var c = 0; c < rowCellsCnt; c++ ) {
	    	theCells[ c ].setAttribute( 'bgcolor', newColor, 0 );
	    }

    } else {
	    currentColor = theCells[0].style.backgroundColor;
	    newColor     = ( (currentColor.toLowerCase() == thePointerColor.toLowerCase()) ? theNormalBgColor : thePointerColor );
	    for( var c = 0; c < rowCellsCnt; c++ ) {
	    	theCells[ c ].style.backgroundColor = newColor;
	    }
    }

    return true;
}


function delItem( scriptName, itemId, tableName, idName, additional ) {
	var reqResult;
	reqResult = window.confirm( 'Are you sure you want to delete this item?' );

	if( reqResult ) {
		location.href = scriptName + '?delTable=' + tableName + '&idColumn=' + idName + '&idNum=' + itemId + (additional ? additional : '');
	}
}

function delCascadeItem( scriptName, itemId, tableName, idName, otherTables ) {
	var reqResult;
	reqResult = window.confirm( 'Are you sure you want to delete this item?' );

	if( reqResult ) {
		location.href = scriptName + '?delCascadeTable=' + tableName + '&idColumn=' + idName + '&idNum=' + itemId + '&otherTables=' + (otherTables.join( '+' ));
	}
}

function delAllItem( scriptName, tableName ) {
	var reqResult;
	reqResult = window.confirm( 'Are you sure you want all items?' );

	if( reqResult ) {
		location.href = scriptName + '?delAllTable=' + tableName;
	}
}

function confirmCancel( url ) {
	var reqResult = window.confirm( 'Are you sure you want to cancel?' );
	
	if( reqResult ) {
		location.href = url;
	}
}

function getParameter ( queryString, parameterName ) {
	var parameterName = parameterName + '=';

	if ( queryString.length > 0 ) {
		begin = queryString.indexOf ( parameterName );

		if ( begin != -1 ) {
			begin += parameterName.length;

			end = queryString.indexOf ( '&' , begin );

			if ( end == -1 ) {
				end = queryString.length
			}

			return( unescape( queryString.substring ( begin, end ) ) );
		}

		return( null );
	}
}

function selectAll( obj ) {
	for( var i = 0; i < obj.elements.length; i++ ) {
		if( obj.elements[ i ].type == 'checkbox' ) {
			obj.elements[ i ].checked = true;
		}
	}
	
	document.getElementById( 'selectDiv' ).innerHTML = '<b><a href="javascript:unselectAll( document.bunny );" >Uncheck all</a></b>';
}

function unselectAll( obj ) {
	for( var i = 0; i < obj.elements.length; i++ ) {
		if( obj.elements[ i ].type == 'checkbox' ) {
			obj.elements[ i ].checked = false;
		}
	}
	
	document.getElementById( 'selectDiv' ).innerHTML = '<b><a href="javascript:selectAll( document.bunny );" >Check all</a></b>';
}
