<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100}
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
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
                            <a href="/?control=event_nhan_giftcode&func=showAddConfig&module=all#addconfig" class="btn btn-primary"><span>THÊM MỚI</span></a>
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

        <input type="hidden" id="game" name="game" value="<?php echo $game;?>">
    </div>
    <!-- /content -->
    <script type="text/javascript">
        (new TableDnD).init("tblsort");
    </script>

