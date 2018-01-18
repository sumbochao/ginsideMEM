<script>
    $(function () { 
        $('#top_battlescore').on('click', function (e) {
            window.location.href = "/?control=reports&func=top_battlescore&game=<?php echo $_GET['game'];?>";
        });
    });
</script>
<ul role="tablist" class="nav nav-tabs">
    <?php
        if((@in_array($_GET['control'].'-'.$_GET['func'].'-'.$_GET['game'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
    ?>
    <li class="<?php echo ($_GET['func']=='top_battlescore')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="top_battlescore" href="#top_battlescore" id="top_battlescore">Điểm số trận chiến</a></li>
    <?php } ?>
</ul>