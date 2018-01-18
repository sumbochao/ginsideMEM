<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js'); ?>"></script>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .pages{
            width:50px;
        }
    </style>
    <?php
        $pagenum = 0;$pagesize=1000;
        if(isset($_POST['ok'])){
            $pagenum = $_POST['pagenum'];$pagesize = $_POST['pagesize'];
        }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/dautruong/index_<?php echo $_GET['view'].'?pagenum='.$pagenum.'&pagesize='.$pagesize;?>",
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
                                mData: "mobo_id"
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
                               sTitle: "Date",
                               mData: "create_date",
                            },
                            {
                               sTitle: "Event",
                               mData: "event_name",
                            },
                            {
                                sTitle: "Money",
                                mData: "money",
                                mRender: function (data) {
                                    var money=0;
                                    if(data>0){
                                        money = FormatNumber(data);
                                    }
                                    return money;
                                }
                            },
                            {
                               sTitle: "Tùy Chọn",
                               mData: "id",
                               mRender: function (data) {
                                   return "<a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=dautruong_lol&func=delete&view=<?php echo $_GET['view'];?>&module=<?php echo $_GET['module'];?>&id=" + data + "'>Xóa</a>";
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
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/lol/Events/dautruong/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">
                        <form action="" method="post">
                        <div style="margin-top: 10px; margin-bottom: 10px;">
                            <span style="position:relative;top:-5px;font-weight: bold;color: #268ab9">Trang</span>
                            <input type="text" class="pages" name="pagenum" value="<?php echo $_POST['pagenum']>0?$_POST['pagenum']:0;?>"/>
                            <input type="text" class="pages" name="pagesize" value="<?php echo $_POST['pagesize']>0?$_POST['pagesize']:1000;?>"/>
                            <span><input type="submit" name="ok" value="Xem" class="btn btn-primary" style="position:relative;top:-5px;padding:3px 10px"/></span>
                        </div>
                        </form>
                        <div class="wrapper_scroolbar">
                            <div class="scroolbar">
                                <table class="table table-striped table-bordered" id="data_table"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>