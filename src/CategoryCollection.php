<?php

use Cache\Adapter\PHPArray\ArrayCachePool;
use Cache\Namespaced\NamespacedCachePool;

class CategoryCollection extends Collection {
	protected $id;
	protected $name;

	/**
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
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

	/**
	 * CategoryCollection constructor.
	 *
	 * @param $id
	 * @param $name
	 */
	public function __construct( $id, $name ) {
		$this->setId( $id );
		$this->setName( $name );
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
	public function getName() {
		return $this->name;
	}

	/**
	 * @param $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @param $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

}