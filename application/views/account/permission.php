<div class="loading_warning"></div>
<div id="content-t" class="table-hover" style="min-height:500px; padding-top:10px">
    <?php include_once 'include/toolbar.php'; ?>
    <div class="m table_permisssion loadPermisssion">
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
                        <td width="150" align="center"><b>Trạng thái</b>
                            <a style="display:none" href="javascript:;" onclick="loadPermission(this,'<?php echo base_url().'?control=account&func=ajax_permisssion&option=active&type=multi';?>',<?php echo $_GET['id'];?>,<?php echo $table['title']['id'];?>);" title="Bật" >Bật </a> 
                            <a style="display:none" href="javascript:;" onclick="loadPermission(this,'<?php echo base_url().'?control=account&func=ajax_permisssion&option=inactive&type=multi';?>',<?php echo $_GET['id'];?>,<?php echo $table['title']['id'];?>);" title="Tắt">Tắt</a>
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
                                if (@in_array($v['id'], $listCheckedPermisssion)){
                            ?>
                            <a href="javascript:;" onclick="loadPermission(this,'<?php echo base_url().'?control=account&func=ajax_permisssion&option=inactive';?>',<?php echo $_GET['id'];?>,<?php echo $v['id'];?>,'');">
                                <img border="0" alt="Enable" src="<?php echo base_url().'assets/img/tick.png'?>">
                            </a>
                            <?php
                                }else{
                            ?>
                            <a href="javascript:;" onclick="loadPermission(this,'<?php echo base_url().'?control=account&func=ajax_permisssion&option=active';?>',<?php echo $_GET['id'];?>,<?php echo $v['id'];?>,'');">
                                <img border="0" alt="Enable" src="<?php echo base_url().'assets/img/tick2.png'?>">
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
					<?php
                            if($v['per_game']==1){
                                foreach($listGame as $game){
                    ?>
                    <tr>
                        <td align="left" class="title_per">
                            <?php
                                $x = 45 * ($v['level']-1);
                                $css = 'padding-left: ' . $x . 'px;';
                                echo $name = '<div style="' . $css . '">- ' . $game['name'] . '</div>';
                            ?>
                        </td>
                        <td align="center" class="user_permission_<?php echo $_GET['id'].$v['id'].$game['id'];?>">
                            <?php 
                                if (@in_array($game['id'], $listCheckedGamePermisssion[$v['id']])){
                            ?>
                            <a href="javascript:;" onclick="loadPermission(this,'<?php echo base_url().'?control=account&func=ajax_permisssion&option=inactive';?>',<?php echo $_GET['id'];?>,<?php echo $v['id'];?>,<?php echo $game['id'];?>);">
                                <img border="0" alt="Enable" src="<?php echo base_url().'assets/img/tick.png'?>">
                            </a>
                            <?php
                                }else{
                            ?>
                            <a href="javascript:;" onclick="loadPermission(this,'<?php echo base_url().'?control=account&func=ajax_permisssion&option=active';?>',<?php echo $_GET['id'];?>,<?php echo $v['id'];?>,<?php echo $game['id'];?>);">
                                <img border="0" alt="Enable" src="<?php echo base_url().'assets/img/tick2.png'?>">
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                                }
                            }
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
        
        <div class="clr"></div>
    </div>
</div>
<script>
    function loadPermission(element,url,id_user,id_permisssion,id_game){
        $.ajax({
            url:url,
            type:"POST",
            data:{id_user:id_user,id_permisssion:id_permisssion,id_game:id_game},
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(f.error==0){
                    //$(".loadPermisssion").html(f.html);
					var parent = $(element).parent().empty();
                    parent.html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
</script>