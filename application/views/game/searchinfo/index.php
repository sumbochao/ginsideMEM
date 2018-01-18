<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

<script src="<?php echo base_url('assets/multiselect/js/bootstrap-multiselect.js') ?>"></script>
<script src="<?php echo base_url('assets/multiselect/js/prettify.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/bootstrap-multiselect.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/prettify.css') ?>"/>
<style>
.modal-footer{
	border-top:0px;
}
.loadserver .textinput{
    width:205px;
    margin-top:10px;
}
.textinput{
    width: 100%;
    margin-bottom: 8px;
}
.wraptextinput{
    position: relative;
    top:1px;
}
.wrapp_server{
    position: relative;
    top: -5px;
}
.multiselect-container{
    height: 300px;
    overflow: auto;
}
.content_name_game{
    width: 100%;
    height: 50px;
}
.icon-remove{
    background: url(../assets/img/trash.png) no-repeat;
    width: 16px;
    height: 16px;
    float: left;
    cursor: pointer;
}
.listserver{
    border: 1px solid #CCC;
    padding: 7px 5px 0px 5px;
    width: 100%;
    margin-top: 10px;
    float: left;
    min-height: 35px;
}
.listserver .rows{
    width: 182px;
    float: left;
    margin-bottom: 7px;
}
.listserver .icon-view{
    white-space: nowrap;
    display: block;
    float: left;
    margin-left:3px;
    margin-top:-1px;
    text-decoration: none;
}
.red{
    color: red;
}
.not_empty{
    margin-bottom: 10px;
}
.btnview{
    float: left;
    margin-left: 5px;
    margin-top: 10px;
}
.wrapper_scroolbar{
    margin-top: 10px;
}
.modal-body{
    padding: 20px;
}
.title_list{
    margin-bottom: 12px;
    margin-top: 5px;
}
.circle_stt{
    background: green;
    padding: 6px 10px;
    color: #FFF;
    border-radius: 100%;
}
.circle-text {
    width:1.4%;
    margin-right: 5px;
    margin-top: -5px;
    float: left;
}
.circle-text:after {
    content: "";
    display: block;
    width: 100%;
    height:0;
    padding-bottom: 100%;
    background:green; 
    -moz-border-radius: 50%; 
    -webkit-border-radius: 50%; 
    border-radius: 50%;
}
.circle-text div {
    float:left;
    width:100%;
    padding-top:50%;
    line-height:1em;
    margin-top:-0.5em;
    text-align:center;
    color:white;
}
</style>
<div class="loading_warning"></div>
<?php
    $this->load->MeAPI_Model('SearchInfoModel');
    $tblSearchInfo = new SearchInfoModel();
