<?php

class DecoratorLogging {

	public $loggingManager;

	/**
	 * @param $loggingManager
	 */
	public function setLoggingManager( $loggingManager ) {
		$this->loggingManager = $loggingManager;
	}

	/**
	 * @param $url
	 * @param $data
	 */
	public function logging( $url, $data ) {
		$this->loggingManager->setAction( $url );
		$this->loggingManager->setData( $data );
		$this->loggingManager->logging();
	}

}