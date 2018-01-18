<script>
    $(function () {        
        $('#user_active_by_server').on('click', function (e) {
            window.location.href = "/?control=reports&func=user_active_byserver&module=all&game=<?php echo $_GET['game'];?>#user_active_by_server";
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
        $('#topup_by_server').on('click', function (e) {
            window.location.href = "/?control=reports&func=topup_byserver&module=all&game=<?php echo $_GET['game'];?>#topup_by_server";
        });
        $('#money').on('click', function (e) {
            window.location.href = "/?control=reports&func=money&module=all&game=<?php echo $_GET['game'];?>#money";
        });
        $('#money_bydate').on('click', function (e) {
            window.location.href = "/?control=reports&func=money_bydate&module=all&game=<?php echo $_GET['game'];?>#money_bydate";
        });
        $('#card_statistics').on('click', function (e) {
            window.location.href = "/?control=reports&func=card_statistics&module=all&game=<?php echo $_GET['game'];?>#card_statistics";
        });
		$('#list_vip_byserver').on('click', function (e) {
            window.location.href = "/?control=reports&func=list_vip_byserver&module=all&game=<?php echo $_GET['game'];?>#list_vip_byserver";
        });
    });
</script>
<ul role="tablist" class="nav nav-tabs">
    <li class="<?php echo ($_GET['func']=='user_active_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="user_active_by_server" href="#user_active_by_server" id="user_active_by_server">TK kích hoạt theo server</a></li>
    <li class="<?php echo ($_GET['func']=='level_active_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_active_by_server" href="#level_active_by_server" id="level_active_by_server">Level active theo server</a></li>
    <li class="<?php echo ($_GET['func']=='level_active_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_active_by_date" href="#level_active_by_date" id="level_active_by_date">Level active theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='level_statistics_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_statistics_by_date" href="#level_statistics_by_date" id="level_statistics_by_date">Thống kê level theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='topup_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="topup_by_server" href="#topup_by_server" id="topup_by_server">Top nạp tiền</a></li>
    <li class="<?php echo ($_GET['func']=='money')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="money" href="#money" id="money">Vàng tồn trong game</a></li>
    <li class="<?php echo ($_GET['func']=='money_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="money_bydate" href="#money_bydate" id="money_bydate">Vàng tồn trong game theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='card_statistics')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="card_statistics" href="#card_statistics" id="card_statistics">Card tồn trong game</a></li>
    <li class="<?php echo ($_GET['func']=='list_vip_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="list_vip_byserver" href="#list_vip_byserver" id="list_vip_byserver"> UID theo chỉ số VIP</a></li>
</ul>