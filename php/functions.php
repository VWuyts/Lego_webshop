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
	 *			 cssArray: array of strings; additional css files to be loaded
	 *			 script: string; JavaScript initialise function, null if to be omitted
	 */
	function createHead($inDirPhp, $title, $cssArray, $scriptArray)
	{
		$dir = "";
		if ($inDirPhp) $dir = "../";
		echo("<!doctype html>\n");
		echo("<html>\n");
		echo("<head>\n");
		echo("\t<meta charset=\"utf-8\">\n");
		echo("\t<title>$title</title>\n");
		echo("\t<link href=\"". $dir ."favicon.ico\" rel=\"icon\" type=\"image/ico\" />\n");
		echo("\t<link href=\"". $dir ."stylesheets/reset_v2.css\" rel=\"stylesheet\" type=\"text/css\" />\n");
		echo("\t<link href=\"". $dir ."stylesheets/legoshop.css\" rel=\"stylesheet\" type=\"text/css\" />\n");
		for ($i = 0; $i < count($cssArray); $i++)
		{
			echo("\t<link href=\"". $dir ."stylesheets/". $cssArray[$i] .".css\" rel=\"stylesheet\" type=\"text/css\" />\n");
		}
		echo("\t<script src=\"". $dir ."js/legoshop.js\"></script>\n");
		for	($i = 0; $i < count($scriptArray); $i++)
		{
			echo("\t<script src=\"". $dir ."js/". $scriptArray[$i] .".js\"></script>\n");
		}
		echo("</head>\n\n");
		echo("<body  onLoad=\"initialise();\">\n");
		echo("<div id=\"wrapper\">\n");
    }//end createHead
    
    /*
	 * Function createHeader creates the default Lego webshop header division.
	 * Parameter user: string; the user that is logged in or null if no user is logged in
	 *			 inDirPhp: boolean; is the script calling the function located in the php folder
	 */
	function createHeader($inDirPhp, $user)
	{
		$dir = "";
		if (!$inDirPhp) $dir = "../php/";
		echo("\t<header>\n");
		echo("\t\t<div id=\"topbar\">\n");
		echo("\t\t\t<div class=\"center\">\n");
		echo("\t\t\t\t<div id=\"topmenubar\">\n");
		echo("\t\t\t\t\t<ul id=\"topmenu\">\n");
		if (is_null($user))
		{
			echo("\t\t\t\t\t\t<li><a href=\"". ($inDirPhp ? "" : "php/") ."login.php\">Log on</a></li>\n");
		}
		else
		{
			echo("\t\t\t\t\t\t<li id=\"nojs\"><a href=\"". ($inDirPhp ? "" : "php/") ."shoppingBag.php\">Shopping bag</a></li>\n");
			echo("\t\t\t\t\t\t<li><a href=\"\">Account</a>\n");
			echo("\t\t\t\t\t\t\t<ul>\n");
			echo("\t\t\t\t\t\t\t\t<li><a href=\"". ($inDirPhp ? "" : "php/") ."account.php\">$user</a></li>\n");
			echo("\t\t\t\t\t\t\t\t<li><a href=\"". ($inDirPhp ? "" : "php/") ."orderStatus.php\">Order status</a></li>\n");
			echo("\t\t\t\t\t\t\t</ul>\n");
			echo("\t\t\t\t\t\t</li>\n");
		}
		echo("\t\t\t\t\t</ul>\n");
		echo("\t\t\t\t</div>\n");
		echo("\t\t\t\t<a href=\"https://www.lego.com/\" title=\"To LEGO.com\" target=\"_blank\">\n");
		echo("\t\t\t\t\t<img id=\"redbrick\" src=\"". ($inDirPhp ? "../" : "") ."images/redBrick.png\" alt=\"red brick\" />\n");
		echo("\t\t\t\t\t<span id=\"legocom\">LEGO.COM</span>\n");
		echo("\t\t\t\t</a>\n");

		echo("\t\t\t\t<p class=\"spacer\"></p>\n");
		echo("\t\t\t</div>\n");
		echo("\t\t</div> <!-- end topbar -->\n");
		echo("\t\t<div id=\"menu\">\n");
		echo("\t\t\t<div class=\"center\">\n");
		echo("\t\t\t\t<a id=\"legoshop\" href=\"". ($inDirPhp ? "../" : "") ."index.php\" title=\"Home\">\n");
		echo("\t\t\t\t\t<img id=\"shoplogo\" src=\"". ($inDirPhp ? "../" : "") ."images/lego-logo.svg\" alt=\"logo Lego\" />\n");
		echo("\t\t\t\t\t<span id=\"shop\">SHOP</span>\n");
		//echo("\t\t\t\t\t<p class=\"spacer\"></p>\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t</div>\n");
		echo("\t\t\t<p class=\"spacer\"></p>\n");
		echo("\t\t</div> <!-- end menu -->\n");        
		echo("\t</header>\n\n");
		echo("\t<div id=\"content\">\n");
	}//end createHeader

    /*
	 * Function createFooter creates the default MiQUBase footer.
	 * Parameter inDirPhp: boolean; is the script calling the function located in the php folder
	 */
	function createFooter($inDirPhp)
	{
		echo("\t</div> <!--end content-->\n\n");
		echo("\t<footer>\n");
		echo("\t\t<div class=\"center\">\n");
		echo("\t\t\t<div id=\"footerright\">\n");
		echo("\t\t\t\t<a href=\"http://www.thomasmore.be/\" title=\"to Thomas More homepage\" target=\"_blank\">\n");
		echo("\t\t\t\t\t<img id=\"logotm\" src=\"". ($inDirPhp ? "../" : "") ."images/tm_vignet_web.png\" alt=\"logo Thomas More\" />\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<p>Copyright &copy; 2017 V&eacute;ronique Wuyts</p>\n");
		echo("\t\t\t\t<p>Professionele Bachelor Elektronica-ICT</p>\n");
		echo("\t\t\t\t<p>Thomas More Mechelen-Antwerpen vzw &ndash; Campus De Nayer</p>\n");
		echo("\t\t\t</div>\n");
		echo("\t\t\t<div id=\"footercenter\">\n");
		echo("\t\t\t\t<a href=\"https://www.lego.com\" title=\"To LEGO.com\" target=\"_blank\">\n");
		echo("\t\t\t\t\t<img id=\"logolego\" src=\"". ($inDirPhp ? "../" : "") ."images/lego-logo.svg\" alt=\"logo Lego\" />\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<p>Last update 16-11-2017</p>\n");
		echo("\t\t\t</div>\n");
		echo("\t\t\t<p class=\"spacer\"></p>\n");
		echo("\t\t</div>\n");
		echo("\t</footer>\n");
		echo("</div>\n");
		echo("</body>\n");
		echo("</html>\n");
	}//end createFooter
?>
