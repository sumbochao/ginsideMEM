<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
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
        $('#index').on('click', function (e) {
            window.location.href = "?control=checkaccount&func=index&module=all&game=giangma";
        });
        $('#searchcardinfo').on('click', function (e) {
            window.location.href = "?control=checkaccount&func=searchcardinfo&module=all&game=giangma";
        });
        $('#searchitem').on('click', function (e) {
            window.location.href = "?control=checkaccount&func=searchitem&module=all&game=giangma";
        });
        $('#winquestinfo').on('click', function (e) {
            window.location.href = "?control=checkaccount&func=winquestinfo&module=all&game=giangma";
        });
        $('#giftcodeinfo').on('click', function (e) {
            window.location.href = "?control=checkaccount&func=giftcodeinfo&module=all&game=giangma";
        });
        $('#drawcardinfo').on('click', function (e) {
            window.location.href = "?control=checkaccount&func=drawcardinfo&module=all&game=giangma";
        });
        $('#playermailinfo').on('click', function (e) {
            window.location.href = "?control=checkaccount&func=playermailinfo&module=all&game=giangma";
        });
        $('#getplayerinfobyvip').on('click', function (e) {
            window.location.href = "?control=checkaccount&func=getplayerinfobyvip&module=all&game=giangma";
        });
    });
</script>
<h4 class="widget-name"><?php echo $title; ?></h4>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" <?php echo ($_GET['func']=='index')?'class="active"':'';?>><a id="index" href="javascript:;" aria-controls="index" role="tab" data-toggle="tab">Kiểm tra user</a></li>
    <li role="presentation" <?php echo ($_GET['func']=='searchcardinfo')?'class="active"':'';?>><a id="searchcardinfo" href="javascript:;" aria-controls="searchcardinfo" role="tab" data-toggle="tab">Tướng Nguyên Thần</a></li>
    <li role="presentation" <?php echo ($_GET['func']=='searchitem')?'class="active"':'';?>><a id="searchitem" href="javascript:;" aria-controls="searchitem" role="tab" data-toggle="tab">Túi</a></li>
    <li role="presentation" <?php echo ($_GET['func']=='winquestinfo')?'class="active"':'';?>><a id="winquestinfo" href="javascript:;" aria-controls="winquestinfo" role="tab" data-toggle="tab">Phó bản</a></li>
    <li role="presentation" <?php echo ($_GET['func']=='giftcodeinfo')?'class="active"':'';?>><a id="giftcodeinfo" href="javascript:;" aria-controls="giftcodeinfo" role="tab" data-toggle="tab">Giftcode</a></li>
    <li role="presentation" <?php echo ($_GET['func']=='drawcardinfo')?'class="active"':'';?>><a id="drawcardinfo" href="javascript:;" aria-controls="drawcardinfo" role="tab" data-toggle="tab">Rút Tướng</a></li>
    <li role="presentation" <?php echo ($_GET['func']=='playermailinfo')?'class="active"':'';?>><a id="playermailinfo" href="javascript:;" aria-controls="playermailinfo" role="tab" data-toggle="tab">Thư</a></li>
    <li role="presentation" <?php echo ($_GET['func']=='getplayerinfobyvip')?'class="active"':'';?>><a id="getplayerinfobyvip" href="javascript:;" aria-controls="getplayerinfobyvip" role="tab" data-toggle="tab">Thông tin gamer dựa vào vip</a></li>
</ul>