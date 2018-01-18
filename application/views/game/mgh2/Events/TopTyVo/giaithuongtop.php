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
        $(function () {
            $("#tournament").change(function () {
                //Load Reward List
                load_reward($("#tournament").val());
            });

            $("#reward").change(function () {
                //Load Reward Details
                load_reward_details($("#reward").val());
            });

            $('#add_reward').on('click', function () {
                $('#reward').hide();
                $('#add_reward').hide();
                $('#edit_reward').hide();

                $('#reward_name').show();
                $('#reward_name').val('Reward Name...');

                $('#reward_rank_min').show();
                $('#reward_rank_min').val('Rank min...');

                $('#reward_rank_max').show();
                $('#reward_rank_max').val('Rank max...');

                $('#add_new_reward').show();
                $('#cancel_new_reward').show();
            });

            $('#cancel_new_reward').on('click', function () {
                $('#reward').show();
                $('#add_reward').show();
                $('#reward_name').hide();
                $('#add_new_reward').hide();
                $('#cancel_new_reward').hide();
                $('#edit_reward').show();
                $('#reward_rank_min').hide();
                $('#reward_rank_max').hide();
            });

            $('#edit_reward').on('click', function () {
                $('#reward_edit').show();
                $('#reward_ok').hide();
                $('#reward_name_edit').val($("#reward option:selected").text());
                $('#reward_rank_min_edit').show();
                $('#reward_rank_max_edit').show();
            });

            $('#cancel_reward_edit').on('click', function () {
                $('#reward_edit').hide();
                $('#reward_ok').show();
            });

            $('#update_reward').on('click', function () {
                $.ajax({
                    method: "GET",
                    url: "http://game.mobo.vn/mgh2/cms/tooltoptyvo/edit_reward_name_top/?id=" + $('#reward').val() + "&reward_name=" + $('#reward_name_edit').val() + "&reward_rank_min=" + $('#reward_rank_min_edit').val() + "&reward_rank_max=" + $('#reward_rank_max_edit').val(),
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        console.log(data.message);
                        alert(data.message);
                        $('#reward_edit').hide();
                        $('#reward_ok').show();
                    },
                    error: function (data) {
                        var obj = $.parseJSON(data);
                    }
                });

            });

            $('#add_new_reward').on('click', function () {
                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/mgh2/cms/tooltoptyvo/add_reward_top",
                    data: { tournament_id: $("#tournament").val(), reward_name: $('#reward_name').val(), reward_rank_min: $('#reward_rank_min').val(), reward_rank_max: $('#reward_rank_max').val() },
                    beforeSend: function () {
                        // load your loading fiel here                      
                    }
                }).done(function (result) {
                    load_reward($("#tournament").val());
                    load_reward_details(result.data);
                    $('#reward').show();
                    $('#add_reward').show();
                    $('#reward_name').hide();
                    $('#reward_rank_min').hide();
                    $('#reward_rank_max').hide();
                    $('#add_new_reward').hide();
                    alert(result.message);
                });
            });

            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");

                    //Load Reward Details   
                    load_reward_details($("#reward").val());
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });

        $(document).ready(function () {
            //Load Tournament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/mgh2/cms/tooltoptyvo/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);
                    //Load Reward List
                    load_reward($("#tournament").val());
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });

        function load_reward(tournament_id) {
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/mgh2/cms/tooltoptyvo/load_reward_top?tournament_id=" + tournament_id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data;
                    var rewardlist = "";
                    $.each(obj, function (key, value) {
                        rewardlist += '<option value="' + value["id"] + '" >' + value["reward_name"] + '</option>';
                    });

                    $("#reward").html(rewardlist);
                    //Load Reward Details   
                    load_reward_details($("#reward").val());
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        }

        function load_reward_details(id) {
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/mgh2/cms/tooltoptyvo/load_reward_details_top?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    if (data.length > 0) {
                        $("#id").val(data[0]["id"]);
                        $("#reward_point").val(data[0]["reward_point"]);
                        $("#reward_percent").val(data[0]["reward_percent"]);                        
                        $("#reward_img").attr('src', data[0]["reward_img"]);
                        $("#reward_img_text").val(data[0]["reward_img"]);

                        $("#reward_rank_min_edit").val(data[0]["reward_rank_min"]);
                        $("#reward_rank_max_edit").val(data[0]["reward_rank_max"]);

                        $("#reward_item1_code").val(data[0]["reward_item1_code"]);
                        $("#reward_item1_number").val(data[0]["reward_item1_number"]);

                        $("#reward_item2_code").val(data[0]["reward_item2_code"]);
                        $("#reward_item2_number").val(data[0]["reward_item2_number"]);

                        $("#reward_item3_code").val(data[0]["reward_item3_code"]);
                        $("#reward_item3_number").val(data[0]["reward_item3_number"]);

                        $("#reward_item4_code").val(data[0]["reward_item4_code"]);
                        $("#reward_item4_number").val(data[0]["reward_item4_number"]);

                        $("#reward_item5_code").val(data[0]["reward_item5_code"]);
                        $("#reward_item5_number").val(data[0]["reward_item5_number"]);

                        if (data[0]["reward_status"] == 1) {
                            $('#reward_status_enable').prop('checked', true);
                        }
                        else {
                            $('#reward_status_disable').prop('checked', true);
                        }
                    }
                    else {
                        $("#reward_point").val('');
                        $("#Thumb").val('');
                        $("#reward_item1_code").val('');
                        $("#reward_item1_number").val('');

                        $("#reward_item2_code").val('');
                        $("#reward_item2_number").val('');

                        $("#reward_item3_code").val('');
                        $("#reward_item3_number").val('');

                        $("#reward_item4_code").val('');
                        $("#reward_item4_number").val('');

                        $("#reward_item5_code").val('');
                        $("#reward_item5_number").val('');
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/mgh2/Events/TopTyVo/tab.php'; ?>
            <div class="widget-name">

                <!-- <div class="tabs">
                   <a href="/cms/ep/promotion_lato/thongke"><i class=" ico-th-large"></i>THỐNG KÊ</a> 
                   <a href="/cms/ep/promotion_lato/tralogdoiqua"><i class=" ico-th-large"></i>TRA LOG ĐỔI QUÀ</a>
                                   <a href="javascript:void(0);" class="clearcached"><i class=" ico-th-large"></i>CLEAR MENCACHED</a>
                </div>-->
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=toptyvo_mgh2&module=all&func=edit_reward_details_top" method="POST" enctype="multipart/form-data">
                        <div class="widget row-fluid">
                            <div class="well form-horizontal">
                                <div class="control-group">
                                    <label class="control-label">Tên giải đấu:</label>
                                    <div class="controls">
                                        <select id="tournament" name="tournament" class="span4 validate[required]" />										
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Mốc thưởng:</label>
                                    <div class="controls">
                                        <div id="reward_ok"><select id="reward" name="reward" class="span4 validate[required]" />										
								</select><input value="Reward Name..." onblur="if (this.value == '') {this.value = 'Reward Name...';}" onfocus="if (this.value == 'Reward Name...') {this.value = '';}" name="reward_name" id="reward_name" type="text" style="display: none;" />
                                    <input value="Rank min..." onblur="if (this.value == '') {this.value = 'Rank min...';}" onfocus="if (this.value == 'Rank min...') {this.value = '';}" name="reward_rank_min" id="reward_rank_min" type="text" style="display: none;" />
                                    <input value="Rank max..." onblur="if (this.value == '') {this.value = 'Rank max...';}" onfocus="if (this.value == 'Rank max...') {this.value = '';}" name="reward_rank_max" id="reward_rank_max" type="text" style="display: none;" /> 
                                    <button type="button" id="add_reward" class="base_button base_green base-small-border-radius"><span>Thêm Mốc Thưởng</span></button> 
                                <button type="button" id="edit_reward" class="base_button base_green base-small-border-radius"><span>Chỉnh Sửa</span></button>
                                <button type="button" id="add_new_reward" class="base_button base_green base-small-border-radius" style="display: none;"><span>Thêm Mới</span></button>
                                 <button type="button" id="cancel_new_reward" class="base_button base_green base-small-border-radius" style="display: none;"><span>Hủy Bỏ</span></button>
                                    </div>
                                <div id="reward_edit" style="display: none;"><input value="Reward Name..." onblur="if (this.value == '') {this.value = 'Reward Name...';}" onfocus="if (this.value == 'Reward Name...') {this.value = '';}" name="reward_name_edit" id="reward_name_edit" type="text" /> 
                                    <input name="reward_rank_min_edit" id="reward_rank_min_edit" type="text" style="display: none;" />
                                    <input name="reward_rank_max_edit" id="reward_rank_max_edit" type="text" style="display: none;" /> 
                                    <button type="button" id="update_reward" class="base_button base_green base-small-border-radius"><span>Cập nhật</span></button> 
                                    <button type="button" id="cancel_reward_edit" class="base_button base_green base-small-border-radius"><span>Hủy Bỏ</span></button>
                                </div>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                <label class="control-label">Giải thưởng NL:</label>
                                <div class="controls">
                                    <input name="reward_percent" id="reward_percent" type="text" class="span3 validate[required,custom[number]]" /> (%)
                                </div>
                                </div>
                                
                                <div class="control-group" style="display: none;">
                                <label class="control-label">Điểm:</label>
                                <div class="controls">
                                    <input name="reward_point" id="reward_point" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Trạng thái giải thưởng:</label>
                                    <div class="controls">
                                        Enable:<input type="radio" name="reward_status" id="reward_status_enable" value="1">
                                        &nbsp;&nbsp;
                                        Disable:<input type="radio" name="reward_status" id="reward_status_disable" value="0">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hình ảnh đang sử dụng:</label>
                                    <div class="controls">
                                        <img id="reward_img" src="/assets/img/loading_large.gif" />
                                        <input type="hidden" class="span12" id="reward_img_text" name="reward_img_text" />   
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Cập nhật hình ảnh:</label>
                                    <div class="controls">
                                        <input type="file" name="reward_img" /> (Ảnh không được lớn hơn 700KB)
                                    </div>
                                </div> 

                                <div class="control-group frmedit">
                                    <div class="form-group">
                                        <label class="control-label">Item 1:</label>
                                        <div class="controls">
                                            Item ID: <input name="reward_item1_code" id="reward_item1_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                            Số Lượng: <input name="reward_item1_number" id="reward_item1_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />                                            
                                        </div>
                                    </div>                            
                                </div>

                                <div class="control-group frmedit">
                                    <div class="form-group">
                                        <label class="control-label">Item 2:</label>
                                        <div class="controls">
                                            Item ID: <input name="reward_item2_code" id="reward_item2_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                            Số Lượng: <input name="reward_item2_number" id="reward_item2_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />                                           
                                        </div>
                                    </div>                            
                                </div>

                                <div class="control-group frmedit">
                                    <div class="form-group">
                                        <label class="control-label">Item 3:</label>
                                        <div class="controls">
                                            Item ID: <input name="reward_item3_code" id="reward_item3_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                            Số Lượng: <input name="reward_item3_number" id="reward_item3_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />                                            
                                        </div>
                                    </div>                            
                                </div>

                                <div class="control-group frmedit">
                                    <div class="form-group">
                                        <label class="control-label">Item 4:</label>
                                        <div class="controls">
                                            Item ID: <input name="reward_item4_code" id="reward_item4_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                            Số Lượng: <input name="reward_item4_number" id="reward_item4_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />                                            
                                        </div>
                                    </div>                            
                                </div>

                                <div class="control-group frmedit">
                                    <div class="form-group">
                                        <label class="control-label">Item 5:</label>
                                        <div class="controls">
                                            Item ID: <input name="reward_item5_code" id="reward_item5_code" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                            Số Lượng: <input name="reward_item5_number" id="reward_item5_number" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />                                           
                                        </div>
                                    </div>                            
                                </div> 
                                
                                <div class="control-group">
                                    <div style="padding-left: 20%; text-align: left;">
                                        <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                        <input type="hidden" name='id' id="id">
                                        <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                        <div style="display: inline-block">
                                            <span id="message" style="color: green"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
