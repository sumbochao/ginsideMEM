<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<style>
    .ordertext{
        background:none !important;
        border: 0px !important;
        box-shadow:none !important;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" class="loadNavigator" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
            <select name="slbApp" class="chosen-select" tabindex="2" onchange="listingRedirectUrl('1','<?php echo base_url().'?control='.$_GET['control'].'&func=index&module=all';?>',$(this),this.value)">
                <option value="0">Chọn app</option>
                <?php
                    if(count($appGame['data'])>0){
                        foreach($appGame['data'] as $v){
                            $description = trim($v['description']);
                            if(!empty($description)){
                                if((@in_array($v['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="<?php echo $v['app'];?>" <?php echo ($v['app']==$_GET['app'])?'selected="selected"':'';?>><?php echo $v['description'];?></option>
                <?php
                                }
                            }
                        }
                    }
                ?>
            </select>
            <script type="text/javascript">
                var config = {
                  '.chosen-select'           : {},
                  '.chosen-select-deselect'  : {allow_single_deselect:true},
                  '.chosen-select-no-single' : {disable_search_threshold:10},
                  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                  '.chosen-select-width'     : {width:"95%"}
                }
                for (var selector in config) {
                  $(selector).chosen(config[selector]);
                }
          </script>
        </div>
        <table style="margin-top:10px" width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th align="center">Alias</th>
                    <th align="center" width="100px">APP</th>
                    <th align="center" width="150px">Money</th>
                    <th align="center" width="150px">Silver</th>                    
                    <th align="center" width="150px">Status</th>
                    <th align="center" width="100px">Chức năng</th>
                    <th align="center" width="100px">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($_GET['page']>0){
                        $page = '&page='.$_GET['page'];
                    }
                    if(!empty($_GET['app'])){
                        $app = '&app='.$_GET['app'];
                    }
                    if(empty($listItems['data']) !== TRUE){
                        foreach($listItems['data'] as $i=>$v){
                ?>
                <tr>
                    <td><?php echo $v['alias'];?></td>
                    <td><?php echo $v['app'];?></td>
                    <td><?php echo $v['money']>0?number_format($v['money'],0,',','.'):'0';?></td>
                    <td><?php echo $v['silver']>0?number_format($v['silver'],0,',','.'):'0';?></td>
                    
                    <td>
                        <?php
                            $imgActive = ($v['status']=='1')?'active.png':'inactive.png';
                            echo '<a title="Duyệt">
                                    <img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                    </td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&module=all&id=".$v['id'].'&app='.$_GET['app'].$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa dữ liệu này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'&app='.$_GET['app'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            echo $btnEdit.' '.$btnDelete;
                        ?>
                        
                        
                    </td>
                    <td><?php echo $v['id'];?></td>
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
    </form>
</div>
<script type="text/javascript">
    function listingRedirectUrl(ajax_config,url_value,current,app){
        if(ajax_config!=1){
            window.location.href=url_value+'&app='+app;
        }else{
            var baseUrl=url_value+'&app='+app;
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
                    if(app==0){
                        window.history.pushState("","","?"+arrFinal.join("&"));
                    }else{
                        window.history.pushState("","","?"+arrFinal.join("&")+'&app='+app);
                    }
                    jQuery('.loading_warning').hide();
                }
            });
        }
    }
</script>