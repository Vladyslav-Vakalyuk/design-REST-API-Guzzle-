<?php
class FileLogging {

	private $action;
	private $data;

	/**
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param $data
	 */
	public function setData( $data ) {
		$this->data = $data;
	}

	/**
	 * @return mixed
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * @param $action
	 */
	public function setAction( $action ) {
		$this->action = $action;
	}

	/**
	 * @return string
	 */
	private function getDataLogging() {
		return $this->getAction() . ': ' . $this->getData();
	}

	/**
	 *
	 */
	public function logging() {
		$handle = fopen( 'logging.txt', 'w+' );
		fwrite( $handle, $this->getDataLogging() );
	}

}