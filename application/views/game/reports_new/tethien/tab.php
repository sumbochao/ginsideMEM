<style>
    .nav > li > a{
        padding: 5px;
    }
</style>
<script>
    $(function () {        
        $('#user_active_by_server').on('click', function (e) {
            window.location.href = "/?control=reports&func=user_active_byserver&module=all&game=<?php echo $_GET['game'];?>#user_active_by_server";
        });
        $('#user_active_by_date').on('click', function (e) {
            window.location.href = "/?control=reports&func=user_active_bydate&module=all&game=<?php echo $_GET['game'];?>#user_active_by_date";
        });
        $('#level_active_by_server').on('click', function (e) {
            window.location.href = "/?control=reports&func=level_active_byserver&module=all&game=<?php echo $_GET['game'];?>#level_active_by_server";
        });
        $('#level_active_by_date').on('click', function (e) {
            window.location.href = "/?control=reports&func=level_active_bydate&module=all&game=<?php echo $_GET['game'];?>#level_active_by_date";
        });
        $('#level_statistics_by_date').on('click', function (e) {
            window.location.href = "/?control=reports&func=level_statistics_bydate&module=all&game=<?php echo $_GET['game'];?>#level_statistics_by_date";
        });
        $('#money_bydate').on('click', function (e) {
            window.location.href = "/?control=reports&func=money_bydate&module=all&game=<?php echo $_GET['game'];?>#money_bydate";
        });
        $('#vip_statistics_bydate').on('click', function (e) {
            window.location.href = "/?control=reports&func=vip_statistics_bydate&module=all&game=<?php echo $_GET['game'];?>#vip_statistics_bydate";
        });
        $('#vip_statistics_byserver').on('click', function (e) {
            window.location.href = "/?control=reports&func=vip_statistics_byserver&module=all&game=<?php echo $_GET['game'];?>#vip_statistics_byserver";
        });
        $('#card_statistics_bydate').on('click', function (e) {
            window.location.href = "/?control=reports&func=card_statistics_bydate&module=all&game=<?php echo $_GET['game'];?>#card_statistics_bydate";
        });
        $('#card_statistics_byserver').on('click', function (e) {
            window.location.href = "/?control=reports&func=card_statistics_byserver&module=all&game=<?php echo $_GET['game'];?>#card_statistics_byserver";
        });
    });
</script>
<ul role="tablist" class="nav nav-tabs">
    <li class="<?php echo ($_GET['func']=='user_active_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="user_active_by_server" href="#user_active_by_server" id="user_active_by_server">TK kích hoạt theo server</a></li>
    <li class="<?php echo ($_GET['func']=='user_active_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="user_active_by_date" href="#user_active_by_date" id="user_active_by_date">TK kích hoạt theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='level_active_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_active_by_server" href="#level_active_by_server" id="level_active_by_server">Level active theo server</a></li>
    <li class="<?php echo ($_GET['func']=='level_active_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_active_by_date" href="#level_active_by_date" id="level_active_by_date">Level active theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='level_statistics_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_statistics_by_date" href="#level_statistics_by_date" id="level_statistics_by_date">Thống kê level theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='money_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="money_bydate" href="#money_bydate" id="money_bydate">Vàng tồn trong game theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='vip_statistics_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="vip_statistics_bydate" href="#vip_statistics_bydate" id="vip_statistics_bydate"> VIP Theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='vip_statistics_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="vip_statistics_byserver" href="#vip_statistics_byserver" id="vip_statistics_byserver"> VIP Theo server</a></li>
    <li class="<?php echo ($_GET['func']=='card_statistics_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="card_statistics_bydate" href="#card_statistics_bydate" id="card_statistics_bydate"> Card tướng theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='card_statistics_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="card_statistics_byserver" href="#card_statistics_byserver" id="card_statistics_byserver"> Card tướng theo server</a></li>
</ul>