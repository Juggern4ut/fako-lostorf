<?php
    class coreIcs {
        var $data;
        var $name;
        function createEvent($start,$end,$name,$description="",$location="") {
            $formattedStart = date("Ymd\THis",strtotime($start));
            $formattedEnd = date("Ymd\THis",strtotime($end));
            $timestamp = date("Ymd\THis");
            $description = str_replace(array("&auml;", "&uuml;", "&ouml;"), array("ä", "ü", "ö"), $description);

            $this->name = $name;
            $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTART:".$formattedStart."\nDTEND:".$formattedEnd."\nLOCATION:".$location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:".$timestamp."\nSUMMARY:".$name."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";
        }

        function save($filename='') {
            $filename = $filename === '' ? $this->name.".ics" : $filename;
            file_put_contents($this->name.".ics",$this->data);
        }
        
        function show() {
            header("Content-type:text/calendar");
            header('Content-Disposition: attachment; filename="'.$this->name.'.ics"');
            header('Content-Length: '.strlen($this->data));
            header('Connection: close');
            echo $this->data;
        }
    }
?>