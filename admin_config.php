<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

//e107::lan('kraeuterkunde',true);
e107::includeLan(e_PLUGIN.'kraeuterkunde/languages/'.e_LANGUAGE.'_admin.php');

class kraeuterkunde_adminArea extends e_admin_dispatcher
{
	protected $modes = array(
		'main'	=> array(
			'controller' 	=> 'kraeuterkunde_ui',
			'path' 			=> null,
			'ui' 			=> 'kraeuterkunde_form_ui',
			'uipath' 		=> null
		),
		'heilwirkung'	=> array(
			'controller' 	=> 'heilwirkung_ui',
			'path' 			=> null,
			'ui' 			=> 'heilwirkung_form_ui',
			'uipath' 		=> null
		),
		'anwendung'	=> array(
			'controller' 	=> 'anwendung_ui',
			'path' 			=> null,
			'ui' 			=> 'anwendung_form_ui',
			'uipath' 		=> null
		),
		'inhalt'	=> array(
			'controller' 	=> 'inhalt_ui',
			'path' 			=> null,
			'ui' 			=> 'inhalt_form_ui',
			'uipath' 		=> null
		),
	);	
	
	protected $adminMenu = array(
		'main/list'				=> array('caption'=> LAN_ADMIN_KRAUT, 'perm' => 'P'),
		'main/create'			=> array('caption'=> LAN_ADMIN_KRAUT_NEU, 'perm' => 'P'),
		'divider/01'			=> array('divider'=>true),
		'heilwirkung/list'		=> array('caption'=> LAN_ADMIN_10.LAN_ADMIN_16, 'perm' => 'P'),
		'heilwirkung/create'	=> array('caption'=> LAN_ADMIN_10.LAN_ADMIN_11, 'perm' => 'P'),
		'divider/02'			=> array('divider'=>true),
		'anwendung/list'		=> array('caption'=> LAN_ADMIN_12.LAN_ADMIN_16, 'perm' => 'P'),
		'anwendung/create'		=> array('caption'=> LAN_ADMIN_12.LAN_ADMIN_11, 'perm' => 'P'),
		'divider/03'			=> array('divider'=>true),
		'inhalt/list'		=> array('caption'=> LAN_ADMIN_13.LAN_ADMIN_16, 'perm' => 'P'),
		'inhalt/create'		=> array('caption'=> LAN_ADMIN_13.LAN_ADMIN_11, 'perm' => 'P'),
	);

	protected $adminMenuAliases = array(
		'main/edit'			=> 'main/list',
	);	
	
	protected $menuTitle = LAN_PLUGIN_HERBALISM_LINKNAME;
}

class kraeuterkunde_ui extends e_admin_ui
{
		protected $pluginTitle		= LAN_PLUGIN_HERBALISM_LINKNAME;
		protected $pluginName		= 'kraeuterkunde';
		protected $table			= 'kraeuterkunde';
		protected $pid				= 'kk_id';
		protected $perPage			= 10;
		protected $batchDelete		= true;
		protected $batchExport		= true;
		protected $batchCopy		= true;
	
		protected $listOrder		= 'kk_Name_dt ASC';
	
