<?php
	
			if(count($list)>0){
				echo '<option value="0"> --- Chọn --- </option>';
				foreach($list as $v){
	?>
    <option value="<?php echo $v['bundleidentifier'];?>" ><?php echo $v['bundleidentifier'];?></option>
    <?php
				
				}//end for
			}else{
				echo '<option value="0"> --- Chọn --- </option>';
			}
		
    ?>