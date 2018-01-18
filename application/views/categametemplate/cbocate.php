 <option value="na"> Hạng mục chính </option>
                       
	<?php
        if(count($parent)>0){
            echo "<optgroup label='Thuộc nhóm'>";
            foreach($parent as $cate){
    ?>
    <?php if($_GET['types']=='edit'){ ?>
    <option value="<?php echo $cate['id'];?>" <?php echo $item['id_parrent']==$cate['id']?"selected":""; ?> ><?php echo $cate['names'];?></option>
    <?php }else{ ?>
    <option value="<?php echo $cate['id'];?>" <?php echo $_GET['idedit']==$cate['id']?"selected":""; ?> ><?php echo $cate['names'];?></option>
    <?php } ?>
    <?php
            }
            echo " </optgroup>";
        }
    ?>