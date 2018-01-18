<?php
	
			if(count($list)>0){
				echo '<option value="0"> --- Chọn --- </option>';
				foreach($list as $v){
	?>
    <option value="<?php echo $v['versions'];?>" <?php echo $items['versions']==$v['versions']?"selected":"";?> ><?php echo $v['versions'];?></option>
    <?php
				
				}//end for
			}else{
				echo '<option value="0"> --- Chọn --- </option>';
			}
		
    ?>