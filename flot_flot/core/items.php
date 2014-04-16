<?php
	# handles everything to do with the items, initiating and rendering

	# properties: url, private, oncology, template, dynamic/static
	# methods: rebuild, update, add, edit, delete


    # initiate an item from the data in urls datastore
	
	# call its render method

	class Item {

		public $o_loaded_item_object;

		function __construct($o_item) {
			$this->o_loaded_item_object = $o_item;
		}

		function rebuild() {
		}
		function update() {

		}
		function delete() {
			# delete the file

			# if it was the last file in folder, delete folder, repeat this recursively until back to root
		}
		function render() {
			# get template
			$template = file_get_contents('themes/first_theme/page.html');

			# parse in data
			$sa_keys = array_keys(get_object_vars($this->o_loaded_item_object));

			foreach ($sa_keys as $key) {
				if($this->o_loaded_item_object->$key !== null)
					$template = str_replace("{{item:".$key."}}", $this->o_loaded_item_object->$key, $template);
			}
			# minify etc

			# serve to user
			echo $template;

			# store to disk
			$this->update();
		}
	}
?>