<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100}
        label {width: auto !important;color: #f36926;}
		#data_table td{ word-break:break-all;}
    </style>
    <script type="text/javascript">
        var table,url;

        $(document).ready(function () {
            url = '<?php echo $url; ?>';
            getData();
        });

        function getData() {
            $.ajax({
                url: url + "gift_list",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                data: {game:<?php echo "'{$game}'";?>},
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    table = $('#data_table').DataTable({
                        "aaData": data,
                        aoColumns: [
                            {
                                sTitle: "Mã giao dịch",
                                mData: "id"
                            },
                            {
                                sTitle: "Điều kiện",
                                mData: "condition"
                            },
                            {
                                sTitle: "Vật phẩm",
                                mData: "items"
                                /*mRender: function(items){
                                    var itemsParse = $.parseJSON(items);
                                    var items = '';
                                    itemsParse.forEach(function(entry) {
                                        items +=  'item_id:' + entry.item_id + ' - item_name:' +  entry.item_name + ' * ' + entry.count + '<br>';
                                    });
                                    return items;
                                }*/
                            },
                            {
                                sTitle: "Thời gian",
                                mData: "key"
                            },
                            {
                                sTitle: "Server",
                                mData: "server_list"
                            },
                            {
                                sTitle: "",
                                mData: "id",
                                mRender: function (data, arg1, arg2) {
                                    return "<a class='btn btn-success btn-xs' href=' /?control=<?php  echo $control;?>&func=themqua&id=" + data + "&condition="+arg2.condition+"&items="+arg2.items + "&key="+arg2.key + "&config_id="+arg2.config_id + "&server_list="+arg2.server_list +"#quanlyqua '>Chỉnh Sửa</a>";
                                }

                            },
                            {
                                 sTitle: "",
                                 mData: "id",
                                 mRender: function (id) {
                                    return "<a onclick='delete_gift(this,"+id+");' class='btn btn-success btn-xs' href='#quanlyqua'>Xóa</a>";
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
            var $confirm = $("#modalConfirmYesNo");
            $confirm.modal('show');
            $("#lblTitleConfirmYesNo").html('Thông Báo');
            $("#lblMsgConfirmYesNo").html('Bạn có muốn xóa hay không?');
            $("#btnYesConfirmYesNo").off('click').click(function () {
                $.ajax({
                    url: url + "delete_gift",
                    dataType: 'jsonp',
                    data: {id:id, game:<?php echo "'{$game}'"?>},
                    success: function (response) {
                        table.row($(me).closest('tr')).remove().draw( false );
                    }
                });
                $confirm.modal("hide");
            });
            $("#btnNoConfirmYesNo").off('click').click(function () {
                $confirm.modal("hide");
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
                            <a href="/?control=<?php  echo $control;?>&func=themqua&game=<?php echo $game;?>#quanlyqua" class="btn btn-primary"><span>THÊM MỚI</span></a>
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