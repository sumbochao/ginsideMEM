<?php
		if(count($cert_type)>0){
			foreach($cert_type as $v){
	?>
    <option value="<?php echo $v['id'];?>" ><?php echo $v['cert_type'];?></option>
    <?php
            }
        }else{
			echo '<option value="0">Chọn bảng app</option>';
		}
    ?>