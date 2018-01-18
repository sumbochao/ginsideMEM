<style>
    .modal{
        top:5%;left: 10%;right: 10%;
        background: #FFF;
        overflow: visible;
        border-radius: 5px;
        height: 517px;
    }
    .modal-header{
        padding: 0px 0px 0px 10px;
    }
    .modal-footer{
        padding:10px 20px 20px 19px;
    }
    .modal-header .close{
        margin-right: 10px;
    }
    @media (max-width:999px){
        .modal-footer{
            margin-top: 0px;
        }
    }
    .sttserver{
        color: red;
    }
</style>
<div class="wrapper_list">
    <div class="listserver">
        <?php
            if(count($mappingserver[$arrFilter['groupserver']]['data'])>0){
                foreach($mappingserver[$arrFilter['groupserver']]['data'] as $v){
        ?>
        <div class="rows">
            <span><a class="icon-view"> <span class="sttserver"><?php echo $v['server_id'];?>:</span><?php echo $v['server_name'];?></a></span>
        </div>
        <?php
                }
            }
        ?>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>