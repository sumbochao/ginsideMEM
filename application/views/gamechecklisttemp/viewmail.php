<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css') ?>" />
<style>
    .tblsort tr th{
	background-color:#A25391;
    }
    .tblsort{
        margin-top: 15px;
    }
    .modal-body{
        padding:7px 10px 0;
    }
</style>
<?php
    include("class.php");
    $categories_parent=$catego->ShowCategoriesParent(intval($_GET['id_game']));
    if(count($categories_parent)>0 && $categories_parent != NULL){
        foreach($categories_parent as $c=>$k){
            $cate_child=$catego->ShowCategoriesChild($k['id_game'],$k['id']);
            if(count($cate_child) >0 && !empty($cate_child)){
?>
<form action="" method="post">
    <?php
        echo $Mess;
    ?>
    <table class="table con tblsort" style="display: table;">
        <tbody>
            <?php  
                foreach($cate_child as $c1=>$cc){ 
            ?>
            <tr style="background-color:#D0BA7D;padding-left:50px;">
                <td style="width:400px;" colspan="3"><span style="text-transform: uppercase;text-decoration:none;font-weight:bold;font-size:14px;color: #268ab9"><?php echo $cc['names'];?></span>
                    <h5 style="float:right"><?php echo $catego->CountRequestOfType($k['id_game'],$cc['id'],0,$_GET['cbo_group']);?></h5>
                    <br>Nhóm thực hiện : <strong><?php echo $catego->ShowGroupOnCate($cc['id_game'],$cc['id']); ?></strong>
                </td>
            </tr>
            <tr style="background-color:#D0BA7D;">
                <td style="padding-bottom:0;" colspan="3">
                    <?php
                        $data=$catego->ShowRequestofCate($cc['id_game'],$cc['id']);	
                        $j=0;
                        $img_on="<img boder='0' src='".base_url()."assets/img/tick.png'>";
                        $data_type=array();
                        if(count($data)>0 && $data != NULL){
                    ?>
                    <table class="table request" id="tbltable_requset_890">
                        <tbody>
                            <?php 
                                foreach($data as $i=>$v){
                                    $data_type = array(
                                        0 => $v['android'],
                                        1 => $v['ios'],
                                        2 => $v['wp'],
                                        3 => $v['pc'],
                                        4 => $v['web'],
                                        5 => $v['events'],
                                        6 => $v['systems'],
                                        7 => $v['orther']
                                   );
                            ?>
                            <tr id="res_row_h_2063">
                                <th width="250px" align="center">Yêu cầu</th>
                                <th width="50px" align="center">Loại</th>
                                <th width="250px" align="center">Kết quả <br>mong muốn</th>
                                <th width="120px" align="center">Nhóm <br>thực hiện</th>
                                <th width="120px" align="center">Nhóm hỗ trợ</th>
                                <th width="120px" align="center">Chọn tình trạng</th>
                                <th width="120px" align="center">Người thực hiện<br>ghi chú</th>
                                <th width="150px" align="center">Ngày checklist</th>
                                <th width="120px" align="center">User check</th>
                                <th width="120px" align="center">Admin <br>chọn kết quả</th>
                                <th width="120px" align="center">Ghi chú admin</th>
                            </tr>
                            <?php
                                for($o=0;$o <= count($data_type);$o++){
                                    if($data_type[$o]!="" && !empty($data_type[$o])){
                                        $j++;
                                         $stype_css="";
                                        //neu lọc theo status , chi hiển thị những status được chọn
                                        if($get_statusfrm!=""){
                                            $arr_statu_option=explode(",",$get_statusfrm);
                                            if($btn_filter==1){
                                                    //user
                                                   $sta="'".$v['result_'.$catego->ShowTypesControl($o)]."'";
                                            }elseif($btn_filter==2){
                                                    //admin
                                                   $sta="'".$v['result_admin_'.$catego->ShowTypesControl($o)]."'";
                                            } //end if
                                            $sta=$sta=="''"?"'NULL'":$sta;
                                            $flag = 1;
                                            if(in_array(trim($sta), $arr_statu_option)){
                                                    $flag = 1;
                                            }else{
                                                    $flag = 2;
                                            }
                                           $sta="";
                                        }
                                if($flag==1){
                            ?>
                            <tr id="res_row_2063">
                                <td style="width:400px;">
                                    <span id="a_post_res_<?php echo $v['id']."_".$catego->ShowTypesControl($o);?>" style="color:#268AB9;text-decoration:none;"><?php echo nl2br($v['titles']);?></span>
                                </td>
                                <td><?php echo ViewGroup::ShowTypes($o);?></td>
                                <td><?php echo nl2br($v['admin_request']);?></td>
                                <td><?php echo $catego->CreateControlGroup($v['id_game'],$v['id'],0);?></td>
                                <td><?php echo $catego->CreateControlGroup($v['id_game'],$v['id'],1);?></td>
                                <td>
                                    <div id="ajax_user_check_20631890">
                                        <?php
                                            switch ($v['result_'.$catego->ShowTypesControl($o)]){
                                                case "None":
                                                    echo "None";
                                                    break;
                                                case "Pass":
                                                    echo "Pass";
                                                    break;
                                                case "Fail":
                                                    echo "Fail";
                                                    break;
                                                case "Cancel":
                                                    echo "Cancel";
                                                    break;
                                                case "Pending":
                                                    echo "Pending";
                                                    break;
                                                case "InProccess":
                                                    echo "InProccess";
                                                    break;
                                                default :
                                                    echo "None";
                                                    break;
                                            }
                                        ?>
                                        <div id="show_img_user_20631890">
                                            <?php echo $catego->showimg($v['result_'.$catego->ShowTypesControl($o)],$v['id'].$j.$cc['id'],"user"); ?>                    
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $v['notes_'.$catego->ShowTypesControl($o)]; ?></td>
                                <td><?php echo $v['dateusercheck_'.$catego->ShowTypesControl($o)];?></td>
                                <td><strong><?php echo $slbUser[$v['usercheck_'.$catego->ShowTypesControl($o)]]['username'];?></strong></td>
                                <td>
                                    <?php
                                        switch ($v['result_admin_'.$catego->ShowTypesControl($o)]){
                                            case "None":
                                                echo "None";
                                                break;
                                            case "Pass":
                                                echo "Pass";
                                                break;
                                            case "Fail":
                                                echo "Fail";
                                                break;
                                            case "Cancel":
                                                echo "Cancel";
                                                break;
                                            case "Pending":
                                                echo "Pending";
                                                break;
                                            case "InProccess":
                                                echo "InProccess";
                                                break;
                                            default :
                                                echo "None";
                                                break;
                                        }
                                    ?>
                                    <div id="show_img_admin_20631890">
                                        <?php echo $catego->showimg($v['result_admin_'.$catego->ShowTypesControl($o)],$v['id'].$j.$cc['id'],"admin"); ?>                 
                                    </div>   
                                    <?php echo $slbUser[$v['admincheck']]['username'] ?>
                                    <?php echo $v['dateadmincheck_'.$catego->ShowTypesControl($o)]; ?>
                                </td>
                                <td><?php echo $v['notes_admin_'.$catego->ShowTypesControl($o)]; ?></td>
                                <input type="hidden" name="idp1" value="<?php echo $k['id'];?>"/>
                                <input type="hidden" name="idp2[<?php echo $v['id'];?>]" value="<?php echo $cc['id'];?>"/>
                                <input type="hidden" name="id_game" value="<?php echo $cc['id_game'];?>"/>
                                <input type="hidden" name="id_template" value="<?php echo $cc['id_template'];?>"/>
                                <input type="hidden" name="id_request[<?php echo $v['id'];?>]" value="<?php echo $v['id'];?>"/>
                                <input type="hidden" name="type[<?php echo $v['id'];?>][<?php echo $v['id'].'-'.$j;?>]" value="<?php echo $catego->ShowTypesControl($o);?>"/>
                                <input type="hidden" name="type_account" value="admin"/>
                                <input type="hidden" name="c1" value="<?php echo base64_encode($k['names']);?>"/>
                                <input type="hidden" name="c2[<?php echo $v['id'];?>]" value="<?php echo base64_encode($cc['names']);?>"/>
                                <input type="hidden" name="c3[<?php echo $v['id'];?>]" value="<?php echo $v['titles'];?>"/>
                            </tr>
                            <?php
                                            }
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                        }
                    ?>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <?php
                }
            }
        }
    ?>
    <?php if(ViewGroup::$group_admin==-1){ ?>
    <input type="submit" name="ok" class="btn btn-default btn-success" value="Gửi mail" style="position: absolute;top:0px;right: 20px;"/>
    <?php } ?>
</form>