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
            $('#clear_cache').on('click', function () {
                //window.location.href = 'http://service.eden.mobo.vn/cms/loandauvodai/clearMemcacheBox';

                $(".loading").fadeIn("fast");
                $.ajax({
                    url: "http://service.eden.mobo.vn/cms/loandauvodai/clearMemcacheBox",
                    dataType: 'jsonp',
                    method: "POST",
                    bRetrieve: true,
                    bDestroy: true,
                    error: function (jqXHR, textStatus, errorThrown) {
                    },
                    success: function (data, textStatus, jqXHR) {
                        $(".modal-body #messgage").html(data.message);
                        $('.bs-example-modal-sm').modal('show');
                        $(".loading").fadeOut("fast");
                    }
            });
            });  
        });
    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/eden/Events/LoanDauVoDai/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div style="margin-top: 10px; margin-bottom: 10px; text-align: center;">
                        <button id="clear_cache" class="btn btn-primary btn-lg"><span>XÓA CACHED ITEM</span></button>
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