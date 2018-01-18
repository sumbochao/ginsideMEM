<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="50px">ID</th>
            <th align="center" width="100px">Mobo Service ID</th>
            <th align="center" width="110px">Mgày giao dịch</th>
            <th align="center" width="110px">Số ngọc nạp</th>
            <th align="center" width="110px">Mã nhân vật</th>
            <th align="center" width="110px">Tên nhân vật</th>
            <th align="center" width="110px">Mã giao dịch</th>
            <th align="center" width="110px">Mục tiêu</th>
            <th align="center" width="110px">ServerID</th>
            <th align="center" width="110px">App Name</th>
            <th align="center" width="110px">Nguồn nạp</th>
            <th align="center" width="110px">Tình trạng</th>
            <th align="center" width="110px">Mô tả</th>
            <th align="center" width="110px">IP Client</th>
            <th align="center" width="110px">Số ngọc trước khi nạp</th>
            <th align="center" width="110px">Loại nạp</th>
            <th align="center" width="110px">Platform</th>
            <th align="center" width="110px">Loại giao dịch</th>
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
            <td><?php echo $v["mobo_service_id"];?></td>
            <td><?php echo date_format(date_create($v['log_date']),"d-m-Y G:i:s");?></td>
            <td><?php echo $v["amount"]>0?number_format($v['amount']):0;?></td>
            <td><?php echo $v["character_id"];?></td>
            <td><?php echo $v["character_name"];?></td>
            <td><?php echo $v["transaction_id"];?></td>
            <td>
                <?php
                    switch ($v['destination']){
                        case '1':
                            echo 'Vàng';
                            break;
                        case '2':
                            echo 'Chuyển tiền cá nhân lưu mobo account của tk gửi tặng';
                            break;
                        case '3':
                            echo 'Nạp tiền vào ví';
                            break;
                    }
                ?>
            </td>
            <td><?php echo $v["server_id"];?></td>
            <td><?php echo $v["app_name"];?></td>
            <td><?php echo $v["service_id"];?></td>
            <td>
                <?php
                    switch ($v['status']){
                        case '1':
                            echo 'Thành công';
                            break;
                        case '2':
                            echo 'Thất bại';
                            break;
                    }
                ?>
            </td>
            <td><?php echo $v["description"];?></td>
            <td><?php echo $v["ip_client"];?></td>
            <td><?php echo $v["older_amount"];?></td>
            <td>
                <?php
                    switch ($v['type']){
                        case '1':
                            echo 'Chuyển tiền vào ví';
                            break;
                        case '2':
                            echo 'Tiền thắng cược';
                            break;
                    }
                ?>
            </td>
            <td><?php echo $v["platform"];?></td>
            <td>
                <?php
                    switch ($v['sandbox']){
                        case '1':
                            echo 'Production';
                            break;
                        case '2':
                            echo 'Sandbox';
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
            <td colspan="18" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
        </tr> 
        <?php
            }
        ?>
    </tbody>
</table>