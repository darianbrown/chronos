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
		$delimiter = $delimiter === NULL ? '-' : $delimiter;
		return date('Y' . $delimiter . 'm' . $delimiter . 'd', $this->timestamp);
	}

	// TODO: Add 24/12 hour output
	public function his($delimiter=':') {
		$delimiter = $delimiter === NULL ? ':' : $delimiter;
		return date('H' . $delimiter . 'i' . $delimiter . 's', $this->timestamp);
	}

	// TODO: long and short (Wed and Wednesday)
	public function day() {
		return date('D', $this->timestamp);
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

	/**
	 * Displays sting showing how long ago the date instance is from now
	 */
	public function ago($abbr=FALSE) {

		// figure out how many seconds the date is from now
		$seconds = time() - $this->timestamp;
		
		// in the future
		if( $seconds < 0 ) {
			$f = ($seconds*-1) . " seconds from now";
		}
		// 0 - 9 seconds
		else if( $seconds < 10 ) {
			$f = "a few moments ago";
		}
		// 10 - 59 seconds
		else if( $seconds < 60 ) {
			$f = "$seconds seconds ago";
		}
		// 1 minute - 59 minutes
		else if( $seconds < 3600 ) {
			$f = floor($seconds/60)." minutes ago";
		}
		// 1 hour - 23 hours
		else if( $seconds < 86400 ) {
			$f = floor($seconds/3600)." hours ago";
		}
		// 24 hours - 47 hours (yesterday)
		else if( $seconds < 172800 ) {
			$f = "Yesterday";
		}
		// otherwise
		else
		{
			// morning of 6 days ago (i.e. if today is fri, this will be the date of previous sat morning 00:00:00)
			// this prevents us displaying fri (for a date of last week) when today is fri.
			$mk = strtotime('-6 days');
			$mk = mktime(00,00,00,date('m',$mk),date('d',$mk),date('Y',$mk));

			// 48 hours - 7 days (show day - Friday, Saturday, etc.)
			if( $mk < $this->timestamp )
				$f = date('l',$this->timestamp);
			// more than 7 days ago (show date - 22 September)
			else
			{
				// now if the date is in a previous year, we add the year to the end
				if( date('Y') != date('Y',$this->timestamp) )
					$f = date('d F Y',$this->timestamp);
				// else return the date without the year
				else
					$f = date('d F',$this->timestamp);
			}
		}

		return ($abbr) ? "<abbr title='".date('d F Y h:i A', $this->timestamp)."'>$f</abbr>" : $f;

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
