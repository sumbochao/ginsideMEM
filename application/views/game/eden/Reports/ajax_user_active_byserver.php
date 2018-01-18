<?php
    $demserver = count($listServer);
    if($demserver>=4){
        $numColmns = ($demserver*300).'px';
    }else{
        $numColmns  ='100%;';
    }
?>
<div class="scroolbar" style="width:<?php echo $numColmns;?>">
    <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th align="center" width="100px" rowspan="2">Active Users</th>
                <?php
                    if(count($listServer)>0){
                        foreach($listServer as $v){
                ?>
                <th align="center" width="350px" colspan="3"><?php echo $v['server_name'];?></th>
                <?php

                        }
                    }
                ?>
            </tr>
            <tr>
                <?php
                    if(count($listServer)>0){
                        foreach($listServer as $v){
                ?>
                <th align="center">New Active</th>
                <th align="center">Daily Active</th>
                <th align="center">Total Active</th>
                <?php
                        }
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                if(count($listItems)>0){
                    foreach($listItems as $key=>$vtable){
            ?>
            <tr>
                <td>
                    <?php
                        $date = new DateTime($vtable['date']);
                        echo $date->format('d-m-Y');
                    ?>
                </td>
                <?php
                    foreach($vtable['data'] as $val){
                ?>
                <td><?php echo isset($val["new_active"])?number_format($val["new_active"],0,',','.'):"";?></td>
                <td><?php echo isset($val["daily_active"])?number_format($val["daily_active"],0,',','.'):""?></td>
                <td><?php echo isset($val["total_active"])?number_format($val["total_active"],0,',','.'):""?></td>
                <?php
                    }
                ?>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
</div>