<?php 
if($generalInfo["isStraight"]){
    echo $this->element("Printview/straight",$generalInfo);
}else if($generalInfo["isParlay"]){
    echo $this->element("Printview/parlay",$generalInfo);
}
?>