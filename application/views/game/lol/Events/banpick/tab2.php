<script type="text/javascript" src="/libraries/jqwidgets32/jqx-all.js"></script>
<link href='/libraries/jqwidgets32/styles/jqx.base.css' rel='stylesheet' type='text/css'>
<link href='/libraries/jqwidgets32/styles/jqx.classic.css' rel='stylesheet' type='text/css'>
<link href='/libraries/pannonia/pannonia/css/plugins.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/libraries/cms/jquery.form.js"></script>
<script>
    $(document).ready(function () {
        // Javascript to enable link to tab
        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href=#' + url.split('#')[1] + ']').tab('show');
        }
        // Change hash for page-reload
        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        });
    });

    $(function () {  
        $('#league1').on('click', function (e) {
            window.location.href = "/?control=banpick_lol&func=league1&module=all";
        });
        $('#config').on('click', function (e) {
            window.location.href = "/?control=banpick_lol&func=index&view=config&module=all";
        });
        $('#user').on('click', function (e) {
            window.location.href = "/?control=banpick_lol&func=index&view=user&module=all";
        });
        $('#listteam').on('click', function (e) {
            window.location.href = "/?control=banpick_lol&func=index&view=listteam&module=all";
        });
    });
</script>
<style>
.loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
.groupwall{
    font-weight: bold;
}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name"><?php echo $title;?>
<?php
    if($_GET['func']=='addwall'){
        echo " :<span class='groupwall' style='color:".$items['color']."'> ".$items['name']."</span>";
    }
?>
</h4>
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" <?php echo $_GET['func']=='league1'?'class="active"':'';?>><a id="league1" href="#league1" aria-controls="league1" role="tab" data-toggle="tab">RESET BP</a></li>
    <li role="presentation" <?php echo $_GET['view']=='config'?'class="active"':'';?>><a id="config" href="#config" aria-controls="config" role="tab" data-toggle="tab">CẤU HÌNH BP</a></li>
    <li role="presentation" <?php echo $_GET['view']=='user'?'class="active"':'';?>><a id="user" href="#user" aria-controls="user" role="tab" data-toggle="tab">THÀNH VIÊN ĐL</a></li>
	<li role="presentation" <?php echo $_GET['view']=='listteam'?'class="active"':'';?>><a id="listteam" href="#listteam" aria-controls="listteam" role="tab" data-toggle="tab">LỊCH SỬ ĐL</a></li>
</ul>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mySmallModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body"><div id="messgage" style="text-align: center;"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->