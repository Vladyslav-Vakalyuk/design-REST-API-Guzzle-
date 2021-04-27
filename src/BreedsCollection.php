<?php
require_once 'Collection.php';
class BreedsCollection extends Collection {
	protected $id;
	protected $name;
	protected $temperament;
	protected $description;
	protected $reference_image_id;
//	public static $count

	public static function searchBreeds( $search ) {
		static::init();
		$arrayResponse    =  static::$request_manager->request( 'breeds/search', [ 'q' => $search ] );
		$breedsCollection = [];
		foreach ( $arrayResponse['content'] as $key => $value ) {
			$breedsCollection[] = new BreedsCollection( $value['id'], $value['name'], $value['temperament'], $value['description'], $value['reference_image_id'] );
		}

		return $breedsCollection;
	}

	public static function getBreedsList( $limit, $page ) {
		static::init();
		$arrayResponse    =  static::$request_manager->request( 'breeds', [
			'limit' => $limit,
			'page'  => $page
		] );
		$breedsCollection = [];
		foreach ( $arrayResponse['content'] as $key => $value ) {
			$breedsCollection[] = new BreedsCollection( $value['id'], $value['name'], $value['temperament'], $value['description'], $value['reference_image_id'] );
		}

		return ['content' => $breedsCollection, 'count_page' => $arrayResponse['headers']['page-count']];
	}

	public function __construct( $id, $name, $temperament, $description, $reference_image_id ) {
		$this->setId( $id );
		$this->setName( $name );
		$this->setTemperament( $temperament );
		$this->setDescription( $description );
		$this->setReferenceImageId( $reference_image_id );
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getTemperament() {
		return $this->temperament;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getReferenceImageId() {
		return $this->reference_image_id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	public function setTemperament( $temperament ) {
		$this->temperament = $temperament;
	}

	public function setDescription( $description ) {
		$this->description = $description;
	}

	public function setReferenceImageId( $reference_image_id ) {
		$this->reference_image_id = $reference_image_id;
	}

}