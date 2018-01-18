<script>
    $(function () {        
        $('#topup_hourly').on('click', function (e) {
            window.location.href = "/?control=reports&func=topup_hourly&module=all&game=<?php echo $_GET['game'];?>";
        });
    });
</script>
<ul role="tablist" class="nav nav-tabs">
    <?php
        if((@in_array($_GET['control'].'-'.$_GET['func'].'-'.$_GET['game'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
    ?>
    <li class="<?php echo ($_GET['func']=='topup_hourly')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="topup_hourly" href="#topup_hourly" id="topup_hourly">Tiền nạp theo giờ</a></li>
    <?php } ?>
</ul>