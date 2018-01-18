<?php
		if($platform=="ios"){
			if(count($list)>0){
				echo '<option value="0">Chọn bảng app</option>';
				foreach($list as $v){
					if($cert_type[$v['cert_id']]['cert_type']!="AppstoreDev"){
	?>
    <option value="<?php echo $v['cert_id'];?>" <?php echo trim($certid)==$v['cert_id']?"selected":""; ?> ><?php echo $cert_type[$v['cert_id']]['cert_type']."-".$partner[$v['idpartner']]['partner'];?></option>
    <?php
					}
				
				}//end for
			}else{
				echo '<option value="0">Chọn bảng app</option>';
			}
		}
		if($platform=="android"){
	?>
			<option value="0">Chọn bảng app</option>
			<option value='1' <?php echo trim($certid)==1?"selected":""; ?>>GooglePlay</option>
		    <option value='3' <?php echo trim($certid)==3?"selected":""; ?>>Inhouse</option>
			
    <?php
		}
		if($platform=="wp"){
	?>
			<option value="0">Chọn bảng app</option>    
			<option value='1' <?php echo trim($certid)==1?"selected":""; ?>>WinStore</option>
		    <option value='3' <?php echo trim($certid)==3?"selected":""; ?>>Inhouse</option>
	<?php
		}
    ?>