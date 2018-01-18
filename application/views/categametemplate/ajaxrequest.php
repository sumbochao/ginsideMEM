<div class="rows">	
                    <label for="menu_group_id">Yêu cầu</label>
                    <input type="text" name="txt_request" id="txt_request" class="textinput" style="width:500px;" value="<?php echo $item['titles'] ?>" readonly/>
                </div>
                 <div class="rows">	
                    <label for="menu_group_id">Thuộc nhóm</label>
                    <input type="checkbox" name="chk_ios" value="true" <?php echo $item['ios']=="true"?"checked":"";?> />IOS
                    <input type="checkbox" name="chk_android" value="true" <?php echo $item['android']=="true"?"checked":"";?> />Android
                    <input type="checkbox" name="chk_wp" value="true" <?php echo $item['wp']=="true"?"checked":"";?> />WinPhone
                    <input type="checkbox" name="chk_orther" value="true" <?php echo $item['orther']=="true"?"checked":"";?> />None Client(System/inside/web)
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" id="notes" id="notes" cols="30" rows="5" style="width:500px;height:150px;resize:none;" readonly><?php echo stripslashes($item['notes']) ?></textarea>
                </div>
               <div class="rows">
               <label for="menu_group_id">Group thực hiện</label>
            	<?php
				
                            if(count($groupActive)>0){
                                foreach($groupActive as $v){
									
                        ?>
                        <input type="checkbox" name="chk_group_actice[<?php echo $v['id_group'];?>]" id="chk_group_actice_<?php echo $v['id_group'];?>" value="<?php echo $v['id_group'];?>" checked="checked" readonly="readonly" /><?php echo $v['names'];?>
                    <?php
									
								} //end for
							}else{ echo "Không có Group thực hiện";}//end if
					?>
                    </div> <!--rows-->
                <div class="rows">
               <label for="menu_group_id">Group hỗ trợ</label>
            	<?php
				
                            if(count($groupActiveSupport)>0){
                                foreach($groupActiveSupport as $v){
									
                        ?>
                        <input type="checkbox" name="chk_group_actice_support[<?php echo $v['id_group'];?>]" id="chk_group_actice_support_<?php echo $v['id_group'];?>" value="<?php echo $v['id_group'];?>" checked="checked" readonly="readonly" /><?php echo $v['names'];?>
                    <?php
									
								} //end for
							}else{ echo "Không có Group hỗ trợ";}//end if
					?>
                    </div> <!--rows-->
                