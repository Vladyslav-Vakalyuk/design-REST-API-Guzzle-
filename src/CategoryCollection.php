<?php

use Cache\Adapter\PHPArray\ArrayCachePool;
use Cache\Namespaced\NamespacedCachePool;

class CategoryCollection extends Collection {
	protected $id;
	protected $name;

	public static function getCategoryList( $limit, $page ) {
		static::init();
		$arrayResponse    = static::$request_manager->request( 'categories', [
			'limit' => $limit,
			'page'  => $page
		] );
		$breedsCollection = [];
		foreach ( $arrayResponse['content'] as $key => $value ) {
			$breedsCollection[] = new CategoryCollection( $value['id'], $value['name'] );
		}

		return $breedsCollection;
	}

	public function __construct( $id, $name ) {
		$this->setId( $id );
		$this->setName( $name );
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

}