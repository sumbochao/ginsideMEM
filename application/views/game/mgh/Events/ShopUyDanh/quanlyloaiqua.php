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
        });

        function getData() {
            $('#data_table').DataTable({
                "aaData": <?php echo $package;?>,
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
                        sTitle: "",
                        mData: "id",
                        mRender: function (data) {
                            return "<a class='btn btn-success btn-xs' href=' /?control=taixiu&func=themloaiqua&module=all&id=" + data +"#quanlyqua '>Chỉnh Sửa</a>";
                        }

                    }/*,
                    {
                        sTitle: "",
                        mData: "id",
                        mRender: function (id) {
                            return "<a onclick='delete_gift(this,"+id+");' class='btn btn-success btn-xs' href='#quanlyqua'>Xóa</a>";
                        }
                    }*/

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

        //delete award
        /*function delete_gift(me,id){
            var $confirm = $("#modalConfirmYesNo");
            $confirm.modal('show');
            $("#lblTitleConfirmYesNo").html('Thông Báo');
            $("#lblMsgConfirmYesNo").html('Bạn có muốn xóa hay không?');
            $("#btnYesConfirmYesNo").off('click').click(function () {
                $.ajax({
                    url: url + "delete_gift",
                    dataType: 'jsonp',
                    data: {id:id, game:<?php //echo "'{$game}'"?>},
                    success: function (response) {
                        table.row($(me).closest('tr')).remove().draw( false );
                    }
                });
                $confirm.modal("hide");
            });
            $("#btnNoConfirmYesNo").off('click').click(function () {
                $confirm.modal("hide");
            });



        }*/
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
                            <a href="/?control=shopuydanh&func=themloaiqua&module=all#quanlyloaiqua" class="btn btn-primary"><span>THÊM MỚI</span></a>
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