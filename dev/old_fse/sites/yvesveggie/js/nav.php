<?	ini_set( "include_path", "../" );
		include( "inc/init.php" );	?>
	
	var thisFileName = '<?= $scriptName; ?>';
	var _id = 0, _pid = 0, _lid = 0, _pLayer;
	var _mLists = new Array();
	var isNav4 = false, isIE4 = false, isNav6 = false;
	var timeOverId;
	
	
	document.lists = _mLists;
	
	if( is_nav4up && !is_nav6 ) {
	  isNav4 = true;
	} else if( is_ie4up ){
	  isIE4 = true;
	} else if( is_nav6up || is_gecko ) {
	  isNav6 = true;
	}
	
	function List( visible, width, height, fileName ) {
	  self.selectedColor = '#ffffff';
	  self.clickedNavColor = '#ffffff';
	  self.bgColor = '#ffffff';
	  this.bgColor = '#ffffff';
		this.selectedItem = null;
		  
	  this.navImageSwap = navImageSwap;
	  this.resetNav = resetNav;
	  this.addItem = addItem;
	  this.addHTML = addHTML;
	  this.addList = addList;
	  this.addFloater = addFloater;
	  this.build = build;
	  this.rebuild = rebuild;
	  this.setActiveItem = setActiveItem;
	
	  this._writeList = _writeList;
	  this._showList = _showList;
	  this._updateList = _updateList;
	  this._updateParent = _updateParent;
	
	  this.lastList = 0;
	  this.lastItemId = false;
	  this.lastSubItem = false;
	
	  this.onexpand = null;
	  this.postexpand = null;
	
	  this.lists = new Array(); // sublists
	  this.items = new Array(); // layers
	  this.types = new Array(); // type
	  this.strs = new Array();  // content
	  this.navImg = new Array();  // content
	  this.links = new Array();  // links
	  this.target = new Array();
		this.h = new Array();
		this.w = new Array();
	
		this.fileName = fileName;
	  this.x = 18;
	  this.y = 118;
	  this.visible = visible;
	  this.id = _id;
	  this.i = 15;
	  this.space = true;
	  this.pid = 0;
	  this.fontIntro = false;
	  this.fontOutro = false;
	  this.width = width || 350;
	  this.height = height || 20;
	  this.parLayer = false;
	  this.built = false;
	  this.shown = false;
	  this.needsUpdate = false;
	  this.needsRewrite = false;
	  this.parent = null;
	  this.l = 0;
	  _mLists[ _id++ ] = this;
	}
	
	function navImageSwap( imgName, imgSrc, thisNavId ){
	  var rootObj = _mLists[ 0 ];
	  var lastItemId = rootObj.lastItemId;
	  var lastSubItem = rootObj.lastSubItem;
	
	  if( (thisNavId.id != lastItemId) && (thisNavId.id != lastSubItem) ) {
	    if( imgName && imgSrc ) {
	      if( document.images ) {
	        if( typeof( imgName ) == 'string' ) {
	          if( isIE4 ) {
	            document.images[ imgName ].src = imgSrc;
	          } else if( isNav4 ) {
	            document.layers[ thisNavId ].document.images[imgName].src = imgSrc;
	          } else if( isNav6 ) {
	          	document.getElementById( imgName ).src = imgSrc;
	          }
	        } else if( ( typeof( imgSrc ) == 'object' ) && imgName && imgName.src ) {
	          imgName.src = imgSrc;
	        }
	      }
	    }
	  }
	}
	
	function setClip( layer, l, r, t, b ) {
	  if( isNav4 ) {
	    layer.clip.left = l; layer.clip.right = r;
	    layer.clip.top = t;  layer.clip.bottom = b;
	  } else if( isIE4 ){
	    layer.style.pixelWidth = r - l;
	    layer.style.pixelHeight = b - t;
	    layer.style.clip = "rect(" + t + ", " + r + ", " + b + ", " + l + ")";
	  } else if( isNav6 ) {
	    layer.style.width = r - l;
	    layer.style.height = b - t;
	    layer.style.clip = "rect(" + t + ", " + r + ", " + b + ", " + l + ")";
		}  	
	}
	
	function _writeList( d ) {
	  self.status = "Building navigation...";
	  var layer, str, clip;
	  var rootObj = _mLists[ 0 ];
		var thisFileName = this.fileName;
		var itemId = passedPageId = itemNameId = null;
		var locSearch = window.top.location.search;
	
<?	$parseU = parse_url( $_SERVER[ "HTTP_REFERER" ] );
		$thisPage = basename( $parseU[ "path" ] );
		
		$parentResult = $db->query( "select file_name, parent_page_id ".
		                            "  from pages ".
		                            " where file_name = '$thisPage'" );
		                            
		if( $db->numRows( $parentResult ) ) {
			list( $realFileName, $pPageId ) = $db->fetchRow( $parentResult );
			
			while( $pPageId != 0 ) {
				$realResult = $db->query( "select file_name, parent_page_id ".
				                          "  from pages ".
				                          " where page_id = '$pPageId'" );
				if( $db->numRows( $realResult ) ) {
					list( $realFileName, $pPageId ) = $db->fetchRow( $realResult );
				}
			}	?>		
			
			thisFileName = '<?= $realFileName; ?>';
<?	}	?>
		
		if( locSearch != 0 ) {
			passedPageId = getParameter( window.top.location.search, 'page' );
			itemId = getParameter( window.top.location.search, 'pId' );
			itemNameId = unescape( getParameter( window.top.location.search, 'pIdName' ) );
		}
	
	  for(var i = 0; i < this.types.length; i++) {
	    layer = this.items[i];
	
			pageInc = ( passedPageId == d ? (locSearch != 0 ? '&' : '?') + 'page=' + d : '' );
		  itemInc = ( passedPageId == d ? (locSearch != 0 || pageInc != '' ? '&' : '?') + 'pId=' + this.items[ i ].id : '' );
			itemNameInc = ( passedPageId == d ? (locSearch != 0 || pageInc != '' ? '&' : '?') + 'pIdName=' + escape( this.strs[ i ] ) : '' );
			
	    if( isNav4 ) {
	      layer.visibility = "hidden";
	      layer.document.open();
	    } else {
	      layer.style.visibility = "hidden";
	    }
	
	    str = '<table border="0" cellspacing="0" cellpadding="0" height="' + this.height + '" width="' + this.width + '"><tr>';
	
	    if( this.types[ i ] == 'list' ){ // javascript:expand(' + this.lists[ i ].id + ');
	      str += '<td colspan="2"><a href="' + this.links[ i ] + (locSearch != 0 ? '?' : '?') + 'page=' + this.lists[ i ].id + '" class="subnav" id="link' + this.items[ i ].id + '" ' +
	             (!this.navImg[ i ] || this.links[ i ] == thisFileName ? '' : 'onmouseover="navImageSwap(\'_navimg' + this.items[ i ].id + '\', \'images/nav/' + this.navImg[ i ] + '_on.gif\',\'' + this.items[ i ].id  +'\');" ') +
	             (!this.navImg[ i ] || this.links[ i ] == thisFileName ? '' :'onmouseout="navImageSwap(\'_navimg' + this.items[ i ].id + '\', \'images/nav/' + this.navImg[ i ] + '_off.gif\',\'' + this.items[ i ].id +'\');"') + '>' + (!this.navImg[ i ] ? this.strs[ i ] : '<img src="images/nav/' + this.navImg[ i ] + '_' + (this.links[ i ] == thisFileName ? 'on' : 'off') + '.gif" name="_navimg' + this.items[ i ].id + '" id="_navimg' + this.items[ i ].id + '" width="160" height="20" border="0">') + '</a></td>';
	
	      _pid++;
	    } else if( this.types[ i ] == 'item' ) {
	      str += '<td colspan="2"><a href="' + this.links[ i ] + '" class="subnav" ' + (isNav4 ? 'style="font-family: verdana, arial, sans serif; font-size: 11px; color: #0000000; text-decoration: none;"' : '') + ' id="link' + this.items[ i ].id + '" ' +
	             (!this.navImg[ i ] || this.links[ i ] == thisFileName ? '' : 'onmouseover="navImageSwap(\'_navimg' + this.items[ i ].id + '\', \'images/nav/' + this.navImg[ i ] + '_on.gif\',\'' + this.items[ i ].id +'\');" ') +
	             (!this.navImg[ i ] || this.links[ i ] == thisFileName ? '' : 'onmouseout="navImageSwap(\'_navimg' + this.items[ i ].id + '\', \'images/nav/' + this.navImg[ i ] + '_off.gif\',\'' + this.items[ i ].id +'\');"') + '>' + (!this.navImg[ i ] ? this.strs[ i ] : '<img src="images/nav/' + this.navImg[ i ] + '_' + (this.links[ i ] == thisFileName ? 'on' : 'off') + '.gif" name="_navimg' + this.items[ i ].id + '" id="_navimg' + this.items[ i ].id + '" width="160" height="20" border="0">') + '</a></td>';
	
	    } else if( this.types[ i ] == 'floater' ) {
	    	//alert( itemNameId );
	      str += '<td colspan="2"><a href="' + this.links[ i ] + pageInc + itemInc + itemNameInc + '" class="' + (itemId == this.items[ i ].id || unescape(itemNameId) == this.strs[ i ] ? 'navon' : 'subnav') + '"' + (isNav4 ? (itemId == this.items[ i ].id || unescape(itemNameId) == this.strs[ i ] ? 'style="font-family: verdana, arial, sans serif; font-size: 11px; color: #cc3333; text-decoration: none; font-weight: bold;"' : 'style="font-family: verdana, arial, sans serif; font-size: 11px; color: #0000000; text-decoration: none;"') : '') + ' id="link' + this.items[ i ].id + '" ' +
	             'onmouseover="' + (!this.navImg[ i ] || this.links[ i ] == thisFileName ? '' : 'navImageSwap(\'_navimg' + this.items[ i ].id + '\', \'images/nav/' + this.navImg[ i ] + '_on.gif\',\'' + this.items[ i ].id + '\')') + ';showFloater(' + this.lists[ i ].id + ',\'' + this.items[ i ].id + '\',' + d + ');clearTimeout( timeOverId );" ' +
	             'onmouseout="' + (!this.navImg[ i ] || this.links[ i ] == thisFileName ? '' : 'navImageSwap(\'_navimg' + this.items[ i ].id + '\', \'images/nav/' + this.navImg[ i ] + '_off.gif\',\'' + this.items[ i ].id + '\');') + 'timeOverId=timeOut();">' + (!this.navImg[ i ] ? this.strs[ i ] : '<img src="images/nav/' + this.navImg[ i ] + '_' + (this.links[ i ] == thisFileName ? 'on' : 'off') + '.gif" name="_navimg' + this.items[ i ].id + '" id="_navimg' + this.items[ i ].id + '" width="160" height="20" border="0">') + '</a></td>';
			} else if( this.types[ i ] == 'html' ) {
				str += '<td colspan="2">' + this.strs[ i ] + '</td>';
			} 	
	
	    str += '</tr></table>\n';
	
	    if( isNav4 ) {
	      layer.document.writeln( str );
	      layer.document.close();
	    } else {
	      layer.innerHTML = str;
	    }
	
	    if( this.types[ i ] == "list" && this.lists[ i ].visible ) {
	      this.lists[ i ]._writeList( 1 );
	    }
	  }
	
	  this.built = true;
	  this.needsRewrite = false;
	
	  self.status = '';
	}
	
	function _showList() {
	  var layer;
	
	  for( var i = 0; i < this.types.length; i++ ) {
	    layer = this.items[ i ];
	
	    setClip(layer, 0, (this.w[ i ] ? this.w[ i ] : this.width), 0, (this.h[ i ] ? this.h[ i ] : this.height - 1) );
	
	    if(isIE4 || isNav6) {
	      if( layer.oBgColor ) {
	        layer.style.backgroundColor = layer.oBgColor;
	      } else {
	        layer.style.backgroundColor = this.bgColor;
	      }
	    } else {
	      if( layer.oBgColor ) {
	        layer.document.bgColor = layer.oBgColor;
	      } else {
	        layer.document.bgColor = this.bgColor;
	      }
	    }
	
	    if(this.types[ i ] == 'list' && this.lists[ i ].visible) {
	      this.lists[ i ]._showList();
	    }
	  }
	
	  this.shown = true;
	  this.needsUpdate = false;
	}
	
	function _updateList( pVis, x, y ) {
	  var currTop = y, layer;
	
	  for(var i = 0; i < this.types.length; i++) {
	    layer = this.items[i];
	
	    if( this.visible && pVis ) {
	      if( isNav4 ) {
	        layer.visibility = "visible";
	        layer.top = currTop;
	        layer.left = x;
	      } else if( isIE4 ) {
	        layer.style.visibility = "visible";
	        layer.style.pixelTop = currTop;
	        layer.style.pixelLeft = x;
	      } else if( isNav6 ) {
	        layer.style.visibility = "visible";
	        layer.style.top = currTop + "px";
	        layer.style.left = x + "px";
	      }
	      
	    	currTop += this.height;
	    } else {
	      if( isNav4 ) {
	        layer.visibility = "hidden";
	      } else {
	        layer.style.visibility = "hidden";
	      }
	    }
	
	    if( this.types[i] == 'list' ) {
	      if( this.lists[i].visible ) {
	        if( !this.lists[i].built || this.lists[ i ].needsRewrite ) {
	          this.lists[ i ]._writeList( 1 );
	        }
	
	        if( !this.lists[ i ].shown || this.lists[ i ].needsUpdate ) {
	          this.lists[ i ]._showList();
	        }
	      }
	      if( this.lists[ i ].built ) {
	        currTop = this.lists[ i ]._updateList(this.visible && pVis, x + 10, currTop  );
	      }
	    }
	  }
	  
	  return currTop;
	}
	
	function _updateParent( pid, l ) {
	  var layer;
	
	  this.l = ( !l ? 0 : l );
	  this.pid = pid;
	
	  for( var i = 0; i < this.types.length; i++ ) {
	    if( this.types[ i ] == 'list' ) {
	      this.lists[ i ]._updateParent( pid, (l + 1) );
	    }
	  }
	}
	
	function expand( i ) {
	  var itemIndex = 0, lastList = 0, thisItemId = false, thisListId = false;
	  var pObj = _mLists[ _mLists[ 0 ].pid ];
	  var rootObj = _mLists[ 0 ];
	
	  for( typeIndex in _mLists[ _mLists[ i ].pid ].types ) {
	    if( _mLists[ _mLists[ i ].pid ].types[ typeIndex ] == 'list' ) {
	      if( ++itemIndex == i ) {
	      	thisItemId = _mLists[ _mLists[ i ].pid ].items[ typeIndex ].id;
	  		}
	
			  if( rootObj.lastList != 0 ) {
			    _mLists[ rootObj.lastList ].visible = false;
			    _mLists[ _mLists[ rootObj.lastList ].pid ].rebuild();
			  }
			
			  if( i != rootObj.lastList ) {
			    _mLists[i].visible = !_mLists[i].visible;
			
			    if( _mLists[i].onexpand != null ) _mLists[ i ].onexpand( _mLists[ i ].id );
			    _mLists[ _mLists[ i ].pid ].rebuild();
			    if( _mLists[ i ].postexpand != null ) _mLists[ i ].postexpand( _mLists[ i ].id );
			
			    lastList = i;
			  }
			
			  rootObj.lastList = lastList;
	
	    }
	  }
	}
	
	function showFloater( i, itemId, expandId ) {
	  var itemIndex = 0, lastList = 0, thisItemId = false, thisListId = false;
	  var pObj = _mLists[ _mLists[ 0 ].pid ];
	  var rootObj = _mLists[ 0 ];
		var pItemId = passedPageId = null;
	  
	 	if( window.top.location.search != 0 ) {
			passedPageId = getParameter( window.top.location.search, 'page' );
			pItemId = getParameter( window.top.location.search, 'pId' );
		}
	
		if( isIE4 || isNav6 ) {
			divId = document.getElementById( 'floater' );
		} else if( isNav4 ) {
			divId = document.layers[ 'floater' ];
		}
		
		if( isIE4 || isNav6 ) {
			divId.style.visibility = "hidden";
		} else if( isNav4 ) {
			divId.visibility = 'hidden';
		}
	
<?	$parseU = parse_url( $_SERVER[ "HTTP_REFERER" ] );
		$thisPage = basename( $parseU[ "path" ] );
		
		$parentResult = $db->query( "select file_name, parent_page_id ".
		                            "  from pages ".
		                            " where file_name = '$thisPage'" );
		                            
		if( $db->numRows( $parentResult ) ) {
			list( $realFileName, $pPageId ) = $db->fetchRow( $parentResult );
			
			while( $pPageId != 0 ) {
				$realResult = $db->query( "select file_name, parent_page_id ".
				                          "  from pages ".
				                          " where page_id = '$pPageId'" );
				if( $db->numRows( $realResult ) ) {
					list( $thisFileName, $pPageId ) = $db->fetchRow( $realResult );
					if( $pPageId != 0 ) {
						$realFileName = $thisFileName;
					}
				}
			}	?>		
			
			thisFileName = '<?= $realFileName; ?>';
<?	}	?>
	
		
		divCont = '<table border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td colspan="3"><img src="images/universal/spacer.gif" height="3" width="1"></td></tr>' +
	            '<tr><td><img src="images/universal/spacer.gif" height="1" width="15"></td><td>';
	            
		for( strIndex in _mLists[ i ].strs ) {
			divCont += '<p style="padding: 1px 0px 5px 0px; margin: 0px 0px 0px 0px; background-color: #ffffff;"><a href="' + _mLists[ i ].links[ strIndex ] + (passedPageId == expandId ? '&page=' + passedPageId : '') + (passedPageId == expandId ? '&pId=' + itemId : '') + '" target="' + (_mLists[ i ].target[ strIndex ] ? _mLists[ i ].target[ strIndex ] : '_self') + '" ' + (isNav4 ? 'style="font-family: verdana, arial; font-size: 11px; text-decoration: none; color: #000000;"' : 'class="' + (thisFileName == _mLists[ i ].links[ strIndex ] ? 'navon' : 'subnav') + '"') + '>' + _mLists[ i ].strs[ strIndex ] + '</a></p>';
		}
	
		divCont += '</td><td><img src="images/universal/spacer.gif" height="1" width="15"></td></tr><tr><td colspan="3"><img src="images/universal/spacer.gif" height="3" width="1"></td></tr></table>';
		
		subMenu = '<table border="0" cellspacing="0" cellpadding="0">' +
		          '<tr><td valign="top"><img src="images/nav/submenu_ext.gif" width="17" height="29"></td>' +
		          '<td><table border="0" cellpadding="0" cellspacing="0" width="124">' +
		          '<tr><td><img src="images/universal/spacer.gif" width="1" height="1"></td><td><img src="images/universal/spacer.gif" width="122" height="1"></td><td><img src="images/universal/spacer.gif" width="1" height="1"></td></tr>' +
		          '<tr><td colspan="3"><img src="images/nav/submenu_top.gif" width="124" height="6"></td></tr>' +
		          '<tr><td style="background-color: #ffcd00;" valign="top"><img src="images/nav/submenu_opening.gif" width="1" height="22"></td>' +
		          '<td>' + divCont + '</td>' +
		          '<td style="background-color: #ffcd00;"><img src="images/universal/spacer.gif" width="1" height="1"></td></tr>' +
		          '<tr><td colspan="3"><img src="images/nav/submenu_bottom.gif" width="124" height="6"></td></tr>' +
		          '</table></td></tr></table>';
	
		var imId = ( isNav4 ? document.layers[ itemId ] : document.getElementById( 'link' + itemId ) );
		var imagePos = getRealXY( imId, 'link' + itemId );	   
	
	  if( isNav4 ) {
	  	divId.top = imagePos.y - 12;
	  	divId.left = imagePos.x + 87;
	
	    divId.document.writeln( subMenu );
	    divId.document.close();
	    divId.zIndex = 5;
	  	divId.visibility = "visible";
	  	
	  	document.layers[ 'floater' ].document.captureEvents( Event.MOUSEOVER | Event.MOUSEOUT );
	  	document.layers[ 'floater' ].document.onmouseover = function( e ) {
	  		clearTimeout( timeOverId );
	  		routeEvent( e );
	  	}
	  	
	  	document.layers[ 'floater' ].document.onmouseout = function( e ) {
	  		timeOverId = timeOut( timeOverId );
	  		routeEvent( e );
	  	}
	  } else {
	  	divId.style.top = (imagePos.y - 14) + 'px';
	  	divId.style.left = (imagePos.x + 91) + 'px';
	  	
	    divId.innerHTML = subMenu;
	  	divId.style.visibility = "visible";
	  }
	}
	
	function resetNav( selectedStyle ) {
	  var styleIdx = 0;
	  
	  for( var anchIds = 0; anchIds < document.anchors.length; anchIds++ ) {
	    for( var argIdx = 1; argIdx < arguments.length; argIdx++ ) {
	      if( document.anchors[ anchIds ].id != arguments[ argIdx ] ) {
	        document.anchors[ anchIds ].className = 'nav';
	      }
	    }
	  }
	    
	  for( var anchIds = 0; anchIds < document.anchors.length; anchIds++ ) {      
	    for( var argIdx = 1; argIdx < arguments.length; argIdx++ ) {
	      if( document.anchors[ anchIds ].id == arguments[ argIdx ] ) {
	        document.anchors[ anchIds ].className = ( document.anchors[ anchIds ].className == 'nav' ? selectedStyle[ styleIdx++ ] : 'nav' );
	      }
	    }
	  }
	}
	
	function build( x, y ) {
	  this._updateParent( this.id );
	  this._writeList( 0 );
	  this._showList();
	  this._updateList( true, x, y );
	  this.x = x;
	  this.y = y;
	}
	
	function rebuild( passX, passY ) {
	  this._updateList( true, (passX ? passX : this.x), (passY ? passY : this.y) );
	}
	
	function setActiveItem( navId ) {
	  if( navId ) {
	  	expand( navId );
	  }
	}
	
	function addItem( str, navImg, itemLink, isFloater, target, layer ) {
	  var testLayer = false;
	
	  if( !document.all ) {
	    document.all = document.layers;
	  }
	
	  if( !layer && !isFloater ) {
	    if( isIE4 ) {
	    	if( !this.parLayer ) {
	      	testLayer = eval( 'document.all.lItem' + _lid );
	      }
	
	  	} else if( isNav6 ) {
	      if( !this.parLayer ) {
	        testLayer = document.getElementById( 'lItem' + _lid );
	      }
	    } else {
	      if( this.parLayer ) {
	        _pLayer = this.parLayer;
	        testLayer = eval( '_pLayer.document.layers.lItem' + _lid );
	      }
	    }
	
	    if( testLayer ) {
	      layer = testLayer;
	    } else {
	      if( isNav4 ) {
	        if( this.parLayer ) {
	          layer = new Layer( this.width, this.parLayer );
	        } else {
	          layer = new Layer( this.width );
	        }
	      } else {
	        return;
	      }
	    }
	
		  _lid++;
	  }
	
	  this.items[ this.items.length ]   = layer;
	  this.types[ this.types.length ]   = "item";
		this.navImg[ this.navImg.length ] = navImg;
		this.target[ this.strs.length ]   = target;
	  this.strs[ this.strs.length ]     = str;
	  this.links[ this.links.length ]   = itemLink;
	}
	
	function addHTML( str, h, w, layer ) {
	  var testLayer = false;
	
	  if( !document.all ) {
	    document.all = document.layers;
	  }
	
	  if( !layer ) {
	    if( isIE4 ) {
	    	if( !this.parLayer ) {
	      	testLayer = eval( 'document.all.lItem' + _lid );
	      }
	
	  	} else if( isNav6 ) {
	      if( !this.parLayer ) {
	        testLayer = document.getElementById( 'lItem' + _lid );
	      }
	    } else {
	      if( this.parLayer ) {
	        _pLayer = this.parLayer;
	        testLayer = eval( '_pLayer.document.layers.lItem' + _lid );
	      }
	    }
	
	    if( testLayer ) {
	      layer = testLayer;
	    } else {
	      if( isNav4 ) {
	        if( this.parLayer ) {
	          layer = new Layer( this.width, this.parLayer );
	        } else {
	          layer = new Layer( this.width );
	        }
	      } else {
	        return;
	      }
	    }
	
		  _lid++;
	  }
	
	
	
	  this.items[ this.items.length ] = layer;
	  this.types[ this.types.length ] = "html";
	  this.h[ this.strs.length ]      = h;
	  this.w[ this.strs.length ]      = w;
	  this.strs[ this.strs.length ]   = str;
	}
	
	function addList(list, str, navImg, itemLink, layer) {
	  var testLayer = false;
	
	  if( !document.all ) {
	    document.all = document.layers;
	  }
	
	  if( !layer ) {
	    if( isNav6 ) {
	    	testLayer = document.getElementById( 'lItem' + _lid );
	    } else if( isIE4 || !this.parLayer ) {
	      testLayer = eval( 'document.all.lItem' + _lid );
	    } else if( isNav4 ) {
	      _pLayer = this.parLayer;
	      testLayer = eval( '_pLayer.document.layers.lItem' + _lid );
	    }
	
	    if( testLayer ) {
	      layer = testLayer;
	    } else {
	      if( isNav4 ) {
	        if( this.parLayer ) {
	          layer = new Layer( this.width, this.parLayer );
	        } else {
	          layer = new Layer( this.width );
	        }
	      } else {
	        return;
	      }
	    }
	  }
	
	  this.lists[ this.items.length ] = list;
	  this.items[ this.items.length ] = layer;
	  this.types[ this.types.length ] = "list";
	  this.navImg[ this.navImg.length ] = navImg;
	  this.strs[ this.strs.length ]   = str;
	  this.links[ this.links.length ] = itemLink;
	  list.parent = this;
	  _lid++;
	}
	
	function addFloater( list, str, navImg, itemLink, layer ) {
	  var testLayer = false;
	
	  if( !document.all ) {
	    document.all = document.layers;
	  }
	
	  if( !layer ) {
	    if( isNav6 ) {
	    	testLayer = document.getElementById( 'lItem' + _lid );
	    } else if( isIE4 || !this.parLayer ) {
	      testLayer = eval( 'document.all.lItem' + _lid );
	    } else {
	      _pLayer = this.parLayer;
	      testLayer = eval( '_pLayer.document.layers.lItem' + _lid );
	    }
	
	    if(testLayer) {
	      layer = testLayer;
	    } else {
	      if( isNav4 ) {
	        if( this.parLayer ) {
	          layer = new Layer( this.width, this.parLayer );
	        } else {
	          layer = new Layer( this.width );
	        }
	      } else {
	        return;
	      }
	    }
	  }
	
	  this.lists[ this.items.length ] = list;
	  this.items[ this.items.length ] = layer;
	  this.types[ this.types.length ] = 'floater';
	  this.navImg[ this.strs.length ] = navImg;
	  this.strs[ this.strs.length ]   = str;
	  this.links[ this.links.length ] = itemLink;
	  list.parent = this;
	  _lid++;
	}
	
	function getRealXY( imgElem, imgID ) {
		var xyObj = new Object()
			
		if( isIE4 || isNav6 ) {
			xPos = eval( imgElem ).offsetLeft;
			tempEl = eval( imgElem ).offsetParent;
	
	  	while( tempEl != null ) {
	  		xPos += tempEl.offsetLeft;
	  		tempEl = tempEl.offsetParent;
	  	}
	
			yPos = eval( imgElem ).offsetTop;
			tempEl = eval( imgElem ).offsetParent;
	
			while( tempEl != null ) {
	  		yPos += tempEl.offsetTop;
	  		tempEl = tempEl.offsetParent;
	  	}
	
			xyObj.x = xPos;
			xyObj.y = yPos;
		} else if( isNav4 ) {
		  xyObj.x = imgElem.x
		  xyObj.y = imgElem.y
		}
		
		return( xyObj );
	}
	
	function timeOut( timeId ) {
		divC = ( isIE4 || isNav6 ? "document.getElementById( 'floater' ).style.visibility='hidden'" : "document.layers[ 'floater' ].visibility='hidden'" );
	
		return setTimeout( divC, 800 );
	}
