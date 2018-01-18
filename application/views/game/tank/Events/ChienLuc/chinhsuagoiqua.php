<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
    </style>
    <script type="text/javascript">
        var id = getParameterByName("id");
        var type = getParameterByName("type");

        $(document).ready(function () {
            $("#startdate").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});
            $("#enddate").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});

            $('#comeback').on('click', function () {
                if (type != null && type != "") {
                    window.location.href = '/?control=chienluc_tank&func=quanlygoiqua&type=' + type + "&module=all#quanlygoiqua";
                }
                else {
                    window.location.href = '/?control=chienluc_tank&func=quanlygoiqua&module=all#quanlygoiqua';
                }
            });

            //Load Gift Type
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/tank/cms/toolchienluc/gift_type_list_pakage",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = '';
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["type_name"] + '</option>';
                    });

                    $("#gifttype").html(tourlist);
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
            
            load_gift_pakage_details(id);
        });
        
        function load_gift_pakage_details(id){
            //Load Gift Details            
            if (id != null && id != "") {
                $.ajax({
                    method: "GET",
                    url: "http://game.mobo.vn/tank/cms/toolchienluc/load_gift_pakage_details?id=" + id,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#id").val(data[0]["id"]);
                        $("#gift_name").val(data[0]["gift_name"]);
                        $("#gift_price").val(data[0]["gift_price"]);
                        $("#gift_img").attr('src', data[0]["gift_img"]);
                        $("#gift_img_text").val(data[0]["gift_img"]);
                        $("#server_list").val(data[0]["server_list"]);
                        $("#gifttype").val(data[0]["gift_type"]);
                        $("#gift_buy_max").val(data[0]["gift_buy_max"]);

                        var gift_date_start = null;
                        if (data[0]["gift_date_start"] != "" && data[0]["gift_date_start"] != null) {
                            gift_date_start = new Date(data[0]["gift_date_start"]);
                        }

                        var gift_date_end = null;
                        if (data[0]["gift_date_end"] != "" && data[0]["gift_date_end"] != null) {
                            gift_date_end = new Date(data[0]["gift_date_end"]);
                        }

                        $("#startdate").jqxDateTimeInput('setDate', gift_date_start);
                        $("#enddate").jqxDateTimeInput('setDate', gift_date_end);
                        $("#gift_vip_point").val(data[0]["gift_vip_point"]);
                        $("#gift_number_request").val(data[0]["gift_number_request"]);
                        $("#reward_item1_code").val(data[0]["reward_item1_code"]);
                        $("#reward_item1_number").val(data[0]["reward_item1_number"]);
                        $("#reward_item1_type").val(data[0]["reward_item1_type"]);
                        $("#reward_item2_code").val(data[0]["reward_item2_code"]);
                        $("#reward_item2_number").val(data[0]["reward_item2_number"]);
                        $("#reward_item2_type").val(data[0]["reward_item2_type"]);
                        $("#reward_item3_code").val(data[0]["reward_item3_code"]);
                        $("#reward_item3_number").val(data[0]["reward_item3_number"]);
                        $("#reward_item3_type").val(data[0]["reward_item3_type"]);
                        $("#reward_item4_code").val(data[0]["reward_item4_code"]);
                        $("#reward_item4_number").val(data[0]["reward_item4_number"]);
                        $("#reward_item4_type").val(data[0]["reward_item4_type"]);
                        $("#reward_item5_code").val(data[0]["reward_item5_code"]);
                        $("#reward_item5_number").val(data[0]["reward_item5_number"]);
                        $("#reward_item5_type").val(data[0]["reward_item5_type"]);
                        if (data[0]["gift_status"] == 1) {
                            $('#gift_status_enable').prop('checked', true);
                        }
                        else {
                            $('#gift_status_disable').prop('checked', true);
                        }
                    },
                    error: function (data) {
                        var obj = $.parseJSON(data);
                    }
                });
            }
        }

        $(function () {
            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    load_gift_pakage_details();
                    $(".loading").fadeOut("fast");
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
            return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/tank/Events/ChienLuc/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=chienluc_tank&func=edit_gift_pakage&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">  
                        <div class="control-group">
                            <label class="control-label">Loại quà:</label>
                            <div class="controls">
                                <select id="gifttype" name="gifttype" class="span4 validate[required]"></select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tên quà:</label>
                            <div class="controls">
                                <input name="gift_name" id="gift_name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hình ảnh đang sử dụng:</label>
                            <div class="controls">
                                <img style="width: 100px" id="gift_img" src="/assets/img/loading_large.gif" />
                                <input type="hidden" class="span12" id="gift_img_text" name="gift_img_text" />   
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Cập nhật hình ảnh:</label>
                            <div class="controls">
                                <input type="file" name="gift_img" /> (Ảnh không được lớn hơn 700KB)
                            </div>
                        </div> 

                        <div class="control-group">
                            <label class="control-label">Server:</label>
                            <div class="controls">
                                <textarea name="server_list" id="server_list" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;"></textarea> (ID Server cách nhau dấu ";")
                            </div>
                        </div>     


                        <div class="control-group">
                            <label class="control-label">Bắt đầu:</label>
                            <div class="controls">
                                <div id="startdate" name="startdate"></div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Kết thúc:</label>
                            <div class="controls">
                                <div id="enddate" name="enddate"></div>
                            </div>
                        </div>                               


                        <div class="control-group">                            
                            <label class="control-label">Điểm đổi:</label>
                            <div class="controls">
                                <input name="gift_price" id="gift_price" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group">                            
                            <label class="control-label">Yêu cầu VIP:</label> 
                            <div class="controls">
                                <select id="gift_vip_point" name="gift_vip_point" class="validate[required]">
                                    <option value="0">VIP 0</option>
                                    <option value="1">VIP 1</option>
                                    <option value="2">VIP 2</option>
                                    <option value="3">VIP 3</option>
                                    <option value="4">VIP 4</option>
                                    <option value="5">VIP 5</option>
                                    <option value="6">VIP 6</option>
                                    <option value="7">VIP 7</option>
                                    <option value="8">VIP 8</option>
                                    <option value="9">VIP 9</option>
                                    <option value="10">VIP 10</option>
                                    <option value="11">VIP 11</option> 
                                    <option value="12">VIP 12</option> 
                                </select>
                            </div>
                        </div>

                        <div class="control-group">                            
                            <label class="control-label">Yêu cầu mua gói:</label>
                            <div class="controls">
                                <input name="gift_number_request" id="gift_number_request" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group">                            
                            <label class="control-label">Số lượng mua tối đa trong ngày:</label>
                            <div class="controls">
                                <input name="gift_buy_max" id="gift_buy_max" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> (Nhập 0 nếu không hạng chế số lượng)
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="gift_status" id="gift_status_enable" value="1" checked="">
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="gift_status" id="gift_status_disable" value="0" >
                            </div>
                        </div> 

                        <div class="control-group frmedit">
                            <div class="form-group">
                                <label class="control-label">Item 1:</label>
                                <div class="controls">
                                    ID <input name="reward_item1_code" id="reward_item1_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Số lượng <input name="reward_item1_number" id="reward_item1_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Type <input name="reward_item1_type" id="reward_item1_type" type="text" class="span3 validate[required]" /> 
                                </div>
                            </div>                            
                        </div>

                        <div class="control-group frmedit">
                            <div class="form-group">
                                <label class="control-label">Item 2:</label>
                                <div class="controls">
                                    ID <input name="reward_item2_code" id="reward_item2_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Số lượng <input name="reward_item2_number" id="reward_item2_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Type <input name="reward_item2_type" id="reward_item2_type" type="text" class="span3 validate[required]" /> 
                                </div>
                            </div>                            
                        </div>

                       <div class="control-group frmedit">
                            <div class="form-group">
                                <label class="control-label">Item 3:</label>
                                <div class="controls">
                                    ID <input name="reward_item3_code" id="reward_item3_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Số lượng <input name="reward_item3_number" id="reward_item3_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Type <input name="reward_item3_type" id="reward_item3_type" type="text" class="span3 validate[required]" /> 
                                </div>
                            </div>                            
                        </div>

                        <div class="control-group frmedit">
                            <div class="form-group">
                                <label class="control-label">Item 4:</label>
                                <div class="controls">
                                    ID <input name="reward_item4_code" id="reward_item4_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Số lượng <input name="reward_item4_number" id="reward_item4_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Type <input name="reward_item4_type" id="reward_item4_type" type="text" class="span3 validate[required]" /> 
                                </div>
                            </div>                            
                        </div>

                        <div class="control-group frmedit">
                            <div class="form-group">
                                <label class="control-label">Item 5:</label>
                                <div class="controls">
                                    ID <input name="reward_item5_code" id="reward_item5_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Số lượng <input name="reward_item5_number" id="reward_item5_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Type <input name="reward_item5_type" id="reward_item5_type" type="text" class="span3 validate[required]" /> 
                                </div>
                            </div>                            
                        </div>                      

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align:left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                <input type="hidden" name='id' id="id">
                                <button id="onSubmit" class="base_button base_green base-small-border-radius"><span>Thực hiện</span></button>
                                <button type="button" id="comeback"><span>Quay lại</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
