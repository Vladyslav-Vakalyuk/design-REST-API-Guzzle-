<?php
class ImagesCollection extends Collection {

	protected $id;
	protected $url;

	public function __construct( $id, $url ) {
		$this->setId( $id );
		$this->setUrl( $url );
	}

	public static function searchByBreeds( $breedId ) {
		static::init();
		$arrayResponse    =  static::$request_manager->request( 'images/search', [ 'breed-id' => $breedId ] );
		$imagesCollection = [];
		foreach ( $arrayResponse['content'] as $key => $value ) {
			$imagesCollection[] = new ImagesCollection( $value['id'], $value['url'] );
		}

		return $imagesCollection;
	}

	public static function searchByCategory( $categoryId ) {
		static::init();
		$arrayResponse      =  static::$request_manager->request( 'images/search', [ 'category_ids' => $categoryId ] );
		$breedsCollection   = [];
		$ImagesCollection   = [];
		$categoryCollection = [];
		foreach ( $arrayResponse['content'] as $key => $value ) {
			$breedsCollection[]   = new BreedsCollection( $value['breeds']['id'], $value['breeds']['name'], $value['breeds']['temperament'], $value['breeds']['description'], $value['breeds']['reference_image_id'] );
			$ImagesCollection[]   = new ImagesCollection( $value['id'], $value['url'] );
			$categoryCollection[] = new CategoryCollection( $value['category']['id'], $value['category']['name'] );
		}
		$result = [ $breedsCollection, $ImagesCollection, $categoryCollection ];

		return $result;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function setUrl( $url ) {
		$this->url = $url;
	}

	public function getId() {
		return $this->id;
	}

	public function getUrl() {
		return $this->url;
	}

}