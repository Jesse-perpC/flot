<?php
	# handles everything to do with the items, initiating and rendering

	# properties: url, private, oncology, template, dynamic/static
	# methods: rebuild, update, add, edit, delete


    # initiate an item from the data in urls datastore
	
	# call its render method

	class Item {

		public $o_loaded_item_object;
		public $html_page;
		public $s_base_path;

		function __construct($o_item, $s_base_path) {
			$this->o_loaded_item_object = $o_item;
			$this->s_base_path = $s_base_path;
		}

		function rebuild() {
			# render, and rebuild dependent items
		}
		function update() {

			$current_url = new CurrentURL;

			# create any directories for the file if neccesary
			if($current_url->has_dirs()){
				# make dirs
				mkdir($this->s_base_path.$current_url->dir_path(), 0777, true);
			}

			# write the file itself	
			file_put_contents($current_url->writing_file_path($this->s_base_path), $this->html_page);


			echo "just rendered item: ".$current_url->writing_file_path($this->s_base_path);
		}
		function delete() {
			# delete the file

			# if it was the last file in folder, delete folder, repeat this recursively until back to root
		}
		function render() {
			$this->datastore = new DataStore;
			# get template
			$template = file_get_contents($this->s_base_path.'/flot_flot/themes/'.$this->datastore->settings->theme.'/flot_template.html');

			# parse in data
			$sa_keys = array_keys(get_object_vars($this->o_loaded_item_object));

			foreach ($sa_keys as $key) {
				if($this->o_loaded_item_object->$key !== null)
					$template = str_replace("{{item:".$key."}}", $this->o_loaded_item_object->$key, $template);
			}
			# general parsing
			$template = str_replace("{{flot:theme_dir}}", '/flot_flot/themes/'.$this->datastore->settings->theme.'/', $template);

			# minify etc
			$search = array(
		        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
		        '/(\s)+/s'       // shorten multiple whitespace sequences
		    );

		    $replace = array(
		        '>',
		        '<',
		        '\\1'
		    );

		    $template = preg_replace($search, $replace, $template);

			# serve to user

			ob_start("ob_gzhandler");
			echo $template;
			$this->html_page = $template;


			# store to disk
			$this->update();
		}

		#
		# content generation
		#
		function make_header(){
			# spit out content type (settings? content type, or not to display)

			# keywords etc, generate if necessary

			# open graph stuff
		}
	}
?>