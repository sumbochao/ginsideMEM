<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>

<script src="<?php echo base_url('assets/multiselect/js/bootstrap-multiselect.js') ?>"></script>
<script src="<?php echo base_url('assets/multiselect/js/prettify.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/bootstrap-multiselect.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/prettify.css') ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .well{
            min-height: 350px;
        }
        .list_team .title{
            font-weight: bold;
            font-size: 16px;
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .list_team .team{
            float: left;
            margin-right: 5%;
        }
    </style>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/lol/Events/banpick/tab2.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <script>
                        jQuery('.dropdown input, .dropdown label').click(function (event) {
                            event.stopPropagation();
                        });
                        jQuery(document).ready(function () {
                            jQuery('#example39').multiselect({
                                includeSelectAllOption: true,
                                enableCaseInsensitiveFiltering: true
                            });
                        });
                    </script>
                    <select id="example39" class="server" name="server[]" >
                       <option value="0">Danh sách thành viên</option>
                       <?php
                            if(count($list_user)>0){
                                foreach($list_user as $v){
                       ?>
                       <option value="<?php echo $v['mobo_id'];?>"><?php echo !empty($v['fullname'])?$v['fullname']:'Unknown';?></option>
                       <?php
                                }
                            }
                       ?>
                    </select>
                    <div class="list_team load_team"></div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    $(function(){
        $("#example39").change(function(){
            $.ajax({
                url:baseUrl+'/?control=banpick_lol&func=load_team&module=all',
                type:"POST",
                data:{mobo_id:$(this).val()},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    $('.loading_warning').hide();
                    if(typeof f.error!="undefined"&&f.error==0){
                        $(".load_team").html(f.html);
                    }else{
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    }
                }
            });
        });
    });
</script>