<?php

	class CollectionModel
	{
		/*
		contains all individual items, acts as an overview to them.
		one item contains everything to do with it, but to list items would be inefficient to load all individual items. so we have a collection which will contain a list of all individual items.
		*/
		protected $amPropertiesToExposeOfItems = [];
		protected $sTypeOfItems = "";
		public $sName = "";

		private $amItems = [];

		public function __construct() {
			//$this->sUId = uniqid(16);
		}


		public static function create()
		{
			$o = new static();
			// initiate items from disk
			$o->createFromFile();

			return $o;
		}


		public function createFromFile()
		{
			$sFilePath = $GLOBALS['files.models_path']."collection_".$this->sName.".php";

			$sFileContents = FileController::sReadTextFromFile($sFilePath);

			$this->amItems = $this->createFromJson($sFileContents);
		}
		public function createFromJson($sString)
		{
			$aItems = [];

			foreach((array)json_decode($sString) as $sKey => $oPartialItem)
			{
				// no we'll iterate through partially items, they are partial because only some attributes of a model are stored in the collection file

				$sUId = $sKey;

				$aItems[$sUId] = (array)$oPartialItem;
			}

			return $aItems;
		}

		public function save()
		{
			$sFileContents = json_encode($this->amItems);

			if(FileController::bSaveCollection($this->sName, $sFileContents))
				return true;

			return false;
		}

		public static function getAllItems()
		{
			$mModel = self::create();

			return $mModel->amItems;
		}

		public static function saveItem($mItem)
		{
			// save that specific item, but also update this collection too
			// save that individual item to disk, overwriting any previou
			$mItem->save();

			$mCollectionModel = self::create();
			// update the item in our collection
			$aNewProps = $mItem->aGetPropertiesForCollection();
			
			$mCollectionModel->amItems[$mItem->sUId] = $aNewProps;
			// now save our whole collection
			return $mCollectionModel->save();
		}
	}