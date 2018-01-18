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
        $(document).ready(function() { 
            var room_id = getParameterByName("room_id");
            
            $('#add_session').on('click', function () {
                window.location.href = '/?control=dophuong_gm&func=themphien&room_id=' + $("#room").val() + '#quanlyphien';
            });
            
             $("#room").change(function () {             
                window.location.href = '/?control=dophuong_gm&func=quanlyphien&room_id=' + $(this).val() + '#quanlyphien';
            });
            
            //Load Rom List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/giangma/cms/tooldophuong/room_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["id"] + '" >' + value["room_name"] + '</option>';
                    });

                    $("#room").html(tourlist);
                    
                    if (room_id != null && room_id != "") {
                        $("#room").val(room_id);
                    }

                    //Load Session List
                    getData($("#room").val());
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });
        
        function getData(room_id) {
            $.ajax({
                url: "http://game.mobo.vn/giangma/cms/tooldophuong/session_list?room_id=" + room_id,
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows
                        ,
                        aoColumns: [
                                 {
                                     sTitle: "Tên Phiên",
                                     mData: "session_name"
                                 },
                               {
                                   sTitle: "Bắt Đầu",
                                   mData: "session_time_start"
                               },
                                {
                                    sTitle: "Kết Thúc",
                                    mData: "session_time_end",

                                },
                                {
                                    sTitle: "Tối Đa",
                                    mData: "max_user",
                                     mRender: function (data) {
                                        return (data == 0) ? "<span style='color:green'>Không giới hạn</span>" : "<span style='color:red'>" + data + "</span>";
                                    }

                                },
                                {
                                    sTitle: "Trạng Thái",
                                    mData: "session_status",
                                    mRender: function (data) {
                                        return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                    }
                                },
                                {
                                    sTitle: "Tùy Chọn",
                                    mData: "id",
                                    mRender: function (data) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=dophuong_gm&func=chinhsuaphien&id=" + data + "&room_id=" + $("#room").val() + "'>Chỉnh Sửa</a>";
                                    }

                                }

                        ],
                        bProcessing: true,

                        bPaginate: true,

                        bJQueryUI: false,

                        bAutoWidth: false,

                        bSort: false,
                        bRetrieve: true,
                        bDestroy: true,

                        sPaginationType: "full_numbers"
                    });
                }
            });
        }
        
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
                    <div class="table-overflow">
                        <div style="border-top:1px solid #d5d5d5;padding: 4px 8px">
                            Phòng <select id="room" name="room" class="span4 validate[required]" />										
                            </select> <button id="add_session" class="btn btn-primary"><span>Thêm Phiên</span></button>
                        </div>                   
                        <table class="table table-striped table-bordered" id="data_table">      
                        </table>
                    </div>
                    <div class="table-overflow">
                        <table class="table table-striped table-bordered" id="data_table_send">      
                        </table>
                    </div>          
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
