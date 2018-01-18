<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">STT</th>
            <th align="center" width="100px">User ID</th>
            <th align="center" width="100px">Username</th>
            <th align="center" width="100px">Server ID</th>
            <th align="center" width="100px">Tên</th>
            <th align="center" width="100px">Cấp độ</th>
            <th align="center" width="100px">Điểm số (Battlescore)</th>
            <th align="center" width="100px">Điểm số cao cấp (Leader Battlescore)</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(is_array($listItems)){
                $i = 0;
                foreach($listItems as $v){
                    $i++;
        ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $v['UserID'];?></td>
            <td><?php echo $v['Username'];?></td>
            <td><?php echo $v['ServerID'];?></td>
            <td><?php echo $v['Name'];?></td>
            <td><?php echo $v['Level'];?></td>
            <td><?php echo $v['Battlescore'];?></td>
            <td><?php echo $v['LeaderBattlescore'];?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="8" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>