<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">STT</th>
            <th align="center" width="100px">User (Mobo Service ID)</th>
            <th align="center" width="100px">TotalInBalance (Tổng nạp trước đến nay (Lam Ngọc))</th>
            <th align="center" width="100px">LastInBalance (Lượng nạp ngày hôm trước (Lam Ngọc)</th>
            <th align="center" width="100px">Balance (Lượng Lam ngọc tồn)</th>
            <th align="center" width="100px">BindBalance (Lượng Hồng Ngọc tồn)</th>
            <th align="center" width="100px">Money (Lượng vàng tồn)</th>
            <th align="center" width="100px">EnergyP (Lượng ma tinh tồn)</th>
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
            <td><?php echo $v['user'];?></td>
            <td><?php echo $v['TotalInBalance'];?></td>
            <td><?php echo $v['LastInBalance'];?></td>
            <td><?php echo $v['Balance'];?></td>
            <td><?php echo $v['BindBalance'];?></td>
            <td><?php echo $v['Money'];?></td>
            <td><?php echo $v['EnergyP'];?></td>
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