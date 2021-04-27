<?php
class FileLogging {

	private $action;
	private $data;

	public function getData() {
		return $this->data;
	}

	public function setData( $data ) {
		$this->data = $data;
	}

	public function getAction() {
		return $this->action;
	}

	public function setAction( $action ) {
		$this->action = $action;
	}

	private function getDataLogging() {
		return $this->getAction() . ': ' . $this->getData();
	}

	public function logging() {
		$handle = fopen( 'logging.txt', 'w+' );
		fwrite( $handle, $this->getDataLogging() );
	}

}