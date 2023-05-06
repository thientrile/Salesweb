<?php
class statistics
{
    var $AreaNames = array();
    var $AreaValues = array();
    function AreaChart($year = "", $month = "")
    {
        $db = new connect();
    if($year==""&&$month==""){

        for ($i = date("Y") - 4; $i <= date("Y"); $i++) {
            array_push($this->AreaNames,$i);
            $select= "SELECT SUM(total) FROM `order` WHERE YEAR(date_order)=".$i;
            $result=$db->getonce($select)[0];
            array_push($this->AreaValues, $result==null?0: $result);

        }
    }
     else   if($year!=""&&$month==""){
        $M=12;
        if($year==date("Y")){
                $month_year_array = explode('-', date("Y-m"));
               
                $M = $month_year_array[1];
        }
            for($i=1;$i<= $M;$i++){
                array_push($this->AreaNames, $i);
                $select = "SELECT SUM(total) FROM `order` WHERE YEAR(date_order)=" . $year." AND MONTH(date_order)=".$i;
                $result = $db->getonce($select)[0];
                array_push($this->AreaValues, $result == null ? 0 : $result);
            }
        }
        else  if($year!=""&&$month!=""){
            $days= cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($i = 1; $i <= $days; $i++) {
                array_push($this->AreaNames, $i);
                $select = "SELECT SUM(total) FROM `order` WHERE YEAR(date_order)=$year AND MONTH(date_order)=$month AND DAY(date_order)=$i";
                $result = $db->getonce($select)[0];
                array_push($this->AreaValues, $result == null ? 0 : $result);
            }
        }

    }
}
