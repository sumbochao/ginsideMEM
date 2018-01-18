<table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">Rank</th>
            <th align="center" width="100px">Character ID</th>
            <th align="center" width="100px">Character Name</th>
            <th align="center" width="100px">Apple</th>
            <th align="center" width="100px">Google</th>
            <th align="center" width="100px">Card</th>
            <th align="center" width="100px">Banking</th>
            <th align="center" width="100px">SMS</th>
            <th align="center" width="100px">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(count($listItems)>0){
                foreach($listItems as $v){
        ?>
        <tr>
            <td><?php echo $v['rank'];?></td>
            <td><?php echo $v['character_id'];?></td>
            <td><?php echo $v['character_name'];?></td>
            <td><?php echo ($v['Apple']>0)?number_format($v['Apple'],0,',','.'):'0';?></td>
            <td><?php echo ($v['Google']>0)?number_format($v['Google'],0,',','.'):'0';?></td>
            <td><?php echo ($v['Card']>0)?number_format($v['Card'],0,',','.'):'0';?></td>
            <td><?php echo ($v['Banking']>0)?number_format($v['Banking'],0,',','.'):'0';?></td>
            <td><?php echo ($v['SMS']>0)?number_format($v['SMS'],0,',','.'):'0';?></td>
            <td><?php echo ($v['Total']>0)?number_format($v['Total'],0,',','.'):'0';?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="9" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>