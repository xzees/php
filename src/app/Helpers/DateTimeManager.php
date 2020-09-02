<?php

namespace App\Helpers;


class DateTimeManager
{
    public static function dateForApi()
    {
      $t = microtime(true);
      $micro = sprintf("%06d",($t - floor($t)) * 1000000);
      $d = new \DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
      return $d->format("Y-m-d H:i:s.u");
    }

    public static function ThaiDateTimeFormat($datetime, $showtime = "time", $lang = "th", $format = "full")
    {
      
      $m = DateTimeManager::get_month($lang, $format);
      
      $thai_month_full = $m;
      $thai_year = ($lang == 'th') ? 543 : 0;
      $extc = explode(' ', $datetime);
      $date = $extc[0];
      $time = $extc[1];
      if (DateTimeManager::validateDate($date, 'Y-m-d')) {
        $data = explode('-', $date);
        $thai_date = (int) $data[2] . ' ' . $thai_month_full[$data[1]] . ' ' . ($data[0] + $thai_year);
      } else if (DateTimeManager::validateDate($date, 'd-m-Y')) {
        $data = explode('-', $date);
        $thai_date = (int) $data[0] . ' ' . $thai_month_full[$data[1]] . ' ' . ($data[2] + $thai_year);
      } else if (DateTimeManager::validateDate($date, 'd/m/Y')) {
        $data = explode('/', $date);
        $thai_date = (int) $data[0] . ' ' . $thai_month_full[$data[1]] . ' ' . ($data[2] + $thai_year);
      }
      if ($showtime == 'notime') { // not display time
        return $thai_date;
      } else {
        return $thai_date . ' ' . $time;
      }
    }

    public static function get_month($lang = "th", $format = "full")
    {
      if ($lang == 'th') {
        if ($format == 'full') {
          return array(
            "01" => "มกราคม",
            "02" => "กุมภาพันธ์",
            "03" => "มีนาคม",
            "04" => "เมษายน",
            "05" => "พฤษภาคม",
            "06" => "มิถุนายน",
            "07" => "กรกฎาคม",
            "08" => "สิงหาคม",
            "09" => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม"
          );
        } else { //-- short
          return array(
            "01" => "ม.ค.",
            "02" => "ก.พ.",
            "03" => "มี.ค",
            "04" => "เม.ย.",
            "05" => "พ.ค.",
            "06" => "มิ.ย.",
            "07" => "ก.ค.",
            "08" => "ส.ค.",
            "09" => "ก.ย.",
            "10" => "ต.ค.",
            "11" => "พ.ย.",
            "12" => "ธ.ค."
          );
        }
      }
      if ($lang == 'en') {
        if ($format == 'full') {
          return array(
            "01" => "January",
            "02" => "February",
            "03" => "March",
            "04" => "April",
            "05" => "May",
            "06" => "June",
            "07" => "July",
            "08" => "August",
            "09" => "September",
            "10" => "October",
            "11" => "November",
            "12" => "December"
          );
        } else { //-- short
          return array(
            "01" => "JAN",
            "02" => "FEB",
            "03" => "MAR",
            "04" => "APR",
            "05" => "MAY",
            "06" => "JUN",
            "07" => "JUL",
            "08" => "AUG",
            "09" => "SEP",
            "10" => "OCT",
            "11" => "NOV",
            "12" => "DEC"
          );
        }
      }
    }

    public static function validateDate($date, $format = 'Y-m-d H:i:s') {
      $d = \DateTime::createFromFormat($format, $date);
      return $d && $d->format($format) == $date;
    }
}
