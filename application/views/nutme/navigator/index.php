<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<style>
    .ordertext{
        background:none !important;
        border: 0px !important;
        box-shadow:none !important;
    }
</style>
<?php
	if($_SESSION['permission']['tethien3d']=='tethien3d'){
		$_SESSION['permission']['tethien'] = 'tethien';
	}
?>
<div class="loading_warning"></div>
<div id="content-t" class="loadNavigator" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
            <select name="slbGame" onchange="listingRedirectUrl('1','<?php echo base_url().'?control='.$_GET['control'].'&func=index';?>',$(this),this.value)">
                <option value="0">Chọn game</option>
                <?php
                    if(count($slbGame)>0){
                        foreach($slbGame as $v){
							
							if((@in_array($v['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="<?php echo $v['alias'];?>" <?php echo ($v['alias']==$_GET['idgame'])?'selected="selected"':'';?>><?php echo $v['game'];?></option>
                <?php
							}
                        }
                    }
                ?>
            </select>
        </div>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center">Title</th>
                    <th align="center" width="250px">Link</th>
                    <th align="center" width="70px">Author</th>
                    <th align="center" width="60px">Status</th>
                    <th align="center" width="60px">Order</th>
                    <th align="center" width="145px">Start</th>
                    <th align="center" width="145px">End</th>
                    <th align="center" width="60px">Module</th>
                    <th align="center" width="50px">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($_GET['page']>0){
                        $page = '&page='.$_GET['page'];
                    }
                    if(!empty($_GET['idgame'])){
                        $game = '&idgame='.$_GET['idgame'];
                    }
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['service_id'];?>" id="cid" name="cid[]"></td>
                    <td>
                        <?php
							
                            $linkService = $urlService.'/navigator_ginside/titlelang?id='.$v['service_id'].'&lang='.$language;
                            $j_itemsTitle = file_get_contents($linkService);
                            $itemsTitle = json_decode($j_itemsTitle,true);
                            if(!empty($itemsTitle['title'])){
                                echo $itemsTitle['title'];
                            }else{
                                $linkEvent = $urlService.'/navigator_ginside/getItem?id='.$v['service_id'];
                                $j_itemsTitle = file_get_contents($linkEvent);
                                $itemsTitle = json_decode($j_itemsTitle,true);
                                echo $itemsTitle['service_title'];
                            }
							//echo $v['service_title'];
                        ?>
                    </td>
                    <td><?php echo $v['service_url'];?></td>
                    <td><?php echo $v['service_author'];?></td>
                    <td>
                        <?php
                            $imgActive = ($v['service_status']=='true')?'active.png':'inactive.png';

                            $lnkActive = base_url()."?control=".$_GET['control']."&func=status&id=".$v['service_id']."&s=".$v['service_status'].$game.$page;
                            echo '<a href="'.$lnkActive.'" title="Duyệt">
                                    <img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                    </td>
                    <td>
                        <input type="hidden" name="listid[]" value="<?php echo $v['service_id'];?>" />
                        <input type="text" value="<?php echo ($i)+($pageInt);?>" name="listorder[]" id="listorder_<?php echo $i?>" class="ordertext">
                    </td>
                    <td>
                        <?php 
                            echo $v['service_start'];
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo $v['service_end'];
                        ?>
                    </td>
                    <td>
                        <?php
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['service_id'].$game.$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['title'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['service_id'].$game.$page.'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            echo $btnEdit.' '.$btnDelete;
                        ?>


                    </td>
                    <td><?php echo $v['service_id'];?></td>

                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <?php echo $pages?>
    </form>
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
    function listingRedirectUrl(ajax_config,url_value,current,idgame){
        if(ajax_config!=1){
            window.location.href=url_value+'&idgame='+idgame;
        }else{
            var baseUrl=url_value+'&idgame='+idgame;
            var call_data={ajax_active:"1"};
            var arrFirst=url_value.split('?');
            var arrFinal=arrFirst[1].split('&');
            for(var i in arrFinal){
                if(arrFinal[i]=='ajax=1'){
                    arrFinal.splice(i,1);break;
                }
            }
            jQuery.ajax({
                type:"POST",
                url:baseUrl,
                data:call_data,
                dataType:'html',
                beforeSend:function(){
                    jQuery('.loading_warning').show();
                },
                success:function(html){
                    jQuery('.loadNavigator').html(html);
                    if(idgame==0){
                        window.history.pushState("","","?"+arrFinal.join("&"));
                    }else{
                        window.history.pushState("","","?"+arrFinal.join("&")+'&idgame='+idgame);
                    }
                    jQuery('.loading_warning').hide();
                }
            });
        }
    }
</script>