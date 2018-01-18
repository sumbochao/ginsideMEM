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

        .minus-element {
            background: #268AB9;
            padding: 0px 8px;
            color: white;
            display: inline-block;
            font-size: 20px;
            height: 30px;
            line-height: 30px;
            border-radius: 8px;
        }
        .minus-element:hover{
            text-decoration: none;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#comeback').on('click', function () {
                //window.location.href = '/?control=event_covu_pt&func=giaidau#giaidau';
                window.history.go(-1);
                return false;
            });

            //Load Game List
            $.ajax({
                method: "GET",
                url: "/?control=managercontributor&func=loadgamelist",
//                url: "http://mem.net.vn/cms/toolsalarycollaborator/games_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = $.parseJSON(data);
                    var gamelist = "<option value='0' >Chọn Game</option>";
                    $.each(obj, function (key, value) {
                        gamelist += '<option value="' + value["id"] + '" >' + value["name"] + '</option>';
                    });

                    $("#game_id").html(gamelist);

                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });


            $('#frmSendChest').ajaxForm({
                beforeSubmit: function () {
                    if ($("#game_id").val() == '0') {
                        $(".modal-body #messgage").html('Vui lòng chọn game');
                        $('.bs-example-modal-sm').modal('show');
                        $(".loading").fadeOut("fast");
                        return false;
                    }

                    k = $('.frmeditted').length;
                    var check = false;
                    for (i = 0; i <= k; i++) {
                        for (j = 0; j <= k; j++) {
                            if (j == i) {
                                continue;
                            }
                            if ($("#type1_" + i).val() == $("#type1_" + j).val()) {
                                check = true;
                            }
                        }
                    }
                    if (check) {
                        $(".modal-body #messgage").html("Định Dạng Item đang bị trùng");
                        $('.bs-example-modal-sm').modal('show');
                        return false;
                    }
                    if ($('#frmSendChest').validationEngine('validate') === false)
                        return false;

                },
                success: function (data) {
                    $(".loading").fadeIn("fast");
                    json_data = $.parseJSON($.parseJSON(data));
                    if (data.result != "-1") {
                        $(".modal-body #messgage").html(json_data.message);
                        $('.bs-example-modal-sm').modal('show');
                        $(".loading").fadeOut("fast");
                    } else {
                        $(".modal-body #messgage").html(json_data.message);
                        $('.bs-example-modal-sm').modal('show');
                        $(".loading").fadeOut("fast");
                    }
                }
            });
        });

        $(document).ready(function () {
            var options = {
                data: ["item_id", "item_name", "item_type", "position", "activity", "type"],
            };
            $("#type1_0").easyAutocomplete(options);
        });
        $(document).on('click', '#btn_add_more_item', function () {
//            k = $('.frmeditted').length;
            k = 1 + (+$('.frmeditted').last().find('input[id^="type1"]').attr('id').split("_")[1]);
            $(".add_more_item").before(
                    '<div class="controls frmeditted" style="display: flex!important;">'
                    + '<div class="rows elements">'
                    + '<div class="col-md-6">'
                    + '<input name="type1[' + k + ']" id="type1_' + k + '" type="text" class="span3 validate[required] form-control" />'
                    + '</div>'
                    + '<div class="col-md-6" >'
                    + '<input name="type2[' + k + ']" id="type2" type="text" class="span3 validate[required] form-control" />'
                    + '</div>'
                    + '</div>'
                    + '<a class="minus-element">-</a>'
                    + '</div>');
            var options = {
                data: ["item_id", "id", "item_name", "item_type", "type", "position", "activity", "type"],
            };
            $("#type1_" + k).easyAutocomplete(options);
        });

        $(document).on('click', '.minus-element', function () {
            $(this).parent().remove();
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/salarycontributor/managercontributor/item/tab_manageitem.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="/?control=managercontributor&func=additem" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <i class=" ico-th-large"></i><?php echo $title ?>
                        </h5>
                        <div class="control-group">
                            <div class="table-overflow">     
                                <div style="margin-top: 10px; margin-bottom: 10px;">                           
                                    Chọn Game: <select id="game_id" name="game_id" class="span4" /></select>
                                </div>                               
                                <table class="table table-striped table-bordered" id="data_table">      
                                </table>
                            </div>                        
                        </div>


                        <div class="control-group">
                            <label class="control-label">Icon:</label>
                            <div class="controls">
                                <input type="file" name="gift_img" /> (Ảnh không được lớn hơn 700KB)
                            </div>
                        </div> 

                        <div class="control-group">
                            <label class="control-label">Tên Item:</label>
                            <div class="controls">
                                <input name="item_name" id="item_name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kiểu:</label>
                            <div class="controls">
                                GIFTCODE: <input type="radio" name="type" id="giftcode_type" value="1" >
                                &nbsp;&nbsp;
                                ITEM: <input type="radio" name="type" id="item_type" value="0" checked="">
                                &nbsp;&nbsp;
                            </div>
                        </div>

                        <h5 class="widget-name">
                            Item Elements (Định dạng quà theo từng game): </br>
                        </h5>

                        <style>
                            .easy-autocomplete{
                                width: inherit !important;

                            }
                            .elements span{
                                display: block;
                            }
                        </style>

                        <div class="control-group ">
                            <div class="form-group">
                                <div class="controls frmeditted" style="display: flex !important;">
                                    <div class="rows elements">
                                        <div class="col-md-6">
                                            <span>Name</span>
                                            <input name="type1[0]" id="type1_0" type="text" class="span3 validate[required] form-control" /> 
                                        </div>
                                        <div class="col-md-6">
                                            <span>Value</span>
                                            <input name="type2[0]" id="type2_0" type="text" class="span3 validate[required] form-control" /> 
                                        </div>
                                    </div>
                                </div>
                                <div class="add_more_item"></div>
                            </div>   
                            <div style="padding-left: 20%; text-align: left;">
                                <button type="button" id="btn_add_more_item"><span>Thêm Elements</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Số lượng : </label>
                            <div class="controls">
                                <input name="item_count" id="item_count" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Tỷ lệ hiển thị : </label>
                            <div class="controls">
                                <input name="item_rate" id="item_rate" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Số lượng CTV có quyền mua : </label>
                            <div class="controls">
                                <input name="limit_buy_user" id="limit_buy_user" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Giá (Điểm để đổi) : </label>
                            <div class="controls">
                                <input name="price" id="price" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

<!--                        <div class="control-group">
                            <label class="control-label">Active:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="item_active" id="item_enable" value="0" checked="">
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="item_active" id="item_disable" value="1">
                            </div>
                        </div>-->

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                <input type="hidden" name='creator' value="<?php echo $_SESSION['account']['username']; ?>">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
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
