<?php

namespace Succinct\Chronos;

class Chronos {

	protected $date = NULL;
	
	public function __construct($date=NULL) {
		$this->timestamp = $this->resolve($date);
	}

	/**
	 * @returns int
	 */
	public function timestamp() {
		return $this->timestamp;
	}

	public function ymd($delimiter='-') {
		return date('Y' . $delimiter . 'm' . $delimiter . 'd', $this->timestamp);
	}

	static public function today() {
		return new self();
	}

	static public function tomorrow() {
		return new self('+1 day');
	}

	static public function yesterday() {
		return new self('-1 day');
	}

	protected function resolve($date) {
		if ($result = @strtotime($date)) {
			return $result;
		} else if ($date instanceof Chronos) {
			return $date->timestamp();
		} else if ($date === NULL) {
			return time();
		}

		throw new \InvalidArgumentException('Expected an instance of Chronos or a date string. Received: ' . $date);
	}

}
