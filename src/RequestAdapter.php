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

	/**
	 * @param $cacheManager
	 */
	public function setCacheManager( $cacheManager ) {
		$this->cacheManager = $cacheManager;
	}

	/**
	 * @return mixed
	 */
	public function getCacheManager() {
		return $this->cacheManager;
	}

	/**
	 * @param $logging
	 */
	public function setLogging( $logging ) {
		$this->logging = $logging;
	}

	/**
	 * @return mixed
	 */
	public function getLogging() {
		return $this->logging;
	}

	/**
	 * @param $manager
	 */
	public function setClientManager( $manager ) {
		$this->clientManager = $manager;
	}

	/**
	 * @param $param
	 *
	 * @return string
	 */
	public function getQueryParam( $param ) {
		$prepareParam = [];
		foreach ( $param as $key => $value ) {
			$prepareParam[ $key ] = $value;
		}

		return http_build_query(
			$prepareParam
		);
	}

	/**
	 * @param $q
	 */
	public function setSearchParam( $q ) {
		$this->q = $q;
	}

	/**
	 * @return mixed
	 */
	public function getSearchParam() {
		return $this->q;
	}

	/**
	 * @param $url
	 * @param $param
	 *
	 * @return array|mixed
	 */
	public function request( $url, $param ) {
		$cacheManager = $this->getCacheManager();
		$requestUrl   = $this->baseUrl . $url;
		$queryParam   = $this->getQueryParam( $param );
		$endpoint     = $requestUrl . '?' . $queryParam;
		if ( $cacheManager->getValue( $endpoint ) ) {
			return $cacheManager->getValue( $endpoint );
		}
		$resultRequest = $this->clientManager->request( 'GET', $endpoint, [ 'headers' => $this->getHeders() ] );
		if ( $resultRequest->getStatusCode() === 200 ) {
			return $this->handle_request_result( $resultRequest, $cacheManager, $endpoint, $requestUrl, $queryParam );
		}
	}

	/**
	 * @param $resultRequest
	 * @param $cacheManager
	 * @param $endpoint
	 * @param $requestUrl
	 * @param $queryParam
	 *
	 * @return array
	 */
	public function handle_request_result( $resultRequest, $cacheManager, $endpoint, $requestUrl, $queryParam ) {
		$response = $resultRequest->getBody()->getContents();
		$resultRequest->getHeader( 'pagination-count' )[0];
		$result            = [];
		$result['content'] = \json_decode( $response, true );
		if ( isset( $resultRequest->getHeader( 'pagination-count' )[0] ) ) {
			$result['headers']['page-count'] = $resultRequest->getHeader( 'pagination-count' )[0];
		}
		$cacheManager->setValue( $endpoint, $result );
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