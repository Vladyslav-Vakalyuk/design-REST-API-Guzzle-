<?php


class CacheSmartProxy {

	public static array $cache = [];

	public function setValue( $key, $data ) {
		static::$cache[ $key ] = $data;
	}

	public function getValue( $key ) {
		return static::$cache[ $key ] ?? null;
	}

}