<style>
    .comment_pro{
        margin-bottom: 10px;
		color:red;
    }
</style>
<div class="rows rows_json">	
    <div class="input_fields_style input_fields_wrap">
        <div class="btn_morefield" style="display:none">
            <button class="add_field_button btn btn-success">Thêm Promotion</button>
        </div>
	<?php
		if(!empty($items['promotion'])){
            $json_promotion = json_decode($items['promotion'],true);
            if(count($json_promotion)>0){
                $i=0;
                foreach($json_promotion as $key=>$value){
                    $i++;
	?>
        <div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Cấu hình khuyến mãi:</label>
                    <!--<input name="key[<?php //echo $key;?>]" type="text" value="<?php //echo $key;?>">-->
					<select name="key[<?php echo $key;?>]" class="config_pro" onchange="config_pro(this.value)">
						<option value="johnny_raw" <?php echo ($key=='johnny_raw')?'selected="selected"':'';?>>Tân binh (Johnny Raw)</option>
                        <option value="create_time" <?php echo ($key=='create_time')?'selected="selected"':'';?>>Thời gian tạo (Create Time)</option>
						<option value="create_msi" <?php echo ($key=='create_msi')?'selected="selected"':'';?>>Thời gian tạo MSI (Create MSI)</option>
                        <option value="quote" <?php echo ($key=='quote')?'selected="selected"':'';?>>Tổng nạp (Quote)</option>
                        <option value="number" <?php echo ($key=='number')?'selected="selected"':'';?>>Thẻ nạp (Number)</option>
                        <option value="amount" <?php echo ($key=='amount')?'selected="selected"':'';?>>Mệnh giá nạp (Amount)</option>
                        <option value="first" <?php echo ($key=='first')?'selected="selected"':'';?>>User Chưa từng nạp (First)</option>
						<option value="wasrecharge" <?php echo ($key=='wasrecharge')?'selected="selected"':'';?>>User đã nạp (Wasrecharge)</option>
						<option value="firstnonepromo" <?php echo ($key=='firstnonepromo')?'selected="selected"':'';?>>Khuyến mãi nạp lần đầu (Không bao gồm thẻ tháng)</option>
                    </select>
                </div>
                <div class="form-group remove" style="display:none">
                    <span class="color_remove remove_field ">Remove</span>
                </div>
                <div class="clr"></div>
				<div class="comment_pro"></div>
            </div>
            
            <div class="input_fields_wrap_sub_<?php echo $i;?>">
                <div class="btn_morefield subItems">
                    <button onclick="listSubButton(1,<?php echo $i;?>)" class="add_field_button_sub btn btn-warning">Thêm Items</button>
                </div>
                <?php
                    if(count($value)>0){
                        foreach($value as $k=>$v){
                ?>
                <div class="control-group sublistItem">
                    <div class="group1">
                         <div class="form-group">
                             <label class="control-label">Key:</label>
                             <input name="keysub[<?php echo $i;?>][]" type="text" value="<?php echo $k;?>">
                         </div>
                         <div class="form-group">
                             <label class="control-label">Value:</label>
                             <input name="namesub[<?php echo $i;?>][]" type="text" value="<?php echo $v;?>">
                         </div>
                         <div class="form-group remove remove_sub">
                             <span class="remove_field color_remove">Remove</span>
                         </div>
                         <div class="clr"></div>
                     </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>    
    <?php
				}
			}
		}else{
    ?>
		<div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Cấu hình khuyến mãi:</label>
                    <select name="key[1]" class="config_pro" onchange="config_pro(this.value)">
						<option value="johnny_raw">Tân binh (Johnny Raw)</option>
                        <option value="create_time">Thời gian tạo (Create Time)</option>
						<option value="create_msi">Thời gian tạo MSI (Create MSI)</option>
                        <option value="quote">Tổng nạp (Quote)</option>
                        <option value="number">Thẻ nạp (Number)</option>
                        <option value="amount">Mệnh giá nạp (Amount)</option>
                        <option value="first">User Chưa từng nạp (First)</option>
                        <option value="wasrecharge">User đã nạp (Wasrecharge)</option>
						<option value="firstnonepromo">Khuyến mãi nạp lần đầu (Không bao gồm thẻ tháng)</option>
                    </select>
                </div>
                <div style="display:none" class="form-group remove">
                    <span class="color_remove remove_field ">Remove</span>
                </div>
                <div class="clr"></div>
				<div class="comment_pro"></div>
            </div>
            
            <div class="input_fields_wrap_sub_1">
                <div class="btn_morefield subItems">
                    <button class="add_field_button_sub btn btn-warning" onclick="listSubButton(1,1)">Thêm Items</button>
                </div>
            </div>
        </div>
	<?php
		}
	?>
    </div>
</div>
<script>
    //sub item
    var x=1;
    function listSubButton(x,xsub){
        if(x < 100){ //max input box allowed
            x++; //text box increment
            var xhtml="";
            xhtml += '<div class="control-group sublistItem">';
                xhtml +='<div class="group1">';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Key:</label>';
                         xhtml +='<input name="keysub['+xsub+'][]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Value:</label>';
                         xhtml +='<input name="namesub['+xsub+'][]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group remove remove_sub">';
                         xhtml +='<span class="color_remove remove_field">Remove</span>';
                     xhtml +='</div>';
                     xhtml +='<div class="clr"></div>';
                 xhtml +='</div>';
             xhtml +='</div>';
            $('.input_fields_wrap_sub_'+xsub).append(xhtml); //add input box
        }
    }
    
    $(document).ready(function() {
        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        <?php
            if($_GET['id']>0){
        ?>
        var x = <?php echo $i+1;?>;
        <?php
            }else{
        ?>
        var x = 1; //initlal text box count
        <?php
            }
        ?>
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                var xsub = x;
                xsub--;
                xhtml += '<div class="control-group listItem">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Key:</label>';
                             //xhtml +='<input name="key['+xsub+']" type="text" value="a">';
							 xhtml +='<select name="key['+xsub+']" onchange="config_pro(this.value)">\n\
                                        <option value="create_time">Create Time</option>\n\
                                        <option value="quote">Quote</option>\n\
                                        <option value="number">Number</option>\n\
                                        <option value="amount">Amount</option>\n\
                                        <option value="first">First</option>\n\
                                    </select>';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove" style="display:none">';
                             xhtml +='<span class="color_remove remove_field ">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clr"></div><div class="comment_pro"></div>';
                     xhtml +='</div>';
                    xhtml +='<div class="input_fields_wrap_sub_'+xsub+'">';
                        xhtml +='<div class="btn_morefield subItems">';
                            xhtml +='<button onclick="listSubButton(1,'+xsub+')" class="add_field_button_sub btn btn-warning">Thêm Items</button>';
                        xhtml +='</div>';
                    xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper).append(xhtml); //add input box
            }
        });
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
        var id = '<?php echo $_GET['id'];?>';
        var id_config = $(".config_pro").val();
        if(id>0){
            $(".comment_pro").html(config_pro(id_config));
        }else{
            $(".comment_pro").html(config_pro(id_config));
        }
    });
	function config_pro(id){
        var comment = '';
        switch(id){
			case "johnny_raw":
                comment = 'KM apply cho thời gian tạo nhân vật: <br>';
                comment += 'Bao gồm các tham số:<br>';
                comment += '1. enddate: ngày kết thúc sự kiện vd: 2015-10-29 00:00:00<br>';
                comment += '2. day: số ngày nhận được KM kế tiếp. <br>';
                comment += '3. percent: phần trăm KM<br>';
                comment += '4. none: phần trăm nhận nếu hết điều kiện KM (thường none = 0)<br>';
                comment += 'VD: KM 100% 3 ngày đầu cho tạo nhân vật và ngày bắt đầu KM là ngày 21-12-2015<br>';
                comment += 'Khai báo:<br>';
                comment += 'ngày kết thúc KM thời gian kết thúc + thời gian KM + 1 => thời gian kết thúc 28-12-2015<br>';
                comment += 'Key enddate value 2015-12-21 00:00:00 (Y-m-d H:i:s), Key day value 3, Key percent value 100%, Key none value 0'; 
                break;
			case "create_time":
                comment = 'KM apply cho thời gian tạo nhân vật tính từ ngày: <br>';
                comment +='Bao gồm các tham số:<br>';
                comment +='1. date: thời gian tạo nhân vật vd: 2015-10-29 00:00:00<br>';
                comment +='2. percent: nếu thời gian tạo từ date trở về sau nhận phần trăm KM này<br>';
                comment +='3. none: ngược lại nhận KM này (thường none = 0)<br>';
                comment +='4. count: giới hạn số lượng thẻ có thể nhận KM nếu có<br>';
                comment +='VD: Áp dụng cho các tài khoản tạo mới từ ngày 16/02/2016, Mệnh giá nạp [từ 50K trở lên] được KM 200% (Không giới hạn số lần nạp), 10h00 ngày 23/02/2016 Đến 23h59 ngày 26/02/2016<br>';
                break;
			case "create_msi":
                comment = 'KM apply cho thời gian tạo MSI nhân vật tính từ ngày: <br>';
                comment +='Bao gồm các tham số:<br>';
                comment +='1. date: thời gian tạo nhân vật vd: 2015-10-29 00:00:00<br>';
                comment +='2. Số thứ tự thẻ nạp và % KM tương ứng thứ tự thẻ nạp<br>';
				comment +='3. -1 và % KM tương ứng tất cả thứ tự thẻ nạp ngoài các trường hợp trên<br>';
                comment +='4. none: ngược lại % KM không đủ điều kiện KM mãi sẽ nhận KM này (thường none = 0)<br>';
                comment +='5. count: giới hạn số lượng thẻ có thể nhận KM nếu có<br>';
                comment +='VD: Áp dụng cho các tài khoản tạo mới MSI từ ngày 16/02/2016 trở về trước, Mệnh giá nạp [từ 50K trở lên] được KM 200% (Không giới hạn số lần nạp), 10h00 ngày 23/02/2016 Đến 23h59 ngày 26/02/2016<br>';
                break;
            case "quote":
                comment = 'KM apply mức trần nạp:<br>';
                comment += 'Bao gồm các tham số:<br>';
                comment += '1. limit: tổng giá trị nạp.<br>';
                comment += '2. min: mức nạp thấp nhất để nhận được KM.<br>';
                comment += '3. percent: phần trăm nhận nếu đủ điều kiện KM.<br>';
                comment += '4. none: phần trăm sẽ nhận KM nếu không đạt giới hạn nạp.<br>';
                comment += 'VD: KM dành cho user có tổng nạp >= 1 triệu nhận KM 100% nếu mức nạp chưa đủ nhận 50% và chỉ áp dụng cho các user có tổng nạp từ 200k trở lên.<br>';
                comment += 'Khai báo: Key limit value 1000000, Key min value 200000, Key percent value 100, Key none value 50<br>';
                comment += 'Trong trường hợp không có giá trị min thì không ap dụng mức này và chỉ tính trên 1M hoặc dưới 1M, nếu không có giá trị none hoặc none value 0 thì user không đủ điều kiện sẽ không nhận được KM.<br>'; 
                break;
            case "number":
                comment = 'KM theo thứ tự nạp:<br>';
                comment += 'Số thứ tự nạp sẽ nhận KM <br>';
                comment += 'VD: 2 thẻ đầu tiên KM nhận KM 200% tất cả các thẻ còn lại nhận 100% không giới hạn số lượng nạp.<br>';
                comment += 'Khai báo Key 1 value 200, Key 2 value 200, Key = -1 value 100 <br>';
                comment += 'Trong trường hợp không áp dụng cho các thẻ thứ 3 trở đi hoặc có giới hạn số lượng thẻ thì khai báo đầy đủ hoặc Key = -1 value 0'; 
                break;
            case "amount":
                comment = 'KM theo mệnh giá:<br>';
                comment += '1. Key sẽ là mệnh giá nạp và value sẽ là phần trăm nhận KM.<br>';
                comment += '2. Nếu reset bằng true toàn bộ KM sẽ được lập lại khi qua ngày.<br>';
                comment += 'VD: KM cho user nạp thẻ 20k 50%, 50k 100%, 100k 150%<br>';
                comment += 'Khai báo Key 20000 value 50, Key 50000 value 100, Key 100000 value 150'; 
                break;
            case "first":
                comment = 'KM cho user chưa từng nạp.<br>';
                comment += 'Bao gồm:<br>';
                comment += '1. Key thứ tự nạp.<br>';
                comment += '2. Value giá trị (%) nhận KM.<br>';
                comment += '3. Key = -1 không giới hạn số lượng thẻ nạp.<br>';
                comment += '4. Nếu reset bằng true toàn bộ KM sẽ được lập lại khi qua ngày.<br>';
                comment += 'VD: KM 3 thẻ đầu tiên cho user chưa từng nạp thẻ nhận 100%, tất cả các thẻ còn lại nhận 50% không giới hạn.<br>';
                comment += 'Khai báo Key 1 value 100, Key 2 value 100, Key 3 value 100, Key -1 value 50'; 
                break;
			case "firstnonepromo":
                comment = 'KM cho user chưa từng nạp (Không bao gồm thẻ tháng).<br>';
                comment += 'Bao gồm:<br>';
                comment += '1. Key thứ tự nạp.<br>';
                comment += '2. Value giá trị (%) nhận KM.<br>';
                comment += '3. Key = -1 không giới hạn số lượng thẻ nạp.<br>';
                comment += '4. Nếu reset bằng true toàn bộ KM sẽ được lập lại khi qua ngày.<br>';
                comment += 'VD: KM 3 thẻ đầu tiên cho user chưa từng nạp thẻ nhận 100%, tất cả các thẻ còn lại nhận 50% không giới hạn.<br>';
                comment += 'Khai báo Key 1 value 100, Key 2 value 100, Key 3 value 100, Key -1 value 50'; 
                break;
			case "wasrecharge":
				comment = "KM theo thứ tự nạp: chỉ áp dụng cho các tài khoản đã nạp.<br>";
				comment += "Số thứ tự nạp sẽ nhận KM <br>";
				comment += "VD: 2 thẻ đầu tiên KM nhận KM 200% tất cả các thẻ còn lại nhận 100% không giới hạn số lượng nạp.<br>";
				comment += "Khai báo Key 1 value 200, Key 2 value 200, Key = -1 value 100 <br>";
				comment += "Trong trường hợp không áp dụng cho các thẻ thứ 3 trở đi hoặc có giới hạn số lượng thẻ thì khai báo đầy đủ hoặc Key = -1 value 0";
				break;
        }
        $(".comment_pro").html(comment);
    }
</script>