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
            table = $('#data_table').DataTable({
                "aaData": <?php echo $campaigns;?>,
                aoColumns: [
                    {
                        sTitle: "ID",
                        mData: "id"
                    },
                    {
                        sTitle: "Name",
                        mData: "name",
                        mRender: function(name, arg1, arg2){
                            return '<a href="/?control=facebook_ads&func=displayAdsetByCampaign&module=all&id='+arg2.id+'#campaign">'+name+'</a>'
                        }
                    },
                    {
                        sTitle: "Objective",
                        mData: "objective"
                    },

                    {
                        sTitle: "",
                        mData: "id",
                        mRender: function (data, arg1, arg2) {
                            return "<a class='btn btn-success btn-xs' href=' /?control=facebook_ads&func=displayEditCampaignForm&module=all&id=" + data +"#campaign '>Chỉnh Sửa</a>";
                        }

                    },

                    {
                        sTitle: "",
                        mData: "id",
                        mRender: function (data) {
                            return "<a onclick='deleteCampaign(this,"+data+");' class='btn btn-success btn-xs' href='#campaign'>Xóa</a>";
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


        function deleteCampaign(me,id){
            $('.loading').show();
            $.ajax({
                url: "?control=facebook_ads&func=deleteCampaign&module=all#campaign",
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