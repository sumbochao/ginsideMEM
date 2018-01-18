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
                window.location.href = '/?control=giftcode_lg&func=add&view=<?php echo $_GET['view'];?>&module=<?php echo $_GET['module'];?>&code_type=<?php echo $_GET['code_type']?>&token=<?php echo $_GET['token'];?>';
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
            <div class="loading_warning"></div>
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow"> 
                        <div>
                            <select name="code_type" onchange="listingRedirectUrl('1','<?php echo base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all';?>',$(this),this.value)">
                                <option value="">Chọn loại code</option>
                                <?php
                                    if(count($slbTypeCode)>0){
                                        foreach($slbTypeCode as $v){
                                ?>
                                <option value="<?php echo $v['id']?>" <?php echo ($v['id']==$_GET['code_type'])?'selected="selected"':'';?>><?php echo $v['code_type']?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>                        
                        <div class="loadData">  
                            <?php
                                if(!empty($_GET['code_type'])){
                            ?>
                            <div style="margin-top: 10px; margin-bottom: 10px;">
                                <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
                            </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(!empty($_GET['code_type'])){
                                    if($listItems['result']=='0'){
                            ?>
                            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                                <thead>
                                    <tr>
                                        <th align="center">Username</th>
                                        <th align="center" width="150px">Code</th>
                                        <th align="center" width="150px">Giá trị</th>
                                        <th align="center" width="150px">Tình trạng</th>
                                        <th align="center" width="150px">Ngày tạo</th>
                                        <th align="center" width="150px">Loại code</th>
                                        <th align="center" width="150px">Received</th>
                                        <th align="center" width="70px">ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(empty($listItems['data']) !== TRUE){
                                            foreach($listItems['data'] as $i=>$v){
                                    ?>
                                    <tr>
                                        <td><?php echo $v['ause_username'];?></td>
                                        <td><?php echo $v['gift_code'];?></td>
                                        <td><?php echo $v['gift_code_value'];?></td>                                        
                                        <td><?php echo $v['gift_code_staus'];?></td>
                                        <td><?php echo date_format(date_create($v['gen_date']),"d-m-Y G:i:s");?></td>
                                        <td><?php echo $v['code_type_id'];?></td>
                                        <td><?php echo $v['received'];?></td>
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
                            <?php
                                }else{
                            ?>
                            <div style="color:red;text-align: center">Lấy thông tin thất bại</div>
                            <?php
                                }
                            ?>
                            <?php
                                }else{
                            ?>
                            <div style="color:red;text-align: center">Vui lòng chọn loại code</div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <input type="hidden" class="token" value="">
    <!-- /content -->
</div>
<script type="text/javascript">
    function listingRedirectUrl(ajax_config,url_value,current,code_type){
        if(ajax_config!=1){
            window.location.href=url_value+'&code_type='+code_type;
        }else{
            var baseUrl=url_value+'&code_type='+code_type;
            var call_data={ajax_active:"1",code_type:code_type};
            var arrFirst=url_value.split('?');
            var arrFinal=arrFirst[1].split('&');
            for(var i in arrFinal){
                if(arrFinal[i]=='ajax=1'){
                    arrFinal.splice(i,1);break;
                }
            }
            jQuery.ajax({
                type:"POST",
                url:baseUrl,
                data:call_data,
                dataType:'json',
                beforeSend:function(){
                    jQuery('.loading_warning').show();
                },
                success:function(f){
                    jQuery('.loadData').html(f.html);
                    if(code_type==0){
                        window.history.pushState("","","?"+arrFinal.join("&"));
                    }else{
                        window.history.pushState("","","?"+arrFinal.join("&")+'&code_type='+code_type+'&token='+f.token);
                    }
                    jQuery('.loading_warning').hide();
                }
            });
        }
    }
</script>