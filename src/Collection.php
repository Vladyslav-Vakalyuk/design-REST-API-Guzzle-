<?php

use GuzzleHttp\Client;

class Collection {

	public static $request_manager;

	/**
	 *
	 */
	public static function init() {
		if ( empty( static::$request_manager ) ) {

			$client           = new Client();
			$request_manager  = new RequestAdapter();
			$loggingDecorator = new DecoratorLogging();
			$loggingFile      = new FileLogging();
			$cacheManager     = new CacheSmartProxy();
			$loggingDecorator->setLoggingManager( $loggingFile );
			$request_manager->setClientManager( $client );
			$request_manager->setLogging( $loggingDecorator );
			$request_manager->setCacheManager( $cacheManager );
			Collection::$request_manager = $request_manager;
		}
	}
}
