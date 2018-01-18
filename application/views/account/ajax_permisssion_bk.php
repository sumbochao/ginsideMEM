<?php 
    if(count($listModule)>0){
		$i=0;
        foreach($listModule as $listtable){
?>
    <table cellspacing="0" cellpadding="3" border="0">
		<?php
			foreach($listtable as $table){
				$i++;
		?>
        <thead>
            <tr>
                <td width="300" align="left"><span><span class="baiviet"><?php echo $i.') '.$table['title']['name'];?> :</span></span><a name="article"></a></td>
                <td width="150" align="center" class="baiviet">
                    <a href="javascript:;" onclick="loadPermission('<?php echo base_url().'?control=account&func=ajax_permisssion&option=active&type=multi';?>',<?php echo $id_user;?>,<?php echo $table['title']['id'];?>);" title="Bật" >Bật </a> / 
                    <a href="javascript:;" onclick="loadPermission('<?php echo base_url().'?control=account&func=ajax_permisssion&option=inactive&type=multi';?>',<?php echo $id_user;?>,<?php echo $table['title']['id'];?>);" title="Tắt">Tắt</a>
                </td>
            </tr>
        </thead>
        <?php
            if(count($table['data'])>0){
        ?>
        <tbody>
            <?php
                foreach($table['data'] as $v){
            ?>
            <tr>
                <td align="left" class="title_per">
					<?php
						if($v['level'] == 1){
							$name = '<div>+ ' . $v['name'] . '</div>';
						}else{
							$x = 25 * ($v['level']-1);
							$css = 'padding-left: ' . $x . 'px;';
							$name = '<div style="' . $css . '">- ' . $v['name'] . '</div>';
						}
						echo $name;
					?>
				</td>
                <td align="center">
                    <?php 
                        if (in_array($v['id'], $listCheckedPermisssion)){
                    ?>
                    <a href="javascript:;" onclick="loadPermission('<?php echo base_url().'?control=account&func=ajax_permisssion&option=inactive';?>',<?php echo $id_user;?>,<?php echo $v['id'];?>);">
                        <img border="0" alt="Enable" src="<?php echo base_url().'assets/img/tick.png'?>">
                    </a>
                    <?php
                        }else{
                    ?>
                    <a href="javascript:;" onclick="loadPermission('<?php echo base_url().'?control=account&func=ajax_permisssion&option=active';?>',<?php echo $id_user;?>,<?php echo $v['id'];?>);">
                        <img border="0" alt="Enable" src="<?php echo base_url().'assets/img/tick2.png'?>">
                    </a>
                    <?php } ?>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
        <?php } ?>
		<?php } ?>
    </table>
<?php
        }
    }
?>