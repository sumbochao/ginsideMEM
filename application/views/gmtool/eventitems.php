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
			$('#create_tournament').on('click', function () {
                window.location.href = '/?control=gmtool&func=addeventitems';
            });
        });
		//url: "http://game.mobo.vn/phongthan/cms/gmtool/getconfigEvent",
        function getData() {
            $.ajax({
                url: "http://game.mobo.vn/bog/cms/gmtool/getconfigEvent",
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
                                sTitle: "GAME",
                                mData: "game",

                            },
                            {
                                sTitle: "TITLE",
                                mData: "title",
                            },
							{
                                sTitle: "DESCRIPTION",
                                mData: "des",
                            },
							{
                                sTitle: "ACTOR",
                                mData: "actor",
                            },
							{
                                sTitle: "ACTOR APPROVE",
                                mData: "actor_app",
                            },
							{
                                sTitle: "START_DATE",
                                mData: "start",
                            },
							{
                                sTitle: "END_DATE",
                                mData: "end",
                            },
							{
                                sTitle: "IS REAL",
                                mData: "issendreal",
                                mRender: function (data) {
                                    return (data === "1") ? "<span style='color:blue'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                }
                            },
                            {
                                sTitle: "PULIC_ALL",
                                mData: "ispublic",
                                mRender: function (data) {
                                    return (data === "1") ? "<span style='color:blue'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                }
                            },
							{
                                sTitle: "Action",
                                mData: "idx",
                                mRender: function(data,type, full ){
                                    return "<a href='?control=gmtool&func=updateeventitems&ids="+data+"&game="+full.game+"&actor="+full.actor+"&title="+full.title+"'>Duyệt</a>";
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
            <?php include APPPATH . 'views/gmtool/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_tournament"  class="btn btn-primary"><span>THÊM EVENTITEMS</span></button>
                    </div>                               
                    <table class="table table-striped table-bordered" id="data_table">      
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