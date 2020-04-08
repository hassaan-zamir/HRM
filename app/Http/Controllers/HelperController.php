<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class HelperController extends Controller
{

    public static function monthOfYear($month){
      $months = ['January','Febuary','March','April','May','June','July','August','September','October','November','December'];
      return $months[$month-1];
    }
    public static function dayOfWeek($day){
      if($day == 0){
        return 'Sunday';
      }else if($day == 1){
        return 'Monday';
      }else if($day == 2){
        return 'Tuesday';
      }else if($day == 3){
        return 'Wednesday';
      }else if($day == 4){
        return 'Thursday';
      }else if($day == 5){
        return 'Friday';
      }else if($day == 6){
        return 'Saturday';
      }
    }
    public static function neverEmpty($str){
      if($str == ''){
        return ' - ';
      }
      return $str;
    }
    public static function employeeCode($e_id){

      if($e_id < 10){
        $e_id = '00'.$e_id;
      }else if($e_id < 100){
        $e_id = '0'.$e_id;
      }
      return $e_id;

    }

    public static function dateWeekFormat($date,$month,$year,$splitter = ' '){
      $carbon = Carbon::parse($date.'-'.$month.'-'.$year);
      $day = substr(\App\Http\Controllers\HelperController::dayOfWeek($carbon->dayOfWeek),0,3);
      if($date<10){
        $date = '0'.$date;
      }
      return $date.$splitter.$day;
    }
    public static function secondsToClock($seconds,$seperator=':',$emptyReturn=0){

      if($seconds == ''){
        if($emptyReturn == 0){
          return '';
        }else{
          return 0;
        }
        
      }
      $hours = floor($seconds/60/60);
      $minutes = floor($seconds/60%60);
      if($hours < 10){
        $hours = '0'.$hours;
      }
      if($minutes<10){
        $minutes = '0'.$minutes;
      }
      return $hours.$seperator.$minutes;
    }


    public static function clockToSeconds($clock){
        $clock = str_replace(':','',$clock);
        if(strlen($clock) !== 4){
            return 0;
        }
        $hours = $clock[0].$clock[1];
        $hours = (int)$hours;
        $minutes = $clock[2].$clock[3];
        $minutes = (int)$minutes;
        $seconds = ($hours*3600)+($minutes*60);
        return $seconds;
    }


    public static function carbonToDate($timestamp){


      $timestamp = Carbon::parse($timestamp);

      $date = $timestamp->day;
      $month = $timestamp->month;
      $year = $timestamp->year;

      return $date.'/'.$month.'/'.$year;
    }

    public static function carbonToTime($timestamp,$seperator=':'){

      $timestamp = Carbon::parse($timestamp);

      $dateTimeString = $timestamp->toDateTimeString();

      $time = explode(' ',$dateTimeString);
      $time = $time[1];
      $time = explode(':',$time);

      return $time[0].$seperator.$time[1];
    }

    public static function floatToTime($float,$addSeconds = 0){

      if($float <= 0){
        return 'N/A';
      }

      $hours = floor($float);
      $mins = floor((60*($float - $hours)));

      if($hours < 10){
        $hours = '0'.$hours;
      }
      if($mins < 10){
        $mins = '0'.$mins;
      }
      if($addSeconds){
        return $hours.':'.$mins.':00';
      }
      return $hours.':'.$mins;

    }

    public static function floatToHours($float){
      if($float <= 0){
        return 0;
      }
      return intval(Date('H',strtotime(\App\Http\Controllers\HelperController::floatToTime($float,1))));
    }

    public static function floatToMinutes($float){
      if($float <= 0){
        return 0;
      }
      return intval(Date('i',strtotime(\App\Http\Controllers\HelperController::floatToTime($float,1))));
    }
}
