<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        var table,url;
        $(document).ready(function () {
            url = '<?php echo $url; ?>';
            getData();

            $('#create_reward').on('click', function () {
                window.location.href = '/?control=bog_event_goi_qua_vip&func=themqua&module=all#quanlyqua';
            });
        });

        function getData() {
            $.ajax({
                url: url + "gift_list",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                     table = $('#data_table').DataTable({
                        "aaData": data
                        ,
                        aoColumns: [
                            {
                                sTitle: "Mã giao dịch",
                                mData: "id"
                            },
                            {
                                 sTitle: "Tên",
                                 mData: "name"
                            },
                            {
                                sTitle: "Vật phẩm",
                                mData: "items",
                                mRender: function(data){
                                    var json = $.parseJSON(data);
                                    var items = ''
                                    json.forEach(function(entry) {
                                        items = items + entry.item_id + ' - ' + entry.item_name + ' * ' + entry.count + '<br>';
                                    });
                                    return items;
                                }
                            },
                            {
                                sTitle: "Giá tiền",
                                mData: "money"
                            },
                            {
                                sTitle: "VIP",
                                mData: "vip"
                            },
                            {
                                sTitle: "",
                                mData: "id",
                                mRender: function (data, arg1, arg2) {
                                    return "<a class='btn btn-success btn-xs' href=' /?control=bog_event_goi_qua_vip&func=themqua&module=all&id=" + data + "&name="+arg2.name+"&items="+arg2.items + "&money="+arg2.money + "&vip="+arg2.vip + "#quanlyqua '>Chỉnh Sửa</a>";
                                }

                            },
                            {
                                sTitle: "",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a onclick='delete_gift(this,"+data+");' class='btn btn-success btn-xs' href='#quanlyqua'>Xóa</a>";
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

        //delete award
        function delete_gift(me,id){
            $.ajax({
                url: url + "delete_gift",
                dataType: 'jsonp',
                data: {id:id},
                success: function (response) {
                    table.row($(me).closest('tr')).remove().draw( false );
                }
            });

        }
    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_reward"  class="btn btn-primary"><span>THÊM MỚI</span></button>
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