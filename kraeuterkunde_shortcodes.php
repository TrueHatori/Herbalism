<?php
/*
 * Krauterkunde - an e107 plugin by Joern Grube
 *
 * Copyright (C) 2019 Joern Grube (http://www.ninja4ever.de)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

if (!defined('e107_INIT')) { exit; }

 /*
  kraeuterkunde Shortcodes
 */

class kraeuterkunde_shortcodes extends e_shortcode
{
   // KRAUTERKUNDE_ID
	function sc_kraeuterkunde_id($parm='')
	{
		return $this->var['kk_id'];
	}

	
	function sc_kraeuterkunde_category($parm='')
	{
		return e107::getDb()->retrieve('kraeuterkunde_categories', 'c_name', 'c_id = '.$this->var["e_category"]);
	}

	function sc_kraeuterkunde_description($parm='')
	{
		return $this->var["e_description"];
	}
}
?>
