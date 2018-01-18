<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#create_reward').on('click', function () {
                window.location.href = '/?control=support_old_user_mu&&module=all&func=themqua&tournament_id=' + $("#tournament").val() + '&pakage_id=' + $("#vip_gift_pakage").val() + '#quanlyqua';
            });
            
            $("#tournament").change(function () {             
                window.location.href = "/?control=support_old_user_mu&module=all&func=quanlyqua&tournament_id=" + $("#tournament").val() + "#quanlyqua";                
            });
            
            $.ajax({
                url: "http://game.mobo.vn/mu/cms/toolsupport_old_user/get_all_support_old_user_gift",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    var obj = data["rows"];
                    console.log(obj);
                    $('#data_table').dataTable({
                        "aaData": data.rows
                        ,
                        aoColumns: [
                            {
                                sTitle: "ID",
                                mData: "id"
                            },
                            {
                                sTitle: "Name",
                                mData: "name"
                            },
                            {
                                sTitle: "Items",
                                mData: "json_item",
                                mRender: function (data) {
                                            obj2 = jQuery.parseJSON(data);
                                            var html = "";
                                            $.each(obj2, function (key2, value2) { 
                                                html = html + "Item Id : " + value2["item_id"] + " - Item Name : " + value2["item_name"] + " - Số lượng : " + value2["count"] + "</br>";
                                            });
                                        return html;
                                    }
                            },                           
                            {
                                sTitle: "Điều Kiện Nhận Quà",
                                mData: "conditions_receiving_gifts"
                            },
                            {
                                sTitle: "Tùy Chọn",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a class='btn btn-success btn-xs' href='/?control=support_old_user_mu&module=all&func=chinhsuaqua&tournament_id=" + $("#tournament").val() + "&id=" + data + "#quanlyqua'>Chỉnh Sửa</a>";
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
            
        });
        
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
<?php include APPPATH . 'views/game/mu/Events/Support_Old_User/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">                           
                         <button id="create_reward"  class="btn btn-primary"><span>THÊM QUÀ MỚI</span></button>
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
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>