<?php

class coreCalendar {  
	 
	private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
	private $month = 0;
	private $year = 0;
	private $daysInMonth = 0;
	private $weeksInMonth = 0;
	private $events = array();
	private $eventLink = "";
	private $dayLink = "";
	private $hasNav = false;
	
	public function __construct($month = null, $year = null){
		if(isset($_SESSION["calendarMonth"]) && isset($_SESSION["calendarYear"])){
			$this->month = $_SESSION["calendarMonth"];
			$this->year = $_SESSION["calendarYear"];
		}else{
			$this->month = $month == null ? date("m", strtotime("now")) : $month;
			$this->year = $year == null ? date("Y", strtotime("now")) : $year;
			$_SESSION["calendarMonth"] = $this->month;
			$_SESSION["calendarYear"] = $this->year;
		}
		$this->daysInMonth = $this->_daysInMonth();
		$this->weeksInMonth = $this->_weeksInMonth();
	}

	public function addNavigation(){
		$this->hasNav = true;
	}

	public function addEventClick($event, $async=false){
		$this->eventLink = $event;
	}

	public function addDayClick($event, $async=false){
		$this->dayLink = $event;
	}

	public function show() {

		if($this->hasNav){
			echo "<div class=\"calendar-nav\">";
				echo "<label class=\"prevMonth\"></label>";
				echo "<label>".date("F Y", strtotime($this->year."-".$this->month))."</label>";
				echo "<label class=\"nextMonth\"></label>";
			echo "</div>";
		}

		echo "<div class=\"calendar\">";

			foreach ($this->dayLabels as $day) {
				echo "<div class=\"calendar-header\">".$day."</div>";
				$count++;
			}

			for( $i=0; $i<$this->weeksInMonth; $i++ ){
				for($j=1;$j<=7;$j++){
					echo $this->_showDay($i*7+$j);
				}
			}

		echo "</div>";
		
	}

	public function addEvent($startDate, $endDate, $startTime, $endTime, $name, $id=0, $color="red", $allDay = false){
		$this->events[] = array("startDate"=>$startDate, "endDate"=>$endDate, "startTime"=>$startTime, "endTime"=>$endTime, "name"=>$name, "id"=>$id, "color"=>$color, "allDay"=>$allDay);
	}

	private function _weeksInMonth(){
		$daysInMonths = $this->_daysInMonth($this->month,$this->year);
		$numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
		$monthEndingDay= date('N',strtotime($this->year.'-'.$this->month.'-'.$daysInMonths));
		$monthStartDay = date('N',strtotime($this->year.'-'.$this->month.'-01'));
		if($monthEndingDay<$monthStartDay){
			$numOfweeks++;
		}
		return $numOfweeks;
	}
 
	private function _daysInMonth(){
		return date('t',strtotime($this->year.'-'.$this->month.'-01'));
	}

	private function _showDay($cellNumber){

		if($this->currentDay==0){
			$firstDayOfTheWeek = date('N',strtotime($this->year.'-'.$this->month.'-01'));
			if(intval($cellNumber) == intval($firstDayOfTheWeek)){
				$this->currentDay=1;
			}
		}
		 
		if(($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth)){
			$this->currentDate = date('Y-m-d',strtotime($this->year.'-'.$this->month.'-'.($this->currentDay)));
			$cellContent = $this->currentDay;
			$this->currentDay++;   
		}else{
			$this->currentDate = null;
			$cellContent=null;
		}

		$class = $cellContent != null ? " not_empty" : " empty";
		$class .= $this->currentDate == date("Y-m-d") ? " today" : "";
		if($cellContent != null){

				if($this->dayLink != ""){
					$dayUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&".$this->dayLink."=".$this->currentDate;
					$output = "<div onclick=\"window.location.href='".$dayUrl."'\" class=\"calendar-day".$class."\">";
				}else{
					$output = "<div class=\"calendar-day".$class."\">";
				}
				
					$output .= "<label>".$cellContent."</label>";
					foreach ($this->events as $id=>$event) {
						if(($event["startDate"] == $this->currentDate) || (strtotime($event["startDate"]) < strtotime($this->currentDate) && strtotime($event["endDate"]) >= strtotime($this->currentDate))){

							$isWide = strtotime($event["startDate"]) < strtotime($this->currentDate) && strtotime($event["endDate"]) >= strtotime($this->currentDate) ? " wide" : "";
							$eventUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&".$this->eventLink."=".$event["id"];
							$smallClass = $event["allDay"] || $event["startDate"] != $event["endDate"] ? "" : " small";

							$output .= "<div class=\"calendar-event".$isWide.$smallClass."\" title=\"".$event["name"]."\" style=\"background-color: ".$event["color"]."\">";
							
								if($this->eventLink != ""){
									$output .= "<a href=\"".$eventUrl."\">";
										if($event["allDay"] || $event["startDate"] != $event["endDate"]){
											$output .= $event["name"];
										}else{
											$output .= "<label class=\"calendar-color\" style=\"background-color: ".$event["color"]."\">&nbsp;</label>";
											$output .= date("H:i", strtotime($event["startTime"]))." - ".$event["name"];
										}
									$output .= "</a>";
								}else{
									$output .= $event["name"];
								}

							$output .= "</div>";
						}
					}

				$output .= "</div>";

			return $output;

		}else{
			return "<div class=\"calendar-day".$class."\"></div>";
		}
	}
	 
}