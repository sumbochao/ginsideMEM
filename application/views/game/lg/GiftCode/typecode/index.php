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
            $('#create').on('click', function () {
                window.location.href = '/?control=giftcode_lg&func=add&view=<?php echo $_GET['view'];?>&module=<?php echo $_GET['module'];?>';
            });
        });
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/lg/GiftCode/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">
                            <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
                        </div>                               
                        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                            <thead>
                                <tr>
                                    <th align="center">Loại</th>
                                    <th align="center" width="70px">ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(empty($listItems) !== TRUE){
                                        foreach($listItems as $i=>$v){
                                ?>
                                <tr>
                                    <td><?php echo $v['code_type'];?></td>
                                    <td><?php echo $v['id'];?></td>
                                </tr>
                                <?php
                                        }
                                    }else{
                                ?>
                                <tr>
                                    <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>