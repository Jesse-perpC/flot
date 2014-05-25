<?php
	# error handler


	class AdminUI {
		public $s_base_path;

		function __construct() {
			$this->s_base_path = str_replace($_SERVER['SCRIPT_NAME'],"",str_replace("\\","/",$_SERVER['SCRIPT_FILENAME'])).'/';
		}
		function html_make_left_menu($s_active_section){

			return '<div id="admin_menu_left">
					<a class="admin_menu_left'.$this->s_active_or_empty("items", $s_active_section).'" href="/flot_flot/admin/index.php?section=items&amp;oncology=page"><i class="glyphicon glyphicon-file"></i><span class="small-hidden condensed_hidden"> Webpages</span></a>
					<a class="admin_menu_left'.$this->s_active_or_empty("pictures", $s_active_section).'" href="/flot_flot/admin/index.php?section=pictures"><i class="glyphicon glyphicon-picture"></i><span class="small-hidden condensed_hidden"> Pictures</span></a>
					<a class="admin_menu_left'.$this->s_active_or_empty("menus", $s_active_section).'" href="/flot_flot/admin/index.php?section=menus"><i class="glyphicon glyphicon-list"></i><span class="small-hidden condensed_hidden"> Menus</span></a>
					<a class="admin_menu_left'.$this->s_active_or_empty("settings", $s_active_section).'" href="/flot_flot/admin/index.php?section=settings"><i class="glyphicon glyphicon-cog"></i><span class="small-hidden condensed_hidden"> Settings</span></a>
				</div>';
		}
		function html_make_admin_page($html_header, $html_left_menu, $html_make_admin_content, $html_make_admin_content_menu, $s_body_class){

			include($this->s_base_path.'flot_flot/admin/ui/template.php');
			exit();
		}
		function s_active_or_empty($s_me, $s_current){
			if($s_me === $s_current)
				return " active";
			else
				return "";
		}
		function s_admin_header($s_section = ""){
			$s_header = "";

			$s_header .= $this->html_admin_headers_base();

			if($s_section === "items"){
				# ckeditor
				$s_header .= '<script src="/flot_flot/external_integrations/ckeditor/ckeditor.js"></script>';

				# general admin js
				$s_header .= '<script src="/flot_flot/admin/js/admin_itemedit.js"></script>';

				$s_header .= $this->html_admin_headers_pictures();
			}

			if($s_section === "menus"){
				# jquery ui, for sortables
				$s_header .= '<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>';
				// admin js for menus
				$s_header .= '<script src="/flot_flot/admin/js/admin_menus.js"></script>';
			}

			if($s_section === "pictures"){
				# general admin js
				$s_header .= $this->html_admin_headers_pictures();
			}




			$s_header .= '<title>flot - manage your site</title>';

			return $s_header;
		}
		function html_admin_headers_pictures(){
			$s_header = "";
			$s_header .= '<script src="/flot_flot/admin/js/jquery.ui.widget.js"></script>';
			$s_header .= '<script src="/flot_flot/admin/js/jquery.iframe-transport.js"></script>';
			$s_header .= '<script src="/flot_flot/admin/js/jquery.fileupload.js"></script>';
			$s_header .= '<script src="/flot_flot/admin/js/admin_pictures.js"></script>';
			return $s_header;
		}
		function html_admin_headers_base(){
			$s_header = "";
			# bootstrap css
			$s_header .= '<link rel="stylesheet" href="/flot_flot/admin/css/bootstrap.min.css">';
			# admin css
			$s_header .= '<link rel="stylesheet" href="/flot_flot/admin/css/admin_style.css">';

			# jquery js
			$s_header .= '<script src="/flot_flot/admin/js/jquery.min.js"></script>';
			# bootstrap js
			$s_header .= '<script src="/flot_flot/admin/js/bootstrap.min.js"></script>';
			return $s_header;
		}
		function html_make_settings_form($jo_settings){
			$html_form = "";

			$html_form .= '<h4>Settings</h4>';
			$html_form .= '<p>settings can\'t be edited here just yet, only in the settings.php file in the datastore folder.</p><hr/>';

			$html_form .= '<form role="form" method="post" action="index.php">';

			# upload dir
			$html_form .= '<div class="form-group"><label for="setting_upload_dir">Upload folder (file path, relative from root)</label><input type="text" class="form-control input-sm" id="setting_upload_dir" placeholder="relative upload directory" disabled value="'.$jo_settings->upload_dir.'"></div>';

			# theme
			$html_form .= '<div class="form-group"><label for="setting_theme_name">Theme</label><input type="text" class="form-control input-sm" id="setting_theme_name" placeholder="theme" name="theme" value="'.$jo_settings->theme.'"></div>';

			$html_form .= '<hr/>';
			$html_form .= '<h5>Thumbnail sizes</h5>';
			#
			# thumbs
			#
			foreach ($jo_settings->thumb_sizes as $o_thumb_size) {
				/*
				# name
				$html_form .= $o_thumb_size->name;
				# width
				$html_form .= $o_thumb_size->max_width;
				# height
				$html_form .= $o_thumb_size->max_height;
				*/

				$html_form .= '<div class="row form-group"><div class="col-xs-12"><label>'.$o_thumb_size->name.'</label><input type="text" class="form-control" placeholder="" value="'.$o_thumb_size->name.'" disabled></div></div><div class="row form-group"><div class="col-xs-12 col-sm-6"><label>max width (blank for none)</label><input type="text" class="form-control" placeholder="" value="'.$o_thumb_size->max_width.'" disabled></div><div class="col-xs-12 col-sm-6"><label>max height (blank for none)</label><input type="text" class="form-control" placeholder="" value="'.$o_thumb_size->max_height.'" disabled></div></div>';
			}

			# save
			$html_form .= '<div class="form-group">';

			$html_form .= '<input value="save" type="submit" class="form-control btn btn-success">';
			$html_form .= '</div>';

			# hidden elements
			$html_form .= '<input type="hidden" name="section" value="settings">';

			$html_form .= '</form>';

			return $html_form;
		}
	}
?>