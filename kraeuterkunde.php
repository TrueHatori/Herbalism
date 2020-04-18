<?php
/*
 * Herbalism Plugin for e107
 * Copyright Joern Grube (http://www.spandau-ninja.de)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
*/
if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}
// Kontrolle, ob das Plugin ueberhaupt installiert ist
if (!e107::isInstalled('kraeuterkunde'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}

// Sprachpaket und METAs laden
e107::includeLan(e_PLUGIN.'kraeuterkunde/languages/'.e_LANGUAGE.'_front.php');
e107::meta('keywords','Kuroi Fenikkusu Dojo, Ninjutsu, Kampfkunst, Berlin, Spandau, Berlin-Spandau, Kräuterkunde, Gesundheit, Naturheilkunde');

require_once(HEADERF);

$sql = e107::getDB();
$tp = e107::getParser();
$frm = e107::getForm();
$ns = e107::getRender();

$text01 = '';
$text02 = '';
$text03 = '';

$count = $sql->count('kraeuterkunde');

// tab 1 - alphabetisch
$text01 .= '<p style="padding-top: 20px;">'.LAN_PLUGIN_HERBALISM_INTRO01.'<br>'.LAN_PLUGIN_HERBALISM_INTRO02.' <span style="color: #d100ff; font-weight: bold;">'.$count.'</span> '.LAN_PLUGIN_HERBALISM_INTRO03.'.</p>';
// alphabetische Suche ermoeglichen, $_GET festlegen, den Anfangsbuchstaben benutzen
$text01 .= '<p style="text-align: center;">
	<a href="kraeuterkunde.php?tab=1&alpha=A">A</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=B">B</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=C">C</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=D">D</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=E">E</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=F">F</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=G">G</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=H">H</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=I">I</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=J">J</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=K">K</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=L">L</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=M">M</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=N">N</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=O">O</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=P">P</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=Q">Q</a> <br>
	<a href="kraeuterkunde.php?tab=1&alpha=R">R</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=S">S</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=T">T</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=U">U</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=V">V</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=W">W</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=X">X</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=Y">Y</a> |
	<a href="kraeuterkunde.php?tab=1&alpha=Z">Z</a>
</p>';
// $_GET auslesen und die Pflanzen mit den entsprechenden Anfangsbuchstaben suchen und auflisten
if(isset($_GET['alpha']))
{
	$alpha = $_GET['alpha'];
	$eintraege = $sql->gen("SELECT kk_id, kk_Name_dt FROM #kraeuterkunde WHERE kk_Name_dt LIKE '".$alpha."%' ORDER BY kk_Name_dt ASC");
	if($eintraege)
	{
		$text01 .= '<ul>';
		while($row = $sql->fetch())
		{
			$kk_id = $row['kk_id'];
			$kk_name_dt = $row['kk_Name_dt'];
			$text01 .= '<li><a href="kraeuterkunde.php?tab=1&kraut_id='.$kk_id.'">'.$kk_name_dt.'</a></li>';
		}
		$text01 .= '</ul>';
		unset($alpha);
	}
	else
	{
		$text01 .= '<p>Keine Einträge mit dem Buchstaben '.$alpha.' gefunden.';
		unset($alpha);
	}
}
// das gewuenschte Kraut anhand der ID suchen und im Details anzeigen
if(isset($_GET['kraut_id']))
{
	$kraut_id = $_GET['kraut_id'];
	$sql->select('kraeuterkunde', '*', 'kk_id = '.$kraut_id);
	while($row = $sql->fetch())
	{
		$name_dt = $row['kk_Name_dt'];
		$name_wissenschaft = $row['kk_Name_lt'];
		$name_volk = $row['kk_Name_vt'];
		$wirkung = $row['kk_HWirkung_ID_fremd'];
		$anwendung_bei = $row['kk_Anwendung_ID_fremd'];
		$teile = $row['kk_Pflanzenteile'];
		$sammelzeit = $row['kk_Sammelzeit'];
		$inhaltstoffe = $row['kk_Inhaltsstoffe'];
		$benutzen = $tp->toHtml($row['kk_Benutzung'], true, 'BODY');
		
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAME.':</span> '.$name_dt.'</p>';
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAMELT.': </span>'.$name_wissenschaft.'</p>';
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAMEVT.':</span> '.$name_volk.'</p>';
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_WIRK.':</span></p>';
		// die IDs der Wirkungen in der Tabelle kraeuterkunde_heilwirkung suchen und die lesbaren Bezeichnungen schreiben
		$wirkValue = explode(',', $wirkung);
		$text01 .= '<ul>';
		foreach($wirkValue as $key => $val)
		{
			$sql->select('kraeuterkunde_heilwirkung', '*', 'kk_HWirkung_ID = '.$val);
			while($row = $sql->fetch())
			{
				$text01 .= '<li>'.$row['kk_HWirkung_Wirkung'].'</li>';
			}
		}
		$text01 .= '</ul>';
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_ANWEND.':</span></p>';
		// die IDs der Anwendung in der Tabelle kraeuterkunde_anwendungsbereich suchen und die lesbaren Bezeichnungen schreiben
		$anwendValue = explode(',', $anwendung_bei);
		$text01 .= '<ul>';
		foreach($anwendValue as $key => $val)
		{
			$sql->select('kraeuterkunde_anwendungsbereich', '*', 'kk_Anwendung_ID = '.$val);
			while($row = $sql->fetch())
			{
				$text01 .= '<li>'.$row['kk_Anwendung_Bereich'].'</li>';
			}
		}
		$text01 .= '</ul>';
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_TEILE.':</span> '.$teile.'</p>';
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_ERNTE.':</span> '.$sammelzeit.'</p>';
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_INHALT.':</span> '.$inhaltstoffe.'</p>';
		$text01 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_BESCHREIB.':</span></p>';
		$text01 .= $benutzen;
		$text01 .= "<p class='alert alert-block alert-danger' style='margin-top: 20px;'>".LAN_PLUGIN_HERBALISM_DISC01."<br>".LAN_PLUGIN_HERBALISM_DISC02."</p>";
	}
	unset($kraut_id);
}


// tab 2 - beschwerden
$text02 .= '<p style="padding-top: 20px;">'.LAN_PLUGIN_HERBALISM_INTRO21.LAN_PLUGIN_HERBALISM_INTRO22.LAN_PLUGIN_HERBALISM_INTRO02.' <span style="color: #d100ff; font-weight: bold;">'.$count.'</span> '.LAN_PLUGIN_HERBALISM_INTRO03.', '.LAN_PLUGIN_HERBALISM_INTRO23.'. '.LAN_PLUGIN_HERBALISM_INTRO24.' <span style="color: #f00; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_INTRO25.'</span>.<br>'.LAN_PLUGIN_HERBALISM_INTRO26.'</p><p>'.LAN_PLUGIN_HERBALISM_INTRO27.':</p>';
// die Liste mit den Krankheiten holen
$sql->select('kraeuterkunde_anwendungsbereich', '*', 'kk_Anwendung_ID > 0');
$arrayKrank = array();
while($row = $sql->fetch())
{
	$id = $row['kk_Anwendung_ID'];
	$krank = $row['kk_Anwendung_Bereich'];
	$arrayKrank += [$id => $krank];
}
// sortieren
asort($arrayKrank, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
// das Formular schreiben
$text02 .= $frm->open('krank', 'post', 'kraeuterkunde.php', '');
$text02 .=		$frm->hidden('tab', '2', '');
$text02 .=		$frm->select('krankheitsliste', $arrayKrank, '', array('multiple' => '1'), '').'<br><br>';
$text02 .=		$frm->button('send', '', '', 'Suchen', '');
$text02 .= $frm->close();

// Formular wurde abgeschickt
if(isset($_POST['krankheitsliste']))
{
	// den Suchbegriff holen
	$krankName = $_POST['krankheitsliste'];
	// wir wollen eine korrekte Grammatik, daher wird es etwas komplizierter
	$x = count($krankName);
	$y = 1;
	$text02 .= '<p style="padding-top: 20px;">'.LAN_PLUGIN_HERBALISM_INTRO28;
	foreach($krankName as $key => $val)
	{
		$sql->select('kraeuterkunde_anwendungsbereich', '*', 'kk_Anwendung_ID ='.$val);
		while($row = $sql->fetch())
		{
		$krankheitGesucht = $row['kk_Anwendung_Bereich'];
			if($x == 1)
			{
				$text02 .= '<span style="color: #d100ff; font-weight: bold;">'.$krankheitGesucht.'</span>';
			}
			elseif(($y+1) == $x)
			{
				$text02 .= '<span style="color: #d100ff; font-weight: bold;">'.$krankheitGesucht.'</span> ';
				$y++;
			}
			elseif($y < $x)
			{
				$text02 .= '<span style="color: #d100ff; font-weight: bold;">'.$krankheitGesucht.',</span> ';
				$y++;
			}
			elseif($y == $x)
			{
				$text02 .= 'und <span style="color: #d100ff; font-weight: bold;">'.$krankheitGesucht.'</span>';
			}
		}
	}
	$text02 .= LAN_PLUGIN_HERBALISM_INTRO29.'</p>';
	
	$krankheiten = $_POST['krankheitsliste'];
	// alle Pflanzen suchen
	$sql->gen("SELECT kk_id, kk_Name_dt, kk_Anwendung_ID_fremd FROM #kraeuterkunde WHERE kk_id > '0' ORDER BY kk_Name_dt ASC");
	// Liste öffnen
	$text02 .= '<ul>';
	$keineTreffer = 0;
	while($row = $sql->fetch())
	{
		$id = $row['kk_id'];
		$kkName = $row['kk_Name_dt'];
		// $idFremd brauchen wir als Array
		$idFremd = explode(',', $row['kk_Anwendung_ID_fremd']);
		// der Vergleich der beiden Arrays, wenn die Liste der Kranheiten vollstaendig enthalten ist, die Kraeuter schreiben
		$istDrin = array_intersect($krankheiten, $idFremd);
		if($krankheiten === $istDrin)
		{
			$text02 .= '<li>';
			$text02 .= '<a href="kraeuterkunde.php?tab=2&k_id='.$id.'">'.$kkName.'</a>';
			$text02 .= '</li>';
			$keineTreffer = $keineTreffer + 1;
		}
	}
	$text02 .= '</ul>';
	if($keineTreffer == 0)
	{
		$text02 .= '<p>'.LAN_PLUGIN_HERBALISM_SORRY01.'</p>';
	}
}
// Einzelseite darstellen
if(isset($_GET['k_id']))
{
	$kraut_id = $_GET['k_id'];
	$sql->select('kraeuterkunde', '*', 'kk_id = '.$kraut_id);
	while($row = $sql->fetch())
	{
		$name_dt = $row['kk_Name_dt'];
		$name_wissenschaft = $row['kk_Name_lt'];
		$name_volk = $row['kk_Name_vt'];
		$wirkung = $row['kk_HWirkung_ID_fremd'];
		$anwendung_bei = $row['kk_Anwendung_ID_fremd'];
		$teile = $row['kk_Pflanzenteile'];
		$sammelzeit = $row['kk_Sammelzeit'];
		$inhaltstoffe = $row['kk_Inhaltsstoffe'];
		$benutzen = $tp->toHtml($row['kk_Benutzung'], true, 'BODY');
		
		$text02 .= '<br><br><p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAME.':</span> '.$name_dt.'</p>';
		$text02 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAMELT.': </span>'.$name_wissenschaft.'</p>';
		$text02 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAMEVT.':</span> '.$name_volk.'</p>';
		$text02 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_WIRK.':</span></p>';
		// die IDs der Wirkungen in der Tabelle kraeuterkunde_heilwirkung suchen und die lesbaren Bezeichnungen schreiben
		$wirkValue = explode(',', $wirkung);
		$text01 .= '<ul>';
		foreach($wirkValue as $key => $val)
		{
			$sql->select('kraeuterkunde_heilwirkung', '*', 'kk_HWirkung_ID = '.$val);
			while($row = $sql->fetch())
			{
				$text02 .= '<li>'.$row['kk_HWirkung_Wirkung'].'</li>';
			}
		}
		$text02 .= '</ul>';
		$text02 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_ANWEND.':</span></p>';
		// die IDs der Anwendung in der Tabelle kraeuterkunde_anwendungsbereich suchen und die lesbaren Bezeichnungen schreiben
		$anwendValue = explode(',', $anwendung_bei);
		$text02 .= '<ul>';
		foreach($anwendValue as $key => $val)
		{
			$sql->select('kraeuterkunde_anwendungsbereich', '*', 'kk_Anwendung_ID = '.$val);
			while($row = $sql->fetch())
			{
				$text02 .= '<li>'.$row['kk_Anwendung_Bereich'].'</li>';
			}
		}
		$text02 .= '</ul>';
		$text02 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_TEILE.':</span> '.$teile.'</p>';
		$text02 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_ERNTE.':</span> '.$sammelzeit.'</p>';
		$text02 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_INHALT.':</span> '.$inhaltstoffe.'</p>';
		$text02 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_BESCHREIB.':</span></p>';
		$text02 .= $benutzen;
		$text02 .= "<p class='alert alert-block alert-danger' style='margin-top: 20px;'>".LAN_PLUGIN_HERBALISM_DISC01."<br>".LAN_PLUGIN_HERBALISM_DISC02."</p>";
	}
	unset($kraut_id);
}

// tab 3 - sammelkalender
$text03 .= '<p style="padding-top: 20px;">'.LAN_PLUGIN_HERBALISM_INTRO31.'</p>';
// die Links definieren um die korrekten GETs zu uebergeben
$text03 .= '<p style="text-align: center;">
	<a href="kraeuterkunde.php?tab=3&month=Januar">'.LAN_PLUGIN_HERBALISM_MONTH01.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=Februar">'.LAN_PLUGIN_HERBALISM_MONTH02.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=März">'.LAN_PLUGIN_HERBALISM_MONTH03.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=April">'.LAN_PLUGIN_HERBALISM_MONTH04.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=Mai">'.LAN_PLUGIN_HERBALISM_MONTH05.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=Juni">'.LAN_PLUGIN_HERBALISM_MONTH06.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=Juli">'.LAN_PLUGIN_HERBALISM_MONTH07.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=August">'.LAN_PLUGIN_HERBALISM_MONTH08.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=September">'.LAN_PLUGIN_HERBALISM_MONTH09.'</a><br>
	<a href="kraeuterkunde.php?tab=3&month=Oktober">'.LAN_PLUGIN_HERBALISM_MONTH10.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=November">'.LAN_PLUGIN_HERBALISM_MONTH11.'</a> |
	<a href="kraeuterkunde.php?tab=3&month=Dezember">'.LAN_PLUGIN_HERBALISM_MONTH12.'</a>
</p>';
if(isset($_GET['month']))
{
	$month = $_GET['month'];
	$eintraege = $sql->gen("SELECT kk_id, kk_Name_dt FROM #kraeuterkunde WHERE kk_Sammelzeit LIKE '%".$month."%' ORDER BY kk_Name_dt ASC");
	// wenn passende Eintraege gefunden werden, diese jetzt auflisten
	if($eintraege)
	{
		$text03 .= '<p>'.LAN_PLUGIN_HERBALISM_INTRO32.'<span style="color: #d100ff; font-weight: bold;">'.$month.'</span>'.LAN_PLUGIN_HERBALISM_INTRO33.'</p>';
		$text03 .= '<ul>';
		while($row = $sql->fetch())
		{
			$kk_id = $row['kk_id'];
			$kk_name_dt = $row['kk_Name_dt'];
			$text03 .= '<li><a href="kraeuterkunde.php?tab=3&krauts_id='.$kk_id.'">'.$kk_name_dt.'</a></li>';
		}
		$text03 .= '</ul>';
		unset($month);
	}
	// falls nichts gefunden wird, eine Meldung ausgeben
	else
	{
		$text03 .= '<p>'.LAN_PLUGIN_HERBALISM_SORRY02.$month.'.</p>';
		unset($month);
	}
}
// das gewuenschte Kraut anhand der ID suchen und im Details anzeigen
if(isset($_GET['krauts_id']))
{
	$krauts_id = $_GET['krauts_id'];
	$sql->select('kraeuterkunde', '*', 'kk_id = '.$krauts_id);
	while($row = $sql->fetch())
	{
		$name_dt = $row['kk_Name_dt'];
		$name_wissenschaft = $row['kk_Name_lt'];
		$name_volk = $row['kk_Name_vt'];
		$wirkung = $row['kk_HWirkung_ID_fremd'];
		$anwendung_bei = $row['kk_Anwendung_ID_fremd'];
		$teile = $row['kk_Pflanzenteile'];
		$sammelzeit = $row['kk_Sammelzeit'];
		$inhaltstoffe = $row['kk_Inhaltsstoffe'];
		$benutzen = $tp->toHtml($row['kk_Benutzung'], true, 'BODY');
		
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAME.':</span> '.$name_dt.'</p>';
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAMELT.': </span>'.$name_wissenschaft.'</p>';
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_NAMEVT.':</span> '.$name_volk.'</p>';
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_WIRK.':</span></p>';
		// die IDs der Wirkungen in der Tabelle kraeuterkunde_heilwirkung suchen und die lesbaren Bezeichnungen schreiben
		$wirkValue = explode(',', $wirkung);
		$text03 .= '<ul>';
		foreach($wirkValue as $key => $val)
		{
			$sql->select('kraeuterkunde_heilwirkung', '*', 'kk_HWirkung_ID = '.$val);
			while($row = $sql->fetch())
			{
				$text03 .= '<li>'.$row['kk_HWirkung_Wirkung'].'</li>';
			}
		}
		$text03 .= '</ul>';
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_ANWEND.':</span></p>';
		// die IDs der Anwendung in der Tabelle kraeuterkunde_anwendungsbereich suchen und die lesbaren Bezeichnungen schreiben
		$anwendValue = explode(',', $anwendung_bei);
		$text03 .= '<ul>';
		foreach($anwendValue as $key => $val)
		{
			$sql->select('kraeuterkunde_anwendungsbereich', '*', 'kk_Anwendung_ID = '.$val);
			while($row = $sql->fetch())
			{
				$text03 .= '<li>'.$row['kk_Anwendung_Bereich'].'</li>';
			}
		}
		$text03 .= '</ul>';
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_TEILE.':</span> '.$teile.'</p>';
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_ERNTE.':</span> '.$sammelzeit.'</p>';
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_INHALT.':</span> '.$inhaltstoffe.'</p>';
		$text03 .= '<p><span style="color: #d100ff; font-weight: bold;">'.LAN_PLUGIN_HERBALISM_BESCHREIB.':</span></p>';
		$text03 .= $benutzen;
		$text03 .= "<p class='alert alert-block alert-danger' style='margin-top: 20px;'>".LAN_PLUGIN_HERBALISM_DISC01."<br>".LAN_PLUGIN_HERBALISM_DISC02."</p>";
	}
	unset($kraut_id);
}

// Tabs definieren
$array = array(
	'alphabetisch' => array('caption' => '&nbsp;&nbsp;&nbsp;&nbsp; '.LAN_PLUGIN_HERBALISM_ALPHA.' &nbsp;&nbsp;&nbsp;', 'text' => $text01),
	'beschwerden' => array('caption' => '&nbsp;&nbsp;&nbsp;&nbsp; '.LAN_PLUGIN_HERBALISM_GRUND.' &nbsp;&nbsp;&nbsp;', 'text' => $text02),
	'sammelkalender' => array('caption' => '&nbsp;&nbsp;&nbsp;&nbsp; '.LAN_PLUGIN_HERBALISM_ERNTE.' &nbsp;&nbsp;&nbsp;', 'text' => $text03),
);

// den aktiven Tab festlegen
if((isset($_GET['tab'])) AND ($_GET['tab'] == 3))
{
	echo $frm->tabs($array, array('active' => 'sammelkalender'));
}
elseif(((isset($_GET['tab'])) AND ($_GET['tab'] == 2)) OR (isset($_POST['tab'])) AND ($_POST['tab'] == 2))
{
	echo $frm->tabs($array, array('active' => 'beschwerden'));
}
else
{
	echo $frm->tabs($array, array('active' => 'alphabetisch'));
}

require_once(FOOTERF);
exit;
?>