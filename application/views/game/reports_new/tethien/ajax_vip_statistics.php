<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">Date</th>
            <th align="center" width="100px">ServerID</th>
            <th align="center" width="100px">Vip 0</th>
            <th align="center" width="100px">Vip 1</th>
            <th align="center" width="100px">Vip 2</th>
            <th align="center" width="100px">Vip 3</th>
            <th align="center" width="100px">Vip 4</th>
            <th align="center" width="100px">Vip 5</th>
            <th align="center" width="100px">Vip 6</th>
            <th align="center" width="100px">Vip 7</th>
            <th align="center" width="100px">Vip 8</th>
            <th align="center" width="100px">Vip 9</th>
            <th align="center" width="100px">Vip 10</th>
            <th align="center" width="100px">Vip 11</th>
            <th align="center" width="100px">Vip 12</th>
            <th align="center" width="100px">Vip 13</th>
            <th align="center" width="100px">Vip 14</th>
            <th align="center" width="100px">Vip 15</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(is_array($listItems)){
                $totalinput = 0;
                foreach($listItems as $v){
        ?>
        <tr>
            <td><?php echo $v['date'];?></td>
            <td><?php echo $v['serverID'];?></td>
            <td><?php echo $v['vip0'];?></td>
            <td><?php echo $v['vip1'];?></td>
            <td><?php echo $v['vip2'];?></td>
            <td><?php echo $v['vip3'];?></td>
            <td><?php echo $v['vip4'];?></td>
            <td><?php echo $v['vip5'];?></td>
            <td><?php echo $v['vip6'];?></td>
            <td><?php echo $v['vip7'];?></td>
            <td><?php echo $v['vip8'];?></td>
            <td><?php echo $v['vip9'];?></td>
            <td><?php echo $v['vip10'];?></td>
            <td><?php echo $v['vip11'];?></td>
            <td><?php echo $v['vip12'];?></td>
            <td><?php echo $v['vip13'];?></td>
            <td><?php echo $v['vip14'];?></td>
            <td><?php echo $v['vip15'];?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="18" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>