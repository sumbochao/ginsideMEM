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
            $('#comeback').on('click', function () {               
                window.history.go(-1); return false;
            });
            
            $("#tournament").change(function () {
                
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
                url: "http://game.mobo.vn/mathan/cms/tooltuhaihuynhde/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    var tournament_id = getParameterByName("tournament_id");
                    if (tournament_id !== null && tournament_id !== "") {                     
                        $("#tournament").val(tournament_id);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });
        
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
        
        $(document).on('click', '#btn_add_more_item', function(){
            k = $('input:file').length;
            $( ".add_more_item" ).after('<div class="control-group"><label class="control-label"> Item tiếp theo :</label></div><div class="control-group"><label class="control-label">Tên Quà:</label><div class="controls"><input name="item_name['+k+']" id="item_name" type="text" class="span4 validate[required]" /></div></div><div class="control-group"><label class="control-label">Hình ảnh:</label><div class="controls"><input type="file" name="gift_img['+k+']" /> (Ảnh không được lớn hơn 700KB)</div></div> <div class="control-group"><label class="control-label">Item ID:</label><div class="controls"><input name="item_id['+k+']" id="item_id" type="text" class="span3 validate[required]" /></div></div><div class="control-group"><label class="control-label">Số lượng:</label><div class="controls"><input name="item_quantity['+k+']" id="item_quantity" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /></div></div>');
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/mt/Events/TuHaiHuynhDe/tab.php'; ?>
            <div class="widget-name">              
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=tuhaihuynhde_mt&module=all&func=add_tuhaihuynhde_gift" method="POST" enctype="multipart/form-data">
                        <div class="widget row-fluid">
                            <div class="well form-horizontal">
                                <h5 class="widget-name">
                                <i class=" ico-th-large"></i>THÊM QUÀ MỚI</h5>
                                <div class="control-group">
                                    <label class="control-label">Sự kiện:</label>
                                    <div class="controls">
                                        <select id="tournament" name="tournament" class="span4 validate[required]" />										
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                        <label class="control-label">Tên Quà:</label>
                                        <div class="controls">
                                            <input name="item_name[0]" id="item_name" type="text" class="span4 validate[required]" />
                                        </div>
                                    </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Hình ảnh:</label>
                                    <div class="controls">
                                        <input type="file" name="gift_img[0]" /> (Ảnh không được lớn hơn 700KB)
                                    </div>
                                </div> 
                               
                                <div class="control-group">
                                    <label class="control-label">Item ID:</label>
                                    <div class="controls">
                                        <input name="item_id[0]" id="item_id" type="text" class="span3 validate[required]" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Số lượng:</label>
                                    <div class="controls">
                                        <input name="item_quantity[0]" id="item_quantity" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                    </div>
                                </div>
                                
                                <div class="add_more_item"></div>
                                
                                <div class="control-group">
                                    <div style="padding-left: 20%; text-align: left;">
                                        <button id="btn_add_more_item"><span>Thêm Item</span></button>
                                        <div style="display: inline-block">
                                            <span id="message" style="color: green"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Số Hảo Hữu (điều kiện nhận quà):</label>
                                    <div class="controls">
                                        <input name="conditions_receiving_gifts" id="conditions_receiving_gifts" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <div style="padding-left: 20%; text-align: left;">
                                        <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                        <input type="hidden" name='id' id="id">
                                        <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                         <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>                                        
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
