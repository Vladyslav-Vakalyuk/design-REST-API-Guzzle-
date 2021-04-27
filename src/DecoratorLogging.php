<?php

class DecoratorLogging {

	public $loggingManager;

	public function setLoggingManager( $loggingManager ) {
		$this->loggingManager = $loggingManager;
	}

	public function logging( $url, $data ) {
		$this->loggingManager->setAction( $url );
		$this->loggingManager->setData( $data );
		$this->loggingManager->logging();
	}

}