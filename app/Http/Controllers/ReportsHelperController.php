<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PublicHolidays;
use App\Leaves;


class ReportsHelperController extends Controller
{
    private $startDate;
    private $endDate;

    private $employee;

    public $publicHolidays;
    private $leaves;

    public $workSummary;
    public $leSummary;
    public $extraSummary;
    public $leavesSummary;

    public function __construct($month,$year,$emp){
        $this->employee = $emp;
        $this->startDate = Carbon::parse('1-'.$month.'-'.$year);
        $this->endDate = Carbon::parse($this->startDate->daysInMonth.'-'.$month.'-'.$year);
        $this->publicHolidays = PublicHolidays::where('date','>=',$this->startDate)->where('date','<=',$this->endDate)->get();

        $this->leaves = Leaves::where('emp_id','=',$this->employee->id)->where('start_date','>=',$this->startDate)->where('end_date','<=',$this->endDate)->get();

        $this->workSummary = array(   
            'work_days' => 0,
            'worked_days' => 0,
            'worked_hours' => 0,
            'working_hours' => 0,
            'short_duty_hours' => 0,
        );
        $this->leSummary = array(
            'late_days' => 0,
            'early_days' => 0,
            'late_hours' => 0,
            'early_hours' => 0,
        );
        $this->extraSummary = array(
            'absent' => 0,
            'holiday' => 0,
            'overtime' => 0,
        );
        $this->leavesSummary = array(
            'casual_leaves' => 0,
            'annual_leaves' => 0,
        );
        
    }

    public function isHoliday($currDate, $sundayCheck = 1){

        if($currDate->dayOfWeek == 0 && $sundayCheck){
            return true;
        }

        foreach($this->publicHolidays as $publicHoliday){
            if($publicHoliday->date == $currDate->format('Y/m/d')){
                return true;
            }
        }
        return false;
    }

    public function getHoliday($currDate){
        
        foreach($this->publicHolidays as $publicHoliday){
            if($publicHoliday->date == $currDate->format('Y/m/d')){
                return $publicHoliday;
            }
        }
    }

    public function isLeave($currDate){

        foreach($this->leaves as $leave){
            if($leave->start_date <= $currDate && $leave->end_date >= $currDate){
                return true;
            }
        }
        return false;

    }


}
