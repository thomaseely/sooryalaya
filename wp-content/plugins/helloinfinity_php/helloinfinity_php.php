<?php
/*
Plugin Name: Helloinfinity PHP
Plugin URI: http://www.helloinfinity.com/
Description: Helps to run PHP code inserted into WordPress posts and pages.
Version: 1.0
Date: 27 September 2013
Author: Unnikrishnan S <unni@helloinfinity.com>
Author URI: http://www..helloinfinity.com/
*/

/*
	Copyright 2013 Helloinfinity Business Solutions PVT LTD

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation. A copy of the license is at
	http://www.gnu.org/licenses/gpl-2.0.html

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
*/

/*
Note: This plugin requires WordPress version 3.0 or higher.

Information about the Helloinfinity PHP plugin can be found here:
http://www.helloinfinity.com/

Instructions and examples can be found here:
http://www.helloinfinity.com/
*/


if( ! function_exists('helloinfinity_php') )
{

	function helloinfinity_php()
	{
		$helloinfinity_content = get_the_content();
		preg_match_all('!\[hi_php[^\]]*\](.*?)\[/hi[^\]]*\]!is',$helloinfinity_content,$helloinfinity_matches);
		$helloinfinity_nummatches = count($helloinfinity_matches[0]);
		for( $helloinfinity_i=0; $helloinfinity_i<$helloinfinity_nummatches; $helloinfinity_i++ )
		{
			ob_start();
			eval($helloinfinity_matches[1][$helloinfinity_i]);
			$helloinfinity_replacement = ob_get_contents();
			ob_clean();
			ob_end_flush();
			$helloinfinity_search = quotemeta($helloinfinity_matches[0][$helloinfinity_i]);
			$helloinfinity_search = str_replace('/',"\\".'/',$helloinfinity_search);
			$helloinfinity_content = preg_replace("/$helloinfinity_search/",$helloinfinity_replacement,$helloinfinity_content,1);
		}
		return $helloinfinity_content;
	} # function helloinfinity_insert_php()

	add_filter( 'the_content', 'helloinfinity_php', 9 );

} # if( ! function_exists('helloinfinity_php') )
?>