?>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <div class="filter">
            <div class="wraptextinput">
                <input type="text" class="textinput" name="keyword" value="<?php echo $arrFilter['keyword'];?>" placeholder="Cho phép tra cứu tối đa 10 tài khoản (mobo id hoặc mobo service id) và phân biệt bằng dấu ; Ví dụ 123456789;1234567891234567890" title="moboid, mobo service id"/>
            </div>
            <script>
                jQuery('.dropdown input, .dropdown label').click(function (event) {
                    event.stopPropagation();
                });
                jQuery(document).ready(function () {
                    jQuery('.slbgame').multiselect({
                        includeSelectAllOption: true,
                        enableCaseInsensitiveFiltering: true
                    });
                });
            </script>
            <select name="game_id" class="game_id slbgame" onchange="getServerByGame(this.value)">
                <option value="" <?php echo ($arrFilter['game_id']=='')?'selected="selected"':'';?>>Chọn game</option>
                <?php
                    if(count($slbGame)>0){
                        foreach($slbGame as $v){
                ?>
                <option value="<?php echo $v['app_name'];?>" <?php echo ($arrFilter['game_id']==$v['app_name'])?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                <?php
                        }
                    }
                ?>
            </select>

            <script>
                jQuery('.dropdown input, .dropdown label').click(function (event) {
                    event.stopPropagation();
                });
                jQuery(document).ready(function () {
                    jQuery('.group').multiselect({
                        includeSelectAllOption: true,
                        enableCaseInsensitiveFiltering: true
                    });
                });
            </script>
            <select class="group" name="group" style="width:150px;" onchange="getServerByGroup(this.value)">
                <option value="0">Chọn server</option>
                <option value="1" <?php echo $arrFilter['group']==1?'selected="selected"':'';?>>Theo server</option>
                <option value="2" <?php echo $arrFilter['group']==2?'selected="selected"':'';?>>Theo cụm server</option>
            </select>
            
            <span class="loading_select">
                <?php 
                    if($arrFilter['group']==2 && !empty($arrFilter['game_id'])){
                        include_once 'common/selectserver.php';
                    }
                    if($arrFilter['group']==1 && !empty($arrFilter['game_id'])){
                        echo '<a href="#addserver" onclick="loadIframecontentServer();" class="btn btn-success"  data-toggle="modal">Chọn server</a>';
                    }
                ?>
            </span>
            <input type="button" onclick="onSubmitAjax('appForm','<?php echo base_url().'?control=search_info&func=index&type=filter';?>')" value="Tìm" class="btn btn-primary"/>
            <div class="loading_popup">
                <?php 
                    if($arrFilter['group']==1 && !empty($arrFilter['game_id'])){
                        include_once 'common/listserver.php';
                    }
                    if($arrFilter['group']==2 && !empty($arrFilter['game_id'])){
                        include_once 'common/selectedserver.php';
                    }
                ?>
            </div>
        </div>
        <div class="<?php echo count($listItems)>0?'wrapper_scroolbar':'';?>">
            <div class="<?php echo count($listItems)>0?'scroolbar':'';?>">
                <?php
                    if(count($listItems)>0){
                        $i=0;
                        foreach($listItems as $table){
                            $i++;
                            
                ?>
                <div class="title_list">
                    <?php if($table['title']['mobo_service_id']!='empty'){ ?>
                        <?php
                            echo '<div class="circle-text"><div>'.$i.'</div></div> ';
                            if(!empty($table['title']['mobo_id'])){
                                echo 'Mobo ID :<b>'.$table['title']['mobo_id'].'</b> - ';
                            }
                        ?>
                    Mobo Service ID : <b><?php echo $table['title']['mobo_service_id'];?></b>
                    <?php
                        }else{
                    ?>
                    <div class="not_empty">
                       <?php
                            echo '<div class="circle-text"><div>'.$i.'</div></div> ';
                            if(!empty($table['title']['mobo_id'])){
                                echo 'Mobo ID :<b>'.$table['title']['mobo_id'].'</b> <span class="red">không tồn tại </span>';
                            }
                        ?> 
                    </div>
                    <?php  }?>
                </div>
                <div class="clr"></div>
                <?php if($table['title']['mobo_service_id']!='empty'){ ?>
                <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th align="center">STT</th>
                            <th align="center" width="200px">Server</th>
                            <?php
                            
                                if(count($resultTitle)>0){
                                    foreach($resultTitle as $k=>$v){
                            ?>
                            <th align="center"><?php echo $k;?></th>
                            <?php
                                    }
                                }
                            ?>
                        </tr>
                    </thead>
					<?php
						if($_POST['game_id']=='bog'){
					?>
					<tbody>
                        <?php
							
                            if(count($table['data'])>0){
                                $j=0;
                                foreach($table['data'] as $k=>$v){
                                    $j++;
                                    $result = $tblSearchInfo->getItemByServer($k,$_POST['game_id']);
									if(count($v)>0){
										$a=0;
										foreach($v as $ksub=>$vsub){
											$a++;
                        ?>
                        <tr>
							<?php
								if($a==1){
							?>
                            <td align="center" rowspan="<?php echo count($v);?>"><?php echo $j;?></td>
                            <td align="center" rowspan="<?php echo count($v);?>"><?php echo $result['server_name'];?></td>
								<?php } ?>
							<?php
								if(count($vsub)>0){
									foreach($vsub as $ksubkey =>$vvubval){
							?>
                            <td align="center"><?php echo $vvubval; ?></td>
							<?php
									}
								}
							?>
                        </tr>
                        <?php
										}
									}else{
						?>
						<tr>
                            <td align="center" rowspan="1"><?php echo $j;?></td>
                            <td align="center" rowspan="1"><?php echo $result['server_name'];?></td>
                            <td colspan="<?php echo count($v);?>" class="emptydata" style="text-align:left">
                                Dữ liệu không tìm thấy
                            </td>
                        </tr>
						<?php
									}
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
					<?php
						}else{
					?>
					<tbody>
                        <?php
                            if(count($table['data'])>0){
                                $j=0;
                                foreach($table['data'] as $k=>$v){
									
                                    $j++;
                                    $result = $tblSearchInfo->getItemByServer($k,$_POST['game_id']);
                        ?>
                        <tr>
                            <td align="center"><?php echo $j;?></td>
                            <td align="center"><?php echo $result['server_name'];?></td>
                            <?php 
                                if(is_array($v)){
                                    foreach($v as $ks=>$s){
                            ?>
                            <td align="center"><?php echo $s;?></td>
                            <?php
                                    }
                                }else{
                            ?>
                            <td colspan="<?php echo count($resultTitle);?>" class="emptydata" style="text-align:left">
                                Dữ liệu không tìm thấy
                            </td>
                            <?php } ?>
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
					<?php
						}
					?>
                </table>
                <?php
                        }
                ?>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
        <?php echo $pages?>
    </form>
</div>

<script type="text/javascript">
    function viewData(title,info){
        var url =baseUrl +'?control=search_info&func=viewdata';
        jQuery.ajax({
            url:url,
            type:"POST",
            data:{title:title,info:info},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(f.error==0){
                    $('<div class="modal fade load_popup"></div>').html(f.html).modal();
                }
                $('.loading_warning').hide();
            }
        });
    }
    function getServerByGame(game_id){
        var group = $(".group").val();
        if(group==1 && game_id !=""){
            getPopupAjax(game_id,group);
        }
        if(group==2 && game_id !=""){
            getSelectAjax(game_id,group);
        }
        if(group==0){
            $(".loading_select").html("");
            $(".wrapper_list").html("");
        }
    }
    function getServerByGroup(group){
        var game_id = $(".game_id").val();
        if(group==1 && game_id !=""){
            getPopupAjax(game_id,group);
        }
        if(group==2 && game_id !=""){
            getSelectAjax(game_id,group);
        }
        if(group==0){
            $(".loading_select").html("");
            $(".wrapper_list").html("");
        }
    }
    function getSelectAjax(game_id,group){
        $.ajax({
            url:baseUrl+'?control=search_info&func=getselect',
            type:"POST",
            data:{game_id:game_id,group:group},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.error!="undefined" && f.error==0){
                    $('.loading_popup').html('');
                    $('.loading_select').html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
     
    function getPopupAjax(game_id,group){
        var lid = "";
        jQuery("#divservercontent").find(".contentServer").each(function(){
            lid += ","+jQuery(this).find(".icon-remove").attr("itemid");
        });
        if(lid != ""){
            lid = lid.substring(1);
        }
        $.ajax({
            url:baseUrl+'?control=search_info&func=getpopup',
            type:"POST",
            data:{game_id:game_id,group:group},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.error!="undefined" && f.error==0){
                    $('.loading_popup').html(f.html);
                    $('.loading_select').html("");
                    $('.loading_warning').hide();
                    $(".loading_select").html('<a href="#addserver" onclick="loadIframecontentServer();" class="btn btn-success"  data-toggle="modal">Chọn server</a>');
                }
            }
        });
    }
    jQuery('input[name=keyword]').keypress(function(event) {
        if (event.keyCode == '13') {
            onSubmitFormAjax('appForm','<?php echo base_url().'?control=search_info&func=index&type=filter';?>');
            return false;
        }
        return true;
    });
    function onSubmitAjax(formName,url){
        var game_id = $('select[name=game_id]').val();
        var keyword = $("input[name=keyword]").val();
        var content_server = $("#content_server").val();
        var group = $("select[name=group]").val();
        var groupserver = $(".groupserver").val();
        $.ajax({
            url:baseUrl+'?control=search_info&func=getvalidate',
            type:"POST",
            data:{game_id:game_id,keyword:keyword,group:group,content_server:content_server,groupserver:groupserver},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.error!="undefined" && f.error==0){
                    $('.loading_warning').hide();
                    var theForm = document.getElementById(formName);
                    theForm.action = url;	
                    theForm.submit();	
                    return true;
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $('.loading_warning').hide();
                }
            }
        });
    }
</script>