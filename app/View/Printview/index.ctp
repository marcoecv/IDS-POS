<?php 
switch ($generalInfo["type"]){
    case "STRAIGHT":
    case "MONEY LINE":
    case "TOTAL POINTS":
    case "TEAM POINTS":
    case "CONTEST":
        echo $this->element("Printview/betTickets/straight",$generalInfo);
        break;
    case "PARLAY":
        echo $this->element("Printview/betTickets/parlay",$generalInfo);
        break;
    case "TEASER":
        echo $this->element("Printview/betTickets/teaser",$generalInfo);
        break;
}
?>