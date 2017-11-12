<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 */

    $lastUpdate = "12-11-2017";

    /*
	 * Function createHead creates the default Lego webshop HTML head.
	 * Parameter inDirPhp: boolean; is the script calling the function located in the php or message folder
	 * 			 title: string; title for the HTML page
	 *			 cssArray: array of strings; additional css files to be loaded
	 *			 script: string; JavaScript initialise function, null if to be omitted
	 */
	function createHead($inDirPhp, $title, $cssArray, $script)
	{
		$dir = "";
		if ($inDirPhp) $dir = "../";
		echo("<!doctype html>\n");
		echo("<html>\n");
		echo("<head>\n");
		echo("\t<meta charset=\"utf-8\">\n");
		echo("\t<title>$title</title>\n");
		echo("\t<link href=\"".$dir."favicon.ico\" rel=\"icon\" type=\"image/ico\" />\n");
		echo("\t<link href=\"".$dir."stylesheets/reset_v2.css\" rel=\"stylesheet\" type=\"text/css\" />\n");
		echo("\t<link href=\"".$dir."stylesheets/legoshop.css\" rel=\"stylesheet\" type=\"text/css\" />\n");
		for ($i = 0; $i < count($cssArray); $i++)
		{
			echo("\t<link href=\"".$dir."stylesheets/".$cssArray[$i].".css\" rel=\"stylesheet\" type=\"text/css\" />\n");
		}
		if (!is_null($script))
		{
			echo("\t<script>\n\t\tfunction initialise(){\n");
			echo($script);
			echo("\n\t\t}\n\t</script>\n");
		}
		echo("</head>\n\n");
		echo("<body");
		if (!is_null($script))
		{
			echo(" onLoad=\"initialise();\"");
		}
		echo(">\n<div id=\"wrapper\">\n");
    }//end createHead
    
    /*
	 * Function createHeader creates the default Lego webshop header division.
	 * Parameter user: string; the user that is logged in, null if no user is logged in, false if no user or links have to be shown
	 *			 inDirPhp: boolean; is the script calling the function located in the php folder
	 */
	function createHeader($user, $inDirPhp)
	{
		echo("\t<header>\n");
		$dir = "";
		if (!$inDirPhp) $dir = "../php/";
        // TO DO
        
		echo("\t\t<p class=\"spacer\"></p>\n");
		echo("\t</header>\n\n");
		echo("\t<div id=\"content\">\n");
	}//end createHeader


    /*
	 * Function createFooter creates the default MiQUBase footer.
	 * Parameter inDirPhp: boolean; is the script calling the function located in the php folder
	 */
	function createFooter($inDirPhp)
	{
        global $lastUpdate;
		echo("\t</div> <!--end content-->\n\n");
		echo( "\t<footer>\n");
		echo("\t\t<div id=\"footerright\">\n");
			if ($inDirPhp) echo("\t\t\t<img id=\"logotm\" src=\"../images/tm_vignet_web.png\" alt=\"logo Thomas More\" />\n");
			else echo("\t\t\t<a href=\"http://www.thomasmore.be/\" title=\"to Thomas More home page\"><img id=\"logotm\" src=\"images/tm_vignet_web.png\" alt=\"logo Thomas More\" /></a>\n");
			echo("\t\t\t<p>Copyright &copy; 2017 V&eacute;ronique Wuyts</p>\n");
			echo("\t\t\t<p>Professionele Bachelor Elektronica-ICT</p>\n");
			echo("\t\t\t<p>Thomas More Mechelen-Antwerpen vzw &ndash; Campus De Nayer</p>\n");
		echo("\t\t</div>\n");
		echo("\t\t<div id=\"footercenter\">\n");
			if ($inDirPhp) echo("\t\t\t<img id=\"logolego\" src=\"../images/lego-logo.svg\" alt=\"logo Lego\" />\n");
			else echo("\t\t\t<a href=\"https://www.lego.com\" title=\"To LEGO.com\"><img id=\"logolego\" src=\"images/lego-logo.svg\" alt=\"logo Lego\" /></a>\n");
			echo("\t\t\t<p>Last update $lastUpdate</p>\n");
		echo("\t\t</div>\n");
		echo("\t\t<p class=\"spacer\"></p>\n");
		echo("\t</footer>\n");
		echo("</div>\n");
		echo("</body>\n");
		echo("</html>\n");
	}//end createFooter

?>

