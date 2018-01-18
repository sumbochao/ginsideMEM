<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js'); ?>"></script>
<style>
    .scroolbar{
        width: 1800px;
    }
    .title_list{
        font-weight: bold;
    }
    .filter .title{
        position: relative;
        top:-4px;
        margin-left: 5px;
    }
    .filter .title:first-child{
        margin-left: 0px;
    }
    span #create{
        margin-bottom: 10px !important;
    }
    .scroolbar input,.scroolbar label{width: auto;}
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                var type = $("select[name=type]").val();
                window.location.href = '/?control=tienbao_gm&func=excel&module=<?php echo $_GET['module'];?>&type='+type+'&start='+start+'&end='+end;
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/tienbao/history",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows,
                        aoColumns: [
                            {
                                sTitle: "ID",
                                mData: "id"
                            },
                            {
                                sTitle: "Mobo ID",
                                mData: "moboid"
                            },
                            {
                                sTitle: "Character ID",
                                mData: "character_id"
                            },
                            {
                              sTitle: "Mobo Service ID",
                              mData: "mobo_service_id",
                            },
                            {
                               sTitle: "Character Name",
                               mData: "character_name",

                            },
                            {
                               sTitle: "Server ID",
                               mData: "server_id",
                            },
                            {
                               sTitle: "Type",
                               mData: "type",
                               mRender: function (data) {
                                    var type;
                                    switch(data){
                                        case "1":
                                            type = "Thẻ tướng";
                                            break;
                                        case "2":
                                            type = "Item khác";
                                            break;
                                        case "3":
                                            type = "Item vip";
                                            break;
                                        case "4":
                                            type = "Kì Ngộ";
                                            break;
                                    }
                                   return type;
                               }
                            },
                            {
                               sTitle: "Item ",
                               mData: "item_name",
                            },
                            {
                                sTitle: "Số lượng",
                                mData: "quantity",
                            },
                            {
                                sTitle: "Số tiền (VNĐ)",
                                mData: "money",
                                mRender: function (data) {
                                    var money = 0;
                                    if(data>0){
                                        money = FormatNumber(data);
                                    }
                                    return money;
                                }
                            },
                            {
                                sTitle: "Thành tiền (VNĐ)",
                                mData: "money",
                                sClass:"left", 
                                mRender: function (data,type,full) {
                                    var total = 0;
                                    if(full.quantity>0){
                                        total = full.money*full.quantity;
                                        total = FormatNumber(total.toString());
                                    }else{
                                        total = FormatNumber(full.money);
                                    }
                                    return '<b>'+total+'</b>';
                                }
                            },
                            {
                                sTitle: "Level vip",
                                mData: "vipLv",
                            },
                            {
                                sTitle: "Sắp xếp",
                                mData: "order",
                            },
                            {
                               sTitle: "Date",
                               mData: "create_date",
                            },
                            {
                               sTitle: "Result",
                               mData: "result",
                            },
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
    </script>
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">   
            <?php include APPPATH . 'views/game/gm/Events/tienbao/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                         <div style="margin-top: 10px; margin-bottom: 10px;">
                            <select name="type">
                                <option value="0">Chọn loại quà</option>
                                <option value="1">Thẻ tướng</option>
                                <option value="2">Item khác</option>
                                <option value="3">Gói Item VIP</option>
                                <option value="4">Gói Item Kì Ngộ</option>
                            </select>
                             <?php
                                $start = date('d-m-Y G:i:s',  strtotime('-15 day'));
                                $end = date('d-m-Y G:i:s');
                             ?>
                             <input type="text" id="start" name="start" value="<?php echo $start;?>"/>
                             <input type="text" id="end" name="end" value="<?php echo $end;?>"/>
                             <span><button id="create"  class="btn btn-primary"><span>Xuất Excel</span></button></span>
                        </div>
                        <div class="wrapper_scroolbar">
                            <div class="scroolbar">
                                <table class="table table-striped table-bordered" id="data_table"></table>
                           </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>