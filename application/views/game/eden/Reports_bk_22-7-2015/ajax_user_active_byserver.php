<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">Date</th>
            <th align="center" width="100px">Server</th>
            <th align="center" width="100px">New Active</th>
            <th align="center" width="100px">Total Active</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(count($listItems)>0){
                foreach($listItems as $v){
        ?>
        <tr>
            <td>
                <?php 
                    $date = new DateTime($v['date']);
                    echo $date->format('d-m-Y');
                ?>
            </td>
            <td><?php echo $v['server'];?></td>
            <td><?php echo ($v['new_active']>0)?number_format($v['new_active'],0,',','.'):'0';?></td>
            <td><?php echo ($v['total_active']>0)?number_format($v['total_active'],0,',','.'):'0';?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="4" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>