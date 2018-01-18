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
            $('#comeback').on('click', function () {
                if (type != null && type != "") {
                    window.location.href = '/?control=dophuong_gm&func=quanlyqua&type=' + type + '#quanlyqua';
                }
                else {
                    window.location.href = '/?control=dophuong_gm&func=quanlyqua#quanlyqua';
                }
            });

            //Load Gift Type
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/giangma/cms/tooldophuong/gift_type_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["type_name"] + '</option>';
                    });

                    $("#gifttype").html(tourlist);

                    if (type != null && type != "") {
                        $("#gifttype").val(type);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });

        $(function () {
            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/giangma/cms/tooldophuong/add_gift",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        // load your loading fiel here
                        $('#message').attr("style", "color:green");
                        $('#message').html('Đang xử lý ...');
                    }
                }).done(function (result) {
                    console.log(result);
                    //hide your loading file here
                    if (result.status == false)
                        $('#message').attr("style", "color:red");

                    $('#message').html(result.message);
                });
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
            <?php include APPPATH . 'views/game/gm/Events/DoPhuong/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="widget row-fluid">
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
                                <label class="control-label">Hình ảnh:</label>
                                <div class="controls">
                                    <input type="text" class="span12" id="gift_img" name="gift_img" value="<?php echo quotes_to_entities($item->Thumb) ?>" />                        

                                    <i class="icon-picture field-icon" onclick="openKCFinderByPath('type=dophuong', '#gift_img')" title="<?php echo $langs['choosefromserver'] ?>"></i>
                                </div>
                            </div>
                            <div class="control-group frmedit">
                                <div class="form-group">
                                    <label class="control-label">Item ID:</label>
                                    <div class="controls">
                                        <input name="item_id" id="item_id" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Số lượng:</label>
                                    <div class="controls">
                                        <input name="gift_quantity" id="gift_quantity" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                    </div>
                                </div>
                            </div>    

                            <div class="control-group">
                                <label class="control-label">Server:</label>
                                <div class="controls">
                                    <textarea name="server_list" id="server_list" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;"></textarea> (ID Server cách nhau dấu ";")
                                </div>
                            </div>         

                            <div class="control-group">                            
                                <label class="control-label">Điểm đổi:</label>
                                <input name="gift_price" id="gift_price" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>

                            <div class="control-group">                            
                                <label class="control-label">Số lượng mua tối đa:</label>
                                <input name="gift_buy_max" id="gift_buy_max" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> (Nhập 0 nếu không hạng chế số lượng)
                            </div>

                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="gift_status" id="gift_status_enable" value="1" checked="">
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="gift_status" id="gift_status_disable" value="0" >
                                </div>
                            </div> 

                            <div class="control-group">
                                <span class="error"></span>
                            </div>

                            <div class="control-group">
                                <div style="padding-left: 20%; text-align:left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                    <button id="onSubmit" class="base_button base_green base-small-border-radius"><span>Thực hiện</span></button>
                                    <button id="comeback" class="base_button base_green base-small-border-radius"><span>Quay lại</span></button>
                                    <div style="display: inline-block">
                                        <span id="message" style="color: green"></span>
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
