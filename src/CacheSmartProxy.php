<?php


class CacheSmartProxy {

	public static array $cache = [];

	/**
	 * @param $key
	 * @param $data
	 */
	public function setValue( $key, $data ) {
		static::$cache[ $key ] = $data;
	}

	/**
	 * @param $key
	 *
	 * @return mixed|null
	 */
	public function getValue( $key ) {
		return static::$cache[ $key ] ?? null;
	}

}