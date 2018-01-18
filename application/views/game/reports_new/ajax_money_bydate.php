<?php
    if($_REQUEST['game']=='bog'){
?>
<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">Date</th>
            <th align="center" width="100px">ServerID</th>
            <th align="center" width="100px">Lam Ngọc(Balance)</th>
            <th align="center" width="100px">Hồng Ngọc(BindBalance)</th>
            <th align="center" width="100px">Gold(Money)</th>
            <th align="center" width="100px">Matinh(EnergyP)</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(is_array($listItems)){
                $totalBalance = 0;
                $totalBindBalance = 0;
                $totalMoney = 0;
                $totalEnergyP = 0;
                foreach($listItems as $v){
                    $totalBalance +=$v['Balance'];
                    $totalBindBalance +=$v['BindBalance'];
                    $totalMoney +=$v['Money'];
                    $totalEnergyP +=$v['EnergyP'];
        ?>
        <tr>
            <td><?php echo $v['date'];?></td>
            <td><?php echo $v['serverid'];?></td>
            <td><?php echo ($v['Balance']>0)?number_format($v['Balance']):'0';?></td>
            <td><?php echo ($v['BindBalance']>0)?number_format($v['BindBalance']):'0';?></td>
            <td><?php echo ($v['Money']>0)?number_format($v['Money']):'0';?></td>
            <td><?php echo ($v['EnergyP']>0)?number_format($v['EnergyP']):'0';?></td>
        </tr>
        <?php
                }
        ?>
        <tr>
            <td colspan="2">Tổng cộng</td>
            <td><?php echo ($totalBalance>0)?number_format($totalBalance):'0'?></td>
            <td><?php echo ($totalBindBalance>0)?number_format($totalBindBalance):'0'?></td>
            <td><?php echo ($totalMoney>0)?number_format($totalMoney):'0'?></td>
            <td><?php echo ($totalEnergyP>0)?number_format($totalEnergyP):'0'?></td>
        </tr>
        <?php
            }else{
        ?>
        <tr>
            <td colspan="6" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
<?php
    }else{
?>
<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">ServerID</th>
            <th align="center" width="100px">Diamond</th>
            <th align="center" width="100px">Gold</th>
            <th align="center" width="100px">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(is_array($listItems)){
                foreach($listItems as $v){
        ?>
        <tr>
            <td><?php echo $v['serverid'];?></td>
            <td><?php echo ($v['diamond']>0)?number_format($v['diamond']):'0';?></td>
            <td><?php echo ($v['gold']>0)?number_format($v['gold']):'0';?></td>
            <td><?php echo ($v['amount']>0)?number_format($v['amount']):'0';?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="12" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
<?php
    }
?>