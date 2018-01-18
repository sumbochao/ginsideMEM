<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js'); ?>"></script>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .dataTables_wrapper.no-footer .dataTables_scrollBody{
            border-bottom: 0px;
            padding-top: 5px;
        }
        .scroolbar{
            width: 1400px;
        }
        #create{
            position: relative;
            top:-5px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/purchase/sold?game=<?php echo $_GET['game'];?>",
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
                               sTitle: "Tên",
                               mData: "name",
                            },
                            {
                                sTitle: "Giá bán",
                                mData: "price",
                                mRender: function (data) {
                                    var price;
                                    if(data>0){
                                        price = FormatNumber(data);
                                    }else{
                                        price = 0;
                                    }
                                   return price;
                                }
                            },
                            {
                                sTitle: "Phần trăm KM",
                                mData: "percent"
                            },
                            {
                               sTitle: "Số người mua",
                               mData: "buymin",
                               mRender: function (data,avg1,avg) {
                                   return avg.buy_join+'/'+avg.buymin;
                                }
                            },
                            {
                               sTitle: "Trạng thái",
                               mData: "issell",
                               mRender: function (data,avg1,avg) {
                                    var issell;
                                    if(avg.issell==-1){
                                        issell = '<div class="btn btn-success btn-xs buy" onclick="buyItem('+avg.id+',1)">Được bán</div> <div class="btn btn-success btn-xs buy" onclick="buyItem('+avg.id+',0)">Không bán</div>';
                                    }else{
                                        if(avg.issell==1){
                                            issell = 'Được bán';
                                        }else{
                                            if(avg.issell==0){
                                                issell = 'Không bán';
                                            }
                                        }
                                    }
                                   return issell;
                                }
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
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/Events/purchase/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow"> 
                        <table class="table table-striped table-bordered" id="data_table"></table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    function buyItem(id,issell){
        $.ajax({
            type: "POST",
            dataType: 'jsonp',
            url: "<?php echo $url_service;?>/cms/purchase/updateItem?id="+id+'&issell='+issell,
            data:{id:id,issell:issell}
        }).done(function (result) {
            window.location.href="<?php echo $_SERVER['REQUEST_URI'];?>";
        });
    }
</script>