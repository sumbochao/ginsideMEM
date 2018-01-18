<script type="text/javascript" src="/libraries/jqwidgets32/jqx-all.js"></script>
<link href='/libraries/jqwidgets32/styles/jqx.base.css' rel='stylesheet' type='text/css'>
<link href='/libraries/jqwidgets32/styles/jqx.classic.css' rel='stylesheet' type='text/css'>
<link href='/libraries/pannonia/pannonia/css/plugins.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/libraries/cms/jquery.form.js"></script>
<?php
    if($_GET['iframe']!=1){
?>
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
        $('#rate').on('click', function (e) {
            window.location.href = "/?control=wallet&func=index&view=rate&module=all";
        });
        $('#wallet').on('click', function (e) {
            window.location.href = "/?control=wallet&func=history&view=wallet&module=all";
        });
        $('#logs').on('click', function (e) {
            window.location.href = "/?control=wallet&func=history&view=logs&module=all";
        });
        $('#used').on('click', function (e) {
            window.location.href = "/?control=wallet&func=history&view=used&module=all";
        });
		
		$('#statistical_payment').on('click', function (e) {
            window.location.href = "/?control=wallet&func=history&view=statistical_payment&module=all";
        });
    });
</script>
<style>
    .loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>

<h4 class="widget-name"><?php echo $title; ?></h4>
<ul class="nav nav-tabs" role="tablist">
<?php
	if($_SESSION['account']['id_group']==1){
?>
    <li role="presentation" <?php echo ($_GET['view'] == 'rate') ? 'class="active"' : ''; ?>><a id="rate" href="#rate" aria-controls="rate" role="tab" data-toggle="tab">RATE</a></li>
	<?php } ?>    
	<li role="presentation" <?php echo ($_GET['view'] == 'wallet') ? 'class="active"' : ''; ?>><a id="wallet" href="#wallet" aria-controls="wallet" role="tab" data-toggle="tab">Số tiền tồn lại</a></li>
    <li role="presentation" <?php echo ($_GET['view'] == 'logs') ? 'class="active"' : ''; ?>><a id="logs" href="#logs" aria-controls="logs" role="tab" data-toggle="tab">Lịch sử nạp tiền</a></li>
    <li role="presentation" <?php echo ($_GET['view'] == 'used') ? 'class="active"' : ''; ?>><a id="used" href="#used" aria-controls="used" role="tab" data-toggle="tab">Lịch sử user</a></li>
    <li role="presentation" <?php echo ($_GET['view'] == 'statistical_payment') ? 'class="active"' : ''; ?>><a id="statistical_payment" href="#statistical_payment" aria-controls="statistical_payment" role="tab" data-toggle="tab">STATISTICAL PAYMENT</a></li>
</ul>
<?php
    }
?>
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