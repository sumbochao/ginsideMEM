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
        var campaign_id = <?php echo $campaign_id;?>;
        $(document).ready(function () {
            url = '<?php echo $url; ?>';
            getData();
        });

        function getData() {
            table = $('#data_table').DataTable({
                "aaData": <?php echo $listAds;?>,
                aoColumns: [
                    {
                        sTitle: "ID",
                        mData: "id"
                    },
                    {
                        sTitle: "Name",
                        mData: "name",
                        mRender: function(name, arg1, arg2){
                            return '<a href="/?control=facebook_ads&func=displayAds&module=all&id='+arg2.id+'">'+name+'</a>'
                        }
                    },
                    {
                        sTitle: "Optimization Goal",
                        mData: "optimization_goal"
                    },
                    {
                        sTitle: "Bid Amount",
                        mData: "bid_amount"
                    },
                    {
                        sTitle: "Billing Event",
                        mData: "billing_event"
                    },
                    {
                        sTitle: "Daily Budget",
                        mData: "daily_budget"
                    },
                    {
                        sTitle: "Start Time",
                        mData: "start_time"
                    },
                    {
                        sTitle: "End Time",
                        mData: "end_time"
                    },

                    {
                        sTitle: "",
                        mData: "id",
                        mRender: function (data) {
                            return "<a class='btn btn-success btn-xs' href=' /?control=facebook_ads&func=displayEditAdsetForm&module=all&id=" + data +"#campaign '>Edit</a>";
                        }

                    },
                    {
                        sTitle: "",
                        mData: "id",
                        mRender: function (data) {
                            return "<a onclick='deleteAdset(this,"+data+");' class='btn btn-success btn-xs' href='#campaign'>Delete</a>";
                        }

                    },
                    {
                        sTitle: "",
                        mData: "id",
                        mRender: function (data) {

                            return "<a class='btn btn-success btn-xs' href=' /?control=facebook_ads&func=displayEditTargetingForm&module=all&id=" + data +"&campaign_id=" + campaign_id +"#campaign '>Edit Targeting</a>";
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
                scrollX: true,
                sPaginationType: "full_numbers"
            });
        }


        function deleteAdset(me,id){
            $('.loading').show();
            $.ajax({
                url: "?control=facebook_ads&func=deleteAdset&module=all#campaign",
                data: {id:id},
                success: function (response) {
                    table.row($(me).closest('tr')).remove().draw( false );
                    $('.loading').hide();
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