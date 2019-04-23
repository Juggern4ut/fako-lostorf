<?php
    class coreIcs {

        var $data;
        var $name;
        var $events = array();

        private $data_header;
        private $data_footer;

        function __construct(){
            $this->data_header = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\n";
            $this->data_footer = "END:VCALENDAR\n";
        }

        private function generateData(){
            $this->data = $this->data_header;
            foreach($this->events as $event){
                $this->data .= $event;
            }
            $this->data .= $this->data_footer;
        }

        function addEvent($start,$end,$name,$description="",$location="") {
            $formattedStart = date("Ymd\THis",strtotime($start));
            $formattedEnd = date("Ymd\THis",strtotime($end));
            $timestamp = date("Ymd\THis");
            $description = str_replace(array("&auml;", "&uuml;", "&ouml;"), array("ä", "ü", "ö"), $description);
            $this->events[] = "BEGIN:VEVENT\nDTSTART:".$formattedStart."\nDTEND:".$formattedEnd."\nLOCATION:".$location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:".$timestamp."\nSUMMARY:".$name."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\n";
        }

        function save($filename='events') {
            $this->generateData();
            file_put_contents($filename.".ics",$this->data);
        }

        function show($filename='events') {
            $this->generateData();
            header("Content-type:text/calendar");
            header('Content-Disposition: attachment; filename="'.$filename.'.ics"');
            header('Content-Length: '.strlen($this->data));
            header('Connection: close');
            echo $this->data;
        }
    }
?>