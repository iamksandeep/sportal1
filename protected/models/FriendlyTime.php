<?php

class FriendlyTime {

    /**
     * @return mixed Formatted time
     */
    public function getFriendlyTime($timestamp) {
        if(($date = strtotime($timestamp)))
            return date('d M, Y', $date).' at '.date('g:i a', $date);
        return false;
    }

    /**
     * @link http://snipt.net/pkarl/pkarlcom-contextualtime/
     * @link http://pkarl.com/articles/contextual-user-friendly-time-and-dates-php/
     */
    static public function getContextualTime($timestamp) {
        $small_ts = strtotime($timestamp);
        if($small_ts) {
            $large_ts = time();
          $n = $large_ts - $small_ts;
          if($n <= 1) return 'less than 1 second ago';
          if($n < (60)) return $n . ' seconds ago';
          if($n < (60*60)) { $minutes = round($n/60); return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago'; }
          if($n < (60*60*16)) { $hours = round($n/(60*60)); return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago'; }
          if($n < (time() - strtotime('yesterday'))) return 'yesterday';
          if($n < (60*60*24)) { $hours = round($n/(60*60)); return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago'; }
          if($n < (60*60*24*6.5)) return round($n/(60*60*24)) . ' days ago';
          if($n < (time() - strtotime('last week'))) return 'last week';
          if(round($n/(60*60*24*7))  == 1) return 'about a week ago';
          if($n < (60*60*24*7*3.5)) return round($n/(60*60*24*7)) . ' weeks ago';
          if($n < (time() - strtotime('last month'))) return 'last month';
          if(round($n/(60*60*24*7*4))  == 1) return 'about a month ago';
          if($n < (60*60*24*7*4*11.5)) return round($n/(60*60*24*7*4)) . ' months ago';
          if($n < (time() - strtotime('last year'))) return 'last year';
          if(round($n/(60*60*24*7*52)) == 1) return 'about a year ago';
          if($n >= (60*60*24*7*4*12)) return round($n/(60*60*24*7*52)) . ' years ago';
          return false;
        }
        return false;
    }

    /**
     * @return String              Mysql format for friendly time
     */
    static public function getMysqlFormat($friendlyTime) {
      $time = strtotime($friendlyTime);
      return date('Y-m-d H:i:s', $time);
    }
}
