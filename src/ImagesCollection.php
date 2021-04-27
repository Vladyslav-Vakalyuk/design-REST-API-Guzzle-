<?php
class ImagesCollection extends Collection {

	protected $id;
	protected $url;

	/**
	 * ImagesCollection constructor.
	 *
	 * @param $id
	 * @param $url
	 */
	public function __construct( $id, $url ) {
		$this->setId( $id );
		$this->setUrl( $url );
	}

	/**
	 * @param $breedId
	 *
	 * @return array
	 */
	public static function searchByBreeds( $breedId ) {
		static::init();
		$arrayResponse    =  static::$request_manager->request( 'images/search', [ 'breed-id' => $breedId ] );
		$imagesCollection = [];
		foreach ( $arrayResponse['content'] as $key => $value ) {
			$imagesCollection[] = new ImagesCollection( $value['id'], $value['url'] );
		}

		return $imagesCollection;
	}

	/**
	 * @param $categoryId
	 *
	 * @return array[]
	 */
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

	/**
	 * @param $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @param $url
	 */
	public function setUrl( $url ) {
		$this->url = $url;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getUrl() {
		return $this->url;
	}

}