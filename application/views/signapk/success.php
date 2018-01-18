<div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:3000px;">
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                   <!-- <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>-->
                    
                    <th align="center" width="100px">EditPublished</th>
                    <th align="center" width="210px">Date Create</th>
                    <th align="center" width="200px">Game</th>
                    <th align="center" width="200px">PackageName</th>
                    <th align="center" width="200px">VersionName</th>
                    <th align="center" width="200px">VersionCode</th>
                    <th align="center" width="150px">Bảng app</th>
                    <th align="center" width="450px">APK Signed</th>
                    <th align="center" width="150px">Channel</th>
                    <th align="center" width="150px">MSV</th>
                    <th align="center" width="150px">Link download</th>
                    <th align="center" width="100px">Xem log</th>
                    <th align="center" width="300px">Ghi chú</th>
                    <th align="center" width="100px">User</th>
                    <th align="center" width="100px">Xóa</th>
                    <th align="center">ID</th>
                    <th>Published</th>
                </tr>
            </thead>
            <tbody>
                <tr id="rows_0" class="rows_class">
                    <!--<td><input type="checkbox" value="<?php echo $viewitem['rs']['id'];?>" id="cid[<?php echo $viewitem['rs']['id'];?>]" name="cid[]"></td>-->
                    
                    <td>
                    <select name="cbo_published" id="cbo_published" style="width:80px;" onchange="updatepublished(<?php echo $viewitem['rs']['msv_id'] ?>,<?php echo $viewitem['rs']['id'] ?>,this.value);">
                            <option value="0">Published</option>
                            <option value="no" <?php echo $viewitem['rs']['published']=='no'?"selected":""; ?>>No</option>
                            <option value="yes" <?php echo $viewitem['rs']['published']=='yes'?"selected":""; ?>>Yes</option>
                            <option value="waiting" <?php echo $viewitem['rs']['published']=='waiting'?"selected":""; ?>>Waiting</option>
                            <option value="cancel" <?php echo $viewitem['rs']['published']=='cancel'?"selected":""; ?>>Cancel</option>
                        </select> 
                        <div id="messinfo_<?php echo $viewitem['rs']['id'] ?>" style="font-size:10px"></div>
                    </td>
                    <td><?php echo $viewitem['rs']['datecreate'];?></td>
                    <td style="text-align:left" title="<?php echo $viewitem['rs']['games'];?>"><?php echo $viewitem['rs']['games'];	?>   <a href="<?php echo $viewitem['rs']['links_signed'];?>">Tải file apk</a></td>
                    <td><strong ><?php echo $viewitem['rs']['package_name'];?></strong></td>
                    <td><strong ><?php echo $viewitem['rs']['version_name'];?></strong></td>
                    <td><strong ><?php echo $viewitem['rs']['version_code'];?></strong></td>
                    <td><strong style="color:<?php echo $viewitem['rs']['type_app']=="Appstore"?"#036":"#903"; ?>" ><?php echo $viewitem['rs']['type_app'];?></strong></td>
                    <td><?php echo $viewitem['rs']['filenames_signed'];?></td>
                    <td><?php echo $viewitem['rs']['channels'];?></td>
                    <td><strong style="color:#900"><?php $rr=explode("|",$viewitem['rs']['channels']);
							$rrr=explode("_",$rr[4]); echo "msv_".$rrr[1];?></strong></td>
                    <td><a href="<?php echo $viewitem['rs']['links_signed'];?>">Tải file apk</a></td>
                    <td>
                    <!--<a href="javascript:void(0)" onclick="popitup('<?=base_url()."popup_android.php?id=".$viewitem['rs']['id'];?>','Xem log');">Xem</a>-->
                    <a href="javascript:void(0)" onclick="popitup('<?=$viewitem['rs']['logs'];?>','Xem log');">Xem</a>
                    </td>
                    <td>
                    <textarea name="notes" id="notes" cols="5" role="3" onchange="updatenotes(<?php echo $viewitem['rs']['id'] ?>,this.value);"><?php echo $viewitem['rs']['notes']; ?></textarea></td>
                 <td><?php echo $slbUser[$viewitem['rs']['userid']]['username'];?></td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                           
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$viewitem['rs']['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$viewitem['rs']['id'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            echo $btnDelete;
                        ?>
                        
                        
                    </td>
                    
                    <td><?php echo $viewitem['rs']['id'];?></td>
                    <td><?php echo $viewitem['rs']['published']; ?></td>
                </tr>
             
            </tbody>
        </table>
          </div> <!--scroolbar-->
        </div><!-- wrapper_scroolbar -->