		protected $fields 		= array (
			'checkboxes' => array(
				'title' => '',
				'type' => null,
				'data' => null,
				'width' => '5%',
				'thclass' => 'center',
				'forced' => '1',
				'class' => 'center',
				'toggle' => 'e-multiselect',
			),
			'kk_id'			=>   array (
				'title' => LAN_ID,
				'data' => 'int',
				'width' => '5%',
				'class' => 'left',
				'thclass' => 'left',
				'primary' => true,
			),
			'kk_Name_dt'	=>   array (
				'title' => LAN_ADMIN_01,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'validate' => true,
				'writeParms' => array('size'=>'xlarge'),
				'class' => 'left',
				'thclass' => 'left',
			),
			'kk_Name_lt'	=>   array (
				'title' => LAN_ADMIN_02,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'validate' => true,
				'writeParms' => array('size'=>'xlarge'),
				'class' => 'left',
				'thclass' => 'left',
			),
			'kk_Name_vt'	=>   array (
				'title' => LAN_ADMIN_05,
				'type' => 'textarea',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'writeParms' => array('size'=>'block-level'),
				'class' => 'left',
				'thclass' => 'left',
			),
			'kk_HWirkung_ID_fremd'	=>   array (
				'title' => LAN_ADMIN_03,
				'type' => 'dropdown',
				'data' => 'safestr',
				'inline' => true,
				'readParms' => array('type' => 'checkboxes'),
				'writeParms' => array('multiple'=>'1'),
				'width' => 'auto',
				'thclass' => 'left',
				'class' => 'left',
				'nosort' => false,
				'batch' => true,
				'filter' => true,
				'toggle' => 'e-multiselect',
			),
			'kk_Anwendung_ID_fremd'	=>   array (
				'title' => LAN_ADMIN_04,
				'type' => 'dropdown',
				'data' => 'safestr',
				'width' => 'auto',
				'inline' => true,
				'readParms' => array('type' => 'checkboxes'),
				'writeParms' => array('multiple'=>'1'),
				'validate' => true,
				'class' => 'left',
				'thclass' => 'left',
				'nosort' => false,
				'batch' => true,
				'filter' => true,
				'toggle' => 'e-multiselect',
			),
			'kk_Pflanzenteile' =>   array (
				'title' => LAN_ADMIN_06,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'validate' => true,
				'writeParms' => array('size'=>'xlarge'),
				'class' => 'left',
				'thclass' => 'left',
			),
			'kk_Sammelzeit'	=>   array (
				'title' => LAN_ADMIN_07,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'validate' => true,
				'writeParms' => array('size'=>'xlarge'),
				'class' => 'left',
				'thclass' => 'left',
			),
			'kk_Inhaltsstoffe' 	=>   array (
				'title' => LAN_ADMIN_08,
				'type' => 'textarea',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'writeParms' => array('size'=>'block-level'),
				'class' => 'left',
				'thclass' => 'left',
			),
			'kk_Benutzung'	=>   array (
				'title' => LAN_ADMIN_09,
				'type' => 'bbarea',
				'data' => 'str',
				'width' => '30%',
				'inline' => false,
				'validate' => true,
				'readParms' => 'expand=...&truncate=150&bb=1',
				'writeParms' => 'media=gallery_image_14',
				'class' => 'left',
				'thclass' => 'left',
			),
			'options'       => array(
				'title' => LAN_OPTIONS,
				'type' => null,
				'width' => '5%',
				'forced' => true,
				'thclass' => 'center last',
				'class' => 'right',
			),
		);
		protected $fieldpref = array();
		protected $prefs = array();

		public function init()
		{
			$sql = e107::getDb();
			// Checkboxen erstellen fuer Heilwirkung
			$entries = $sql->select('kraeuterkunde_heilwirkung');
			if($entries)
			{
				while($row = $sql->fetch())
				{
					$wirkID = $row['kk_HWirkung_ID'];
					$this->wirkung[$wirkID] = $row['kk_HWirkung_Wirkung'];
				}
				asort($this->wirkung, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
			}
			$this->fields['kk_HWirkung_ID_fremd']['writeParms']['optArray'] = $this->wirkung;
			$this->fields['kk_HWirkung_ID_fremd']['writeParms']['multiple'] = 1;
			
			// Checkboxen erstellen fuer Anwendung
			if($sql->select('kraeuterkunde_anwendungsbereich'))
			{
				while($row = $sql->fetch())
				{
					$anwendID = $row['kk_Anwendung_ID'];
					$this->anwend[$anwendID] = $row['kk_Anwendung_Bereich'];
				}
			}
			asort($this->anwend, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
			$this->fields['kk_Anwendung_ID_fremd']['writeParms']['optArray'] = $this->anwend;
			$this->fields['kk_Anwendung_ID_fremd']['writeParms']['multiple'] = 1;
		}

		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = LAN_ADMIN_HELP01;
			return array('caption'=>$caption,'text'=> $text);
		}
}

class kraeuterkunde_form_ui extends e_admin_form_ui
{
}

/* ---------- Abschnitt fuer Heilwirkungen ---------- */
class heilwirkung_ui extends e_admin_ui
{
		protected $pluginTitle		= LAN_PLUGIN_HERBALISM_LINKNAME;
		protected $pluginName		= 'kraeuterkunde';
		protected $table			= 'kraeuterkunde_heilwirkung';
		protected $pid				= 'kk_HWirkung_ID';
		protected $perPage			= 10;
		protected $listOrder		= 'kk_HWirkung_Wirkung ASC';
		protected $fields 		= array (
			'checkboxes' => array(
				'title' => '',
				'type' => null,
				'data' => null,
				'width' => '5%',
				'thclass' => 'center',
				'forced' => '1',
				'class' => 'center',
				'toggle' => 'e-multiselect',
			),
			'kk_HWirkung_ID'		=>   array (
				'title' => LAN_ID,
				'data' => 'int',
				'width' => '5%',
				'class' => 'left',
				'thclass' => 'left',
				'primary' => true,
			),
			'kk_HWirkung_Wirkung'	=>   array (
				'title' => LAN_ADMIN_10,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'validate' => true,
				'class' => 'left',
				'thclass' => 'left',
			),
			'options'       		=> array(
				'title' => LAN_OPTIONS,
				'type' => null,
				'width' => '5%',
				'forced' => true,
				'thclass' => 'center last',
				'class' => 'right',
			),
		);
		protected $fieldpref = array('kk_HWirkung_ID', 'kk_HWirkung_Wirkung');

		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = LAN_ADMIN_HELP02;
			return array('caption'=>$caption,'text'=> $text);
		}
}

