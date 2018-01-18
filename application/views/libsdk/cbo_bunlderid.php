<?php
	
			if(count($list)>0){
				echo '<option value="0"> --- Chọn --- </option>';
				foreach($list as $v){
	?>
    <option value="<?php echo $v['package_name'];?>" <?php echo $itemview['package_name']==$v['package_name']?"selected":"";?> ><?php echo $v['package_name'];?></option>
    <?php
				
				}//end for
			}else{
				echo '<option value="0"> --- Chọn --- </option>';
			}
		
    ?>