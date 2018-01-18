<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
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
                    <td><?php echo $v['money'];?></td>
                    <td><?php echo $v['silver'];?></td>
                    
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
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'&app='.$_GET['app'].'" title="Xóa">
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
        <?php echo $pages?>
    </form>