class heilwirkung_form_ui extends e_admin_form_ui
{
}

/* ---------- Abschnitt fuer Anwendung bei ---------- */
class anwendung_ui extends e_admin_ui
{
		protected $pluginTitle		= LAN_PLUGIN_HERBALISM_LINKNAME;
		protected $pluginName		= 'kraeuterkunde';
		protected $table			= 'kraeuterkunde_anwendungsbereich';
		protected $pid				= 'kk_Anwendung_ID';
		protected $perPage			= 10;
		protected $listOrder		= 'kk_Anwendung_Bereich ASC';
		protected $fields 		= array (
			'checkboxes' => array(
				'title' => '',
				'type' => null,
				'data' => null,
				'width' => '5%',
				'thclass' => 'center',
				'forced' => '1',
				'class' => 'center',
				'toggle' => 'e-multiselect',
			),
			'kk_Anwendung_ID'		=>   array (
				'title' => LAN_ID,
				'data' => 'int',
				'width' => '5%',
				'class' => 'left',
				'thclass' => 'left',
				'primary' => true,
			),
			'kk_Anwendung_Bereich'	=>   array (
				'title' => LAN_ADMIN_12,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'validate' => true,
				'class' => 'left',
				'thclass' => 'left',
			),
			'options'				=> array(
				'title' => LAN_OPTIONS,
				'type' => null,
				'width' => '5%',
				'forced' => true,
				'thclass' => 'center last',
				'class' => 'right',
			),
		);
		protected $fieldpref = array('kk_Anwendung_ID', 'kk_Anwendung_Bereich');

		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = LAN_ADMIN_HELP03;
			return array('caption'=>$caption,'text'=> $text);
		}
}
				
class anwendung_form_ui extends e_admin_form_ui
{
}

/* ---------- Abschnitt fuer Erklaerung Inhaltsstoffe ---------- */
class inhalt_ui extends e_admin_ui
{
		protected $pluginTitle		= LAN_PLUGIN_HERBALISM_LINKNAME;
		protected $pluginName		= 'kraeuterkunde';
		protected $table			= 'kraeuterkunde_inhaltsstoffe_def';
		protected $pid				= 'kk_inhalt_id';
		protected $perPage			= 10;
		protected $listOrder		= 'kk_inhalt_inhalt ASC';
		protected $fields 		= array (
			'checkboxes' => array(
				'title' => '',
				'type' => null,
				'data' => null,
				'width' => '5%',
				'thclass' => 'center',
				'forced' => '1',
				'class' => 'center',
				'toggle' => 'e-multiselect',
			),
			'kk_inhalt_id'		=>   array (
				'title' => LAN_ID,
				'data' => 'int',
				'width' => '5%',
				'class' => 'left',
				'thclass' => 'left',
				'primary' => true,
			),
			'kk_inhalt_inhalt'	=>   array (
				'title' => LAN_ADMIN_14,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'validate' => true,
				'writeParms' => array('size'=>'xlarge'),
				'class' => 'left',
				'thclass' => 'left',
			),
			'kk_inhalt_def'	=>   array (
				'title' => LAN_ADMIN_13,
				'type' => 'bbarea',
				'data' => 'str',
				'width' => 'auto',
				'inline' => false,
				'validate' => true,
				'readParms' => 'expand=...&truncate=150&bb=1',
				'class' => 'left',
				'thclass' => 'left',
			),
			'options'				=> array(
				'title' => LAN_OPTIONS,
				'type' => null,
				'width' => '5%',
				'forced' => true,
				'thclass' => 'center last',
				'class' => 'right',
			),
		);
		protected $fieldpref = array('kk_inhalt_id', 'kk_inhalt_inhalt');

		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = LAN_ADMIN_HELP04;
			return array('caption'=>$caption,'text'=> $text);
		}
}
				
class inhalt_form_ui extends e_admin_form_ui
{
}

new kraeuterkunde_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

