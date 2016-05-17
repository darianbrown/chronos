public function ymd($delimiter='-')
{
    $delimiter = $delimiter === NULL ? '-' : $delimiter;

    return $this->format('Y' . $delimiter . 'm' . $delimiter . 'd');
}

// TODO: Add 24/12 hour output
public function his($delimiter=':')
{
    $delimiter = $delimiter === NULL ? ':' : $delimiter;

    return $this->format('H' . $delimiter . 'i' . $delimiter . 's');
}

public function ymdhis()
{
    return sprintf('%s %s', $this->ymd(), $this->his());
}

public function full()
{
    return $this->format('c');
}

// TODO: long and short (Wed and Wednesday)
public function day()
{
    return $this->format('D');
}

/**
 * Get day of year
 */
public function doy()
{
    return (int) $this->format('z');
}

/**
 * Get day of week
 */
public function dow()
{
    return (int) $this->format('w');
}

/**
 * Get week number
 */
public function week()
{
    return (int) $this->format('W');
}

public function format($dateString)
{
    return date($dateString, $this->timestamp);
}

/**
 * Displays sting showing how long ago the date instance is from now
 */
public function ago($abbr=FALSE)
{
    // TODO: Fix this method
    $timestamp = $this->timestamp();

    // figure out how many seconds the date is from now
    $seconds = time() - $timestamp;

    // in the future
    if ($seconds < 0) {
        $f = ($seconds*-1) . " seconds from now";
    }
    // 0 - 9 seconds
    else if ($seconds < 10) {
        $f = "a few moments ago";
    }
    // 10 - 59 seconds
    else if ($seconds < 60) {
        $f = "$seconds seconds ago";
    }
    // 1 minute - 59 minutes
    else if ($seconds < 3600) {
        $f = floor($seconds/60)." minutes ago";
    }
    // 1 hour - 23 hours
    else if ($seconds < 86400) {
        $f = floor($seconds/3600)." hours ago";
    }
    // 24 hours - 47 hours (yesterday)
    else if ($seconds < 172800) {
        $f = "Yesterday";
    }
    // otherwise
    else {
        // morning of 6 days ago (i.e. if today is fri, this will be the date of previous sat morning 00:00:00)
        // this prevents us displaying fri (for a date of last week) when today is fri.
        $mk = strtotime('-6 days');
        $mk = mktime(00,00,00,date('m',$mk),date('d',$mk),date('Y',$mk));

        // 48 hours - 7 days (show day - Friday, Saturday, etc.)
        if ($mk < $timestamp) {
            $f = date('l',$timestamp);
        }
        // more than 7 days ago (show date - 22 September)
        else {
            // now if the date is in a previous year, we add the year to the end
            if ( date('Y') != date('Y',$timestamp) ) {
                $f = date('j F Y',$timestamp);
            }
            // else return the date without the year
            else {
                $f = date('j F',$timestamp);
            }
        }
    }

    return ($abbr) ? "<abbr title='".date('d F Y h:i A', $timestamp)."'>$f</abbr>" : $f;
}