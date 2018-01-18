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
            getData();
        });

        function getData() {
            $.ajax({
                url: "<?php echo $url;?>/history",
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
                                sTitle: "Id",
                                mData: "idx"
                            },
                            {
                                sTitle: "Email",
                                mData: "email",
                            },
                            {
                                sTitle: "MoboID",
                                mData: "mobo_id",
                            },
                            {
                                sTitle: "CharacterName",
                                mData: "character_name",
                            },
                            {
                                sTitle: "QuestionType",
                                mData: "desc",
                            },
							{
                                sTitle: "Message",
                                mData: "message",
                            },
                            {
                                sTitle: "Status",
                                mData: "status",
                                mRender: function(data){
                                    return (data == 0) ? "<span style='color:green'>Chưa phản hồi</span>" : "<span style='color:red'>Đã phản hồi</span>";
                                }

                            },
                            {
                                sTitle: "Action",
                                mData: "idx",
                                mRender: function(data){
                                    return "<a href='?control=supportbanca&func=edit&module=all&ids="+data+"'>Reply</a>";
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
            <?php include APPPATH . 'views/game/fish/Events/support/tab.php'; ?>
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

