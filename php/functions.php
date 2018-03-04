<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Global functions
 */

	/* Function cleanInput cleans user input for protection against html injection.
	 * Parameter input:	string; the user input to be cleaned
	 */
	function cleanInput($input)
	{
		return htmlspecialchars(trim($input));
	}

	/*
	 * Function create Errorpage creates the default Legoshop error page and redirects to this page.
	 * Parameter messageArray: array of strings; message(s) to be displayed on the error page, cannot be NULLL
	 */
	function createErrorPage($messageArray)
	{
		$content = "<?php\n";
		$content .= "/* Lego Webshop\n";
		$content .= " *\n";
		$content .= " * Lab assignment for course PHP & MySQL 2017\n";
		$content .= " * Thomas More campus De Nayer\n";
		$content .= " * Bachelor Elektronica-ICT -- Application Development\n";
		$content .= " *\n";
		$content .= " * Véronique Wuyts\n";
		$content .= " *\n";
		$content .= " * Error page\n";
		$content .= " */\n\n";
		$content .= "require '../php/functions.php';\n";
		$content .= "createHead(false, 'Legoshop | error', ['message'], ['message']);\n";
		$content .= "createHeader(false, NULL, false);\n";
		$content .= "?>\n";
		$content .= "\t<div class='center'>\n";
		for ($i = 0; $i < count($messageArray); $i++)
		{
			$content .= "\t\t<p class='message'>". $messageArray[$i] ."</p>\n";
		}
		$content .= "\t\t<p class='message'>You will be redirected to the home page.</p>\n";
		$content .= "\t\t<p><a href='../index.php'>Back to home page</a></p>\n";
		$content .= "\t</div> <!-- end center -->\n";
		$content .= "<?php\n";
		$content .= "createFooter(false);\n";
		$content .= "?>\n";
		$path = (basename(getcwd()) == "Lego_webshop" ? "" : "../");
		file_put_contents($path ."message/error.php", $content);
		header("Location: ". $path ."message/error.php");
	} // end function createErrorPage

	/* 
	 * Function createMessagePage creates the default Legoshop message page and redirects to this page.
	 * Parameter messageArray: array of strings; message(s) to be displayed on the message page, cannot be NULL
	 * 			 user: string; the user which is logged on or null if no user is logged on
	 * 			 isAdmin: boolean; has the logged on user access to the admin pages
	 *			 php: string; the php page that is referenced in the link button
	 *			 button: string: the value of the link button
	 */
	function createMessagePage($messageArray, $user, $isAdmin, $php, $button)
	{
		$content = "<?php\n";
		$content .= "/* Lego Webshop\n";
		$content .= " *\n";
		$content .= " * Lab assignment for course PHP & MySQL 2017\n";
		$content .= " * Thomas More campus De Nayer\n";
		$content .= " * Bachelor Elektronica-ICT -- Application Development\n";
		$content .= " *\n";
		$content .= " * Véronique Wuyts\n";
		$content .= " *\n";
		$content .= " * Message page\n";
		$content .= " */\n\n";
		$content .= "require '../php/functions.php';\n";
		$content .= "createHead(false, 'Legoshop | message', ['message'], NULL);\n";
		$content .= "createHeader(false, ". (is_null($user) ? "NULL" : "$user") .", ".
			($isAdmin ? "true" : "false").");\n";
		$content .= "?>\n";
		$content .= "\t<div class='center'>\n";
		for ($i = 0; $i < count($messageArray); $i++)
		{
			$content .= "\t\t<p class='message'>". $messageArray[$i] ."</p>\n";
		}
		$content .= "\t\t<p><a href='$php'>$button</a></p>\n";
		$content .= "\t</div> <!-- end center -->\n";
		$content .= "<?php\n";
		$content .= "createFooter(false);\n";
		$content .= "?>\n";
		$path = (basename(getcwd()) == "Lego_webshop" ? "" : "../");
		file_put_contents($path ."message/message.php", $content);
		header("Location: ". $path ."message/message.php");
	} // end function createMessagePage

	/* 
	 * Function createHead creates the default Lego webshop HTML head.
	 * Parameter inDirPhp: false  = the script calling the function is located in the message folder
	 * 					   true = the script calling the function is located in the php folder
	 * 					   NULL  = the script calling the function is index.php
	 * 			 title: string; title for the HTML page
	 *			 cssArray: array of strings; additional css files to be loaded, null if to be omitted
	 *			 script: array of string; additional JavaScript files to be loaded, null if to be omitted
	 */
	function createHead($inDirPhp, $title, $cssArray, $scriptArray)
	{
		$dir = is_null($inDirPhp) ? "" : "../";
		echo("<!doctype html>\n");
		echo("<html lang='en'>\n");
		echo("<head>\n");
		echo("\t<meta charset='utf-8'>\n");
		echo("\t<title>$title</title>\n");
		echo("\t<link href='". $dir ."favicon.ico' rel='icon' type='image/ico' />\n");
		echo("\t<link href='". $dir ."css/reset_v2.css' rel='stylesheet' type='text/css' />\n");
		echo("\t<link href='". $dir ."css/legoshop.css' rel='stylesheet' type='text/css' />\n");
		if (!is_null($cssArray)) // required for php 7.2
		{
			for ($i = 0; $i < count($cssArray); $i++)
			{
				echo("\t<link href='". $dir ."css/". $cssArray[$i] .".css' rel='stylesheet' type='text/css' />\n");
			}
		}
		echo("\t<script src='". $dir ."js/legoshop.js'></script>\n");
		if (!is_null($scriptArray)) // required for php 7.2
		{
			for	($i = 0; $i < count($scriptArray); $i++)
			{
				echo("\t<script src='". $dir ."js/". $scriptArray[$i] .".js'></script>\n");
			}
		}
		echo("</head>\n\n");
		echo("<body  onLoad='initialise();'>\n");
		echo("<div id='wrapper'>\n");
    } // end function createHead
    
	/* 
	 * Function createHeader creates the default Lego webshop header division.
	 * Parameter inDirPhp: true  = the script calling the function is located in the php folder
	 * 					   false = the script calling the function is located in the message folder
	 * 					   NULL  = the script calling the function is index.php
	 * 			 user: string; the user which is logged on or null if no user is logged on
	 *			 isAdmin: boolean; has the logged on user access to the admin pages
	 */
	function createHeader($inDirPhp, $user, $isAdmin)
	{
		echo("\t<header>\n");
		echo("\t\t<div id='topbar'>\n");
		echo("\t\t\t<div class='center'>\n");
		echo("\t\t\t\t<div id='topmenubar'>\n");
		echo("\t\t\t\t\t<ul id='topmenu'>\n");
		if (is_null($user))
		{
			echo("\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t<img src='". (is_null($inDirPhp) ? "" : "../") ."images/lego-head.png' alt='Lego head' />\n");
			echo("\t\t\t\t\t\t\t<a href=''>Account</a>\n");
			echo("\t\t\t\t\t\t\t<ul>\n");
			echo("\t\t\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t\t\t<p class='lightGrey textCenter'>Sign in to your Lego account</p>\n");
			echo("\t\t\t\t\t\t\t\t\t<a id='loginBtn' href='".
				(is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/"))."login.php'>Sign in</a>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t\t\t<p class='lightGrey textCenter'>Don't have an account?</p>\n");
			echo("\t\t\t\t\t\t\t\t\t<a class='textCenter' href='". 
				(is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."register.php'>Register</a>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t\t</ul>\n");
			echo("\t\t\t\t\t\t</li>\n");
		}
		else
		{
			if ($isAdmin)
			{
				echo("\t\t\t\t\t\t<li>\n");
				echo("\t\t\t\t\t\t\t<img src='". (is_null($inDirPhp) ? "" : "../") ."images/redBrick.png' alt='red brick' />\n");
				echo("\t\t\t\t\t\t\t<a href='". 
					(is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."admin.php'>Admin pages</a>\n");
				echo("\t\t\t\t\t\t</li>\n");
			}
			//number of items to shopping bag
			if (isset($_SESSION['bag']['amount'])) $items = array_sum($_SESSION['bag']['amount']);
			else $items = 0;
			echo("\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t<img src='". (is_null($inDirPhp) ? "" : "../") ."images/lego-bag.png' alt='Lego shopping bag' />\n");
			echo("\t\t\t\t\t\t\t<a href='". (is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/"))
				."shoppingBag.php'>Shopping bag (". $items .")</a>\n");
			echo("\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t<img src='". (is_null($inDirPhp) ? "" : "../") ."images/lego-head.png' alt='Lego head' />\n");
			echo("\t\t\t\t\t\t\t<a href=''>Account</a>\n");
			echo("\t\t\t\t\t\t\t<ul>\n");
			echo("\t\t\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t<img id='ninja' src='".
				(is_null($inDirPhp) ? "" : "../") ."images/lego-ninja.png' alt='Lego Ninja figure' />\n");
			echo("\t\t\t\t\t\t\t\t\t<p>$user</p>\n");
			/*echo("\t\t\t\t\t\t\t\t\t<a href='".
				(is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."account.php'>View your Lego account</a>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t\t\t<img id='truck' src='".
				(is_null($inDirPhp) ? "" : "../") ."images/lego-order-status.svg' alt='Lego truck' />\n");
			echo("\t\t\t\t\t\t\t\t\t<a href='".
				(is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."orderStatus.php'>Check order status</a>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");*/
			echo("\t\t\t\t\t\t\t\t<li>\n");
			echo("\t\t\t\t\t\t\t\t\t<img id='mug' src='".
				(is_null($inDirPhp) ? "" : "../") ."images/mug.png' alt='Lego mug' />\n");
			echo("\t\t\t\t\t\t\t\t\t<a href='".
				(is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."logout.php'>Logout</a>\n");
			echo("\t\t\t\t\t\t\t\t</li>\n");
			echo("\t\t\t\t\t\t\t</ul>\n");
			echo("\t\t\t\t\t\t</li>\n");
		}
		echo("\t\t\t\t\t</ul>\n");
		echo("\t\t\t\t</div>\n");
		echo("\t\t\t\t<a href='https://www.lego.com/' title='To LEGO.com' target='_blank'>\n");
		echo("\t\t\t\t\t<img id='redBrick' src='". (is_null($inDirPhp) ? "" : "../") ."images/redBrick.png' alt='red brick' />\n");
		echo("\t\t\t\t\t<span id='legocom'>LEGO.COM</span>\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<p class='spacer'></p>\n");
		echo("\t\t\t</div> <!-- end center -->\n");
		echo("\t\t</div> <!-- end topbar -->\n");
		echo("\t\t<div id='menu'>\n");
		echo("\t\t\t<div class='center'>\n");
		echo("\t\t\t\t<div id='searchdiv'>\n");
		
		echo("\t\t\t\t</div>\n");
		echo("\t\t\t\t<a id='legoshop' href='". (is_null($inDirPhp) ? "." : "../") ."' title='Home'>\n");
		echo("\t\t\t\t\t<img id='shoplogo' src='". (is_null($inDirPhp) ? "" : "../") ."images/lego-logo.svg' alt='logo Lego' />\n");
		echo("\t\t\t\t\t<span id='shop'>SHOP</span>\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<div id='links'>\n");
		echo("\t\t\t\t\t<a class='linkBtn' href='". (is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."buildingSets.php'>SETS</a>\n");
		echo("\t\t\t\t\t<a class='linkBtn' href='". (is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."buildingSets.php?filter=exclusives'>EXCLUSIVES</a>\n");
		echo("\t\t\t\t\t<a class='linkBtn' href='". (is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."buildingSets.php?filter=hardToFind'>HARD TO FIND</a>\n");
		echo("\t\t\t\t\t<a class='linkBtn' href='". (is_null($inDirPhp) ? "php/" : ($inDirPhp ? "" : "../php/")) ."extras.php'>EXTRAS</a>\n");
		echo("\t\t\t\t</div> <!-- end links -->\n");
		echo("\t\t\t<p class='spacer'></p>\n");
		echo("\t\t\t</div> <!-- end center -->\n");
		echo("\t\t</div> <!-- end menu -->\n");        
		echo("\t</header>\n\n");
		echo("\t<div id='content'>\n");
	} // end function createHeader

    /*
	 * Function createFooter creates the default Lego webshop footer.
	 * Parameter inDirPhp: true  = the script calling the function is located in the php folder
	 * 					   false = the script calling the function is located in the message folder
	 * 					   NULL  = the script calling the function is index.php
	 */
	function createFooter($inDirPhp)
	{
		echo("\t</div> <!-- end content -->\n\n");
		echo("\t<footer>\n");
		echo("\t\t<div class='center'>\n");
		echo("\t\t\t<div id='footerright'>\n");
		echo("\t\t\t\t<a href='http://www.thomasmore.be/' title='to Thomas More homepage' target='_blank'>\n");
		echo("\t\t\t\t\t<img id='logotm' src='". (is_null($inDirPhp) ? "" : "../") ."images/tm_vignet_web.png' alt='logo Thomas More' />\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<p>Copyright &copy; 2017-2018 V&eacute;ronique Wuyts</p>\n");
		echo("\t\t\t\t<p>Professionele Bachelor Elektronica-ICT</p>\n");
		echo("\t\t\t\t<p>Thomas More Mechelen-Antwerpen vzw &ndash; Campus De Nayer</p>\n");
		echo("\t\t\t</div>\n");
		echo("\t\t\t<div id='footercenter'>\n");
		echo("\t\t\t\t<a href='https://www.lego.com' title='To LEGO.com' target='_blank'>\n");
		echo("\t\t\t\t\t<img id='logolego' src='". (is_null($inDirPhp) ? "" : "../") ."images/lego-logo.svg' alt='logo Lego' />\n");
		echo("\t\t\t\t</a>\n");
		echo("\t\t\t\t<p>Last update 04-03-2018</p>\n");
		echo("\t\t\t</div>\n");
		echo("\t\t\t<p class='spacer'></p>\n");
		echo("\t\t</div> <!-- end red part of footer -->\n");
		echo("\t</footer>\n");
		echo("</div>\n");
		echo("</body>\n");
		echo("</html>\n");
	} // end function createFooter
?>
