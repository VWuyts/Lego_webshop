<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 */

    /*
	 * Function createHead creates the default Lego webshop HTML head.
	 * Parameter inDirPhp: boolean; is the script calling the function located in the php or message folder
	 * 			 title: string; title for the HTML page
	 *			 cssArray: array of strings; additional css files to be loaded, null if to be omitted
	 *			 script: array of string; additional JavaScript files to be loaded, null if to be omitted
	 */
	function createHead($inDirPhp, $title, $cssArray, $scriptArray)
	{
		$dir = "";
		if ($inDirPhp) $dir = "../";
		echo("<!doctype html>\n");
		echo("<html>\n");
		echo("<head>\n");
		echo("\t<meta charset='utf-8'>\n");
		echo("\t<title>$title</title>\n");
		echo("\t<link href='". $dir ."favicon.ico' rel='icon' type='image/ico' />\n");
		echo("\t<link href='". $dir ."css/reset_v2.css' rel='stylesheet' type='text/css' />\n");
		echo("\t<link href='". $dir ."css/legoshop.css' rel='stylesheet' type='text/css' />\n");
		for ($i = 0; $i < count($cssArray); $i++)
		{
			echo("\t<link href='". $dir ."css/". $cssArray[$i] .".css' rel='stylesheet' type='text/css' />\n");
		}
		echo("\t<script src='". $dir ."js/legoshop.js'></script>\n");
		for	($i = 0; $i < count($scriptArray); $i++)
		{
			echo("\t<script src='". $dir ."js/". $scriptArray[$i] .".js'></script>\n");
		}
		echo("</head>\n\n");
		echo("<body  onLoad='initialise();'>\n");
		echo("<div id='wrapper'>\n");
    }//end createHead
    
    /*
	 * Function createHeader creates the default Lego webshop header division.
	 * Parameter user: string; the user that is logged in or null if no user is logged on
	 *			 inDirPhp: boolean; is the script calling the function located in the php folder
	 */
	function createHeader($inDirPhp, $user)
	{
		$dir = "";
		if (!$inDirPhp) $dir = "../php/";
		echo("\t<header>\n");
		echo("\t\t<div id='topbar'>\n");
		echo("\t\t\t<div class='center'>\n");
		echo("\t\t\t\t<div id='topmenubar'>\n");
		echo("\t\t\t\t\t<ul id='topmenu'>\n");
		if (is_null($user))
		{
			echo("\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t<img src='". ($inDirPhp ? "../" : "") ."images/lego-head.png' alt='Lego head' />\n");
			echo("\t\t\t\t\t\t\t<a href=''>Account</a>\n");
			echo("\t\t\t\t\t\t\t<ul>\n");
			echo("\t\t\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t\t\t<p class='lightGrey textCenter'>Sign in to your Lego account</p>\n");
			echo("\t\t\t\t\t\t\t\t\t<form action='#'>\n");
			echo("\t\t\t\t\t\t\t\t\t\t<input id='loginBtn' type='button' onClick='showLogin();' value='Sign in' />\n");
			echo("\t\t\t\t\t\t\t\t\t</form>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t\t\t<p class='lightGrey textCenter'>Don't have an account?</p>\n");
			echo("\t\t\t\t\t\t\t\t\t<a class='textCenter' href='". ($inDirPhp ? "" : "php/") ."register.php'>Register</a>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t\t</ul>\n");
			echo("\t\t\t\t\t\t</li>\n");
		}
		else
		{
			// TO DO: add number of items to shopping bag
			echo("\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t<img src='". ($inDirPhp ? "../" : "") ."images/lego-bag.png' alt='Lego shopping bag' />\n");
			echo("\t\t\t\t\t\t\t<a href='". ($inDirPhp ? "" : "php/") ."shoppingBag.php'>Shopping bag</a>\n");
			echo("\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t<img src='". ($inDirPhp ? "../" : "") ."images/lego-head.png' alt='Lego head' />\n");
			echo("\t\t\t\t\t\t\t<a href=''>Account</a>\n");
			echo("\t\t\t\t\t\t\t<ul>\n");
			echo("\t\t\t\t\t\t\t\t<li>");
			echo("\t\t\t\t\t\t\t<img id='ninja' src='". ($inDirPhp ? "../" : "") ."images/lego-ninja.png' alt='Lego Ninja figure' />\n");
			echo("\t\t\t\t\t\t\t\t\t<p>$user</p>\n");
			echo("\t\t\t\t\t\t\t\t\t<a href='". ($inDirPhp ? "" : "php/") ."account.php'>View your Lego account</a>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t\t\t<img id='truck' src='". ($inDirPhp ? "../" : "") ."images/lego-order-status.svg' alt='Lego truck' />\n");
			echo("\t\t\t\t\t\t\t\t\t<a href='". ($inDirPhp ? "" : "php/") ."orderStatus.php'>Check order status</a>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t\t</ul>\n");
			echo("\t\t\t\t\t\t</li>\n");
		}
		echo("\t\t\t\t\t</ul>\n");
		echo("\t\t\t\t</div>\n");
		echo("\t\t\t\t<a href='https://www.lego.com/' title='To LEGO.com' target='_blank'>\n");
		echo("\t\t\t\t\t<img id='redBrick' src='". ($inDirPhp ? "../" : "") ."images/redBrick.png' alt='red brick' />\n");
		echo("\t\t\t\t\t<span id='legocom'>LEGO.COM</span>\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<p class='spacer'></p>\n");
		echo("\t\t\t</div> <!-- end center -->\n");
		echo("\t\t</div> <!-- end topbar -->\n");
		echo("\t\t<div id='menu'>\n");
		echo("\t\t\t<div class='center'>\n");
		echo("\t\t\t\t<div id='searchdiv'>\n");
		
		echo("\t\t\t\t</div>\n");
		echo("\t\t\t\t<a id='legoshop' href='". ($inDirPhp ? "../" : ".") ."' title='Home'>\n");
		echo("\t\t\t\t\t<img id='shoplogo' src='". ($inDirPhp ? "../" : "") ."images/lego-logo.svg' alt='logo Lego' />\n");
		echo("\t\t\t\t\t<span id='shop'>SHOP</span>\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<div id='links'>\n");
		echo("\t\t\t\t\t<form action='home.php' method='post'>\n");
		echo("\t\t\t\t\t\t<input class='linkBtn' type='submit' name='sets' value='SETS' />\n");
		echo("\t\t\t\t\t\t<input class='linkBtn' type='submit' name='exclusives' value='EXCLUSIVES' />\n");
		echo("\t\t\t\t\t\t<input class='linkBtn' type='submit' name='hardToFind' value='HARD TO FIND' />\n");
		echo("\t\t\t\t\t\t<input class='linkBtn' type='submit' name='extras' value='EXTRAS'>\n");
		echo("\t\t\t\t\t</form>\n");
		echo("\t\t\t\t</div> <!-- end links -->\n");
		echo("\t\t\t<p class='spacer'></p>\n");
		echo("\t\t\t</div> <!-- end center -->\n");
		echo("\t\t</div> <!-- end menu -->\n");        
		echo("\t</header>\n\n");
		echo("\t<div id='content'>\n");
	}//end createHeader

    /*
	 * Function createFooter creates the default Lego webshop footer.
	 * Parameter inDirPhp: boolean; is the script calling the function located in the php folder
	 */
	function createFooter($inDirPhp)
	{
		echo("\t</div> <!--end content-->\n\n");
		echo("\t<footer>\n");
		// TO DO: add grey part of footer
		echo("\t\t<div class='center'>\n");
		echo("\t\t\t<div id='footerright'>\n");
		echo("\t\t\t\t<a href='http://www.thomasmore.be/' title='to Thomas More homepage' target='_blank'>\n");
		echo("\t\t\t\t\t<img id='logotm' src='". ($inDirPhp ? "../" : "") ."images/tm_vignet_web.png' alt='logo Thomas More' />\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<p>Copyright &copy; 2017 V&eacute;ronique Wuyts</p>\n");
		echo("\t\t\t\t<p>Professionele Bachelor Elektronica-ICT</p>\n");
		echo("\t\t\t\t<p>Thomas More Mechelen-Antwerpen vzw &ndash; Campus De Nayer</p>\n");
		echo("\t\t\t</div>\n");
		echo("\t\t\t<div id='footercenter'>\n");
		echo("\t\t\t\t<a href='https://www.lego.com' title='To LEGO.com' target='_blank'>\n");
		echo("\t\t\t\t\t<img id='logolego' src='". ($inDirPhp ? "../" : "") ."images/lego-logo.svg' alt='logo Lego' />\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<p>Last update 23-11-2017</p>\n");
		echo("\t\t\t</div>\n");
		echo("\t\t\t<p class='spacer'></p>\n");
		echo("\t\t</div> <!-- end red part of footer -->\n");
		echo("\t</footer>\n");
		echo("</div>\n");
		echo("</body>\n");
		echo("</html>\n");
	}//end createFooter
?>
