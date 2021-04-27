<?php

class RequestAdapter {
	private $clientManager;
	private $xApiKey = 'b595fcae-fbde-422a-b430-9d85ce307209';
	private $limit;
	private $page;
	private $q;
	private $breedId;
	private $queryParam;
	private $baseUrl = 'https://api.thecatapi.com/v1/';
	private $logging;
	private $cacheManager;

	public function setCacheManager( $cacheManager ) {
		$this->cacheManager = $cacheManager;
	}

	public function getCacheManager() {
		return $this->cacheManager;
	}

	public function setLogging( $logging ) {
		$this->logging = $logging;
	}

	public function getLogging() {
		return $this->logging;
	}

	public function setClientManager( $manager ) {
		$this->clientManager = $manager;
	}

	public function getQueryParam( $param ) {
		$prepareParam = [];
		foreach ( $param as $key => $value ) {
			$prepareParam[ $key ] = $value;
		}

		return http_build_query(
			$prepareParam
		);
	}

	public function setSearchParam( $q ) {
		$this->q = $q;
	}

	public function getSearchParam() {
		return $this->q;
	}

	public function request( $url, $param ) {
		$cacheManager = $this->getCacheManager();
		$requestUrl   = $this->baseUrl . $url;
		$queryParam   = $this->getQueryParam( $param );
		$endpoint     = $requestUrl . '?' . $queryParam;
		if ( $cacheManager->getValue( $endpoint ) ) {
			$result = $cacheManager->getValue( $endpoint );
		} else {
			$resultRequest = $this->clientManager->request( 'GET', $endpoint, [ 'headers' => $this->getHeders() ] );
			if ( $resultRequest->getStatusCode() === 200 ) {
//				var_dump();die;
				$response = $resultRequest->getBody()->getContents();
				$resultRequest->getHeader('pagination-count')[0];
//				var_dump($response);die;
				$result = [];
				$result['content'] = \json_decode($response,true);
				if(isset($resultRequest->getHeader('pagination-count')[0])){
					$result['headers']['page-count'] = $resultRequest->getHeader('pagination-count')[0];
				}
				$cacheManager->setValue( $endpoint, $result );
				$this->getLogging()->logging( $requestUrl . '?' . $queryParam, $result );

				return $result;
			}
		}
		$this->getLogging()->logging( $requestUrl . '?' . $queryParam, $result );

		return $result;
	}

	/**
	 * @param $page
	 */
	private function setPage( $page ) {
		$this->page = $page;
	}

	/**
	 * @return mixed
	 */
	private function getPage() {
		return $this->page;
	}

	/**
	 * @param $limit
	 */
	private function setLimit( $limit ) {
		$this->limit = $limit;
	}

	/**
	 * @return mixed
	 */
	private function getLimit() {
		return $this->limit;
	}

	/**
	 * @param $xApiKey
	 */
	public function setXApiKey( $xApiKey ) {
		$this->xApiKey = $xApiKey;
	}

	/**
	 * @return string
	 */
	public function getXApiKey() {
		return $this->xApiKey;
	}

	/**
	 * @return string[][]
	 */
	public function getHeders() {
		return [ 'headers' => [ 'x-api-key' => $this->getXApiKey() ] ];
	}

}