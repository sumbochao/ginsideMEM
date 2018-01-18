<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="50px">ID</th>
            <th align="center" width="100px">Số ngọc hiện tại</th>
            <th align="center" width="110px">Tổng ngọc nạp vào</th>
            <th align="center" width="110px">Tổng ngọc xài</th>
            <th align="center" width="110px">Ngày tạo ví ngọc</th>
            <th align="center" width="110px">Trạng thái</th>
            <th align="center" width="110px">Loại tài khoản</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(count($listItems)>0){
                $i=0;
                foreach($listItems as $key=>$v){
                    $i++;
        ?>
        <tr>
            <td><?php echo $v['id'];?></td>
            <td><?php echo $v["amount"];?></td>
            <td><?php echo $v["amount_cashin"]>0?number_format($v['amount_cashin']):0;?></td>
            <td><?php echo $v["amount_cashout"]>0?number_format($v['amount_cashout']):0;?></td>
            <td><?php echo date_format(date_create($v['create_date']),"d-m-Y G:i:s");?></td>
            <td>
                <?php
                    switch ($v['status']){
                        case '0':
                            echo 'deactivate';
                            break;
                        case '1':
                            echo 'activate';
                            break;
                        case '2':
                            echo 'temp blocking';
                            break;
                        case '3':
                            echo 'blocked';
                            break;
                    }
                ?>
            </td>
            <td>
                <?php
                    switch ($v['account_type']){
                        case '0':
                            echo 'sandbox';
                            break;
                        case '1':
                            echo 'production';
                            break;
                    }
                ?>
            </td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="7" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
        </tr> 
        <?php
            }
        ?>
    </tbody>
</table>