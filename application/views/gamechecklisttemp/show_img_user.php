<?php
function showimg_user($value,$id){
		switch($value){
				case "None":
				echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick2.png'>"; 
				break;
				case "Pass":
				echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick.png' style='width:14px;height:14px' />"; 
				break;
				case "Fail":
				echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/exclamation.gif' style='width:14px;height:14px' />"; 
				break;
				case "Pending":
				echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/wait.png' style='width:14px;height:14px' />"; 
				break;
				case "Cancel":
				echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png'>"; 
				break;
				case "InProccess":
				echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/process.png'>"; 
				break;
				default:
				echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick2.png'>"; 
				break;
						}//end switch
}//end func
showimg_user($result_client['result_'.$types],$idunique);
?>