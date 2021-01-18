<section class="container main-container">
    <div style="padding-left:20px;">
        <h3 class="text-center">ประวัติการเข้าอบรม</h3>

        <div class="clearfix mbl mtm">
            <ul class="lfloat" ref="control">
                <li>
                    <span for="price">ค่าสมัครอบรม</span> 
                    <?php
                    $price_status[] = ['id'=>'pay', 'name'=>'มีค่าใช้จ่าย'];
                    $price_status[] = ['id'=>'free', 'name'=>'ไม่มีค่าใช้จ่าย'];
                    ?>
                    <select ref="selector" name="price" class="inputtext">
                        <option value="">- ทั้งหมด -</option>
                        <?php
                        foreach ($price_status as $key => $value) {
                        $sel = '';
                        if( !empty($_GET['price']) ){
                            if( $_GET['price'] == $value['id'] ) $sel = 'selected';
                        }
                        echo '<option value="'.$value['id'].'" '.$sel.'>'.$value['name'].'</option>';
                        }
                        ?>
                    </select>
                </li>
            </ul>
            <ul class="rfloat" ref="control">
                <li class="mt">
                    <form class="form-search" action="#">
                        <input class="inputtext search-input" type="text" id="search-query" placeholder="<?= $this->lang->translate('Search') ?>" name="q" autocomplete="off">
                        <span class="search-icon">
                            <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
                        </span>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover">
                <thead>
                    <tr>
                        <th width="1%" style="vertical-align: middle;">#</th>
                        <th width="40%" style="vertical-align: middle;">หลักสูตร</th>
                        <th width="15%" style="text-align: center;vertical-align: middle;">วันที่อบรม</th>
                        <th width="14%" style="text-align: center;vertical-align: middle;">ค่าสมัครอบรม<br>(บาท)</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">การจ่ายเงิน</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">สถานะ</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">ใบกำกับภาษี</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if( !empty($this->results['lists']) ){
                        foreach ($this->results['lists'] as $key => $value) {
                            $color ='red';
                            if ($value['open_status'] == 2) $color ='green';
                            ?>
                            <tr>
                                <td>
                                    <font color="<?=$color?>"><i class="fas fa-check-circle fa-1x"></i></font>
                                </td>
                                <td>
                                    <font size='3'><?= $value['course_name_th'] ?></font><br>
                                    <font size='2'><?= $value['course_name_en'] ?></font>
                                </td>
                                <td class="tac">
                                    <?= $this->fn->q('time')->str_event_date($value['open_startdate'], $value['open_enddate'], true) ?>
                                </td>
                                <td class="tac">
                                    <?php
                                    if ($value['open_price'] == 0.00) {
                                        echo "ฟรี";
                                    } else {
                                        $price = explode(".", $value['open_price']);
                                        echo $price[1] == 00 ? number_format($price[0]) . ".-" : number_format($value['open_price'], 2);
                                    }
                                    ?>
                                </td>
                                <td class="tac">
                                    <?=$value['status_pay_name']?>
                                    <?php
                                    if( $value['pay_status'] == 0 || $value['pay_status'] == 3 ){
                                        ?>
                                        <a href="<?=URL?>course/payregister/<?=$value['mem_id']?>/<?=$value['open_id']?>" data-plugins="dialog" class="btn btn-primary mts btn-sm">แจ้งชำระเงิน</a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td class="tac">
                                    <?=$value['status_name']?>
                                </td>
                                <td class="tac">
                                    <?php 
                                    if( $value['open_price'] > 0 ){
                                        if( empty($value['invoice']) ){
                                            echo '<a class="btn btn-primary btn-sm" href="'.URL.'invoice/request/'.$value['course_id'].'/'.$value['open_id'].'">ร้องขอ</a>';
                                        }
                                        else{
                                            $disabled = '';
                                            $color = 'btn-info';
                                            $url = 'href="'.URL.'invoice/request/'.$value['course_id'].'/'.$value['open_id'].'"';
                                            $txt = '<span>(คลิกเพื่อแก้ไข)</span>';
                                            if( $value['invoice']['status'] == 'approved' ){
                                                $disabled = 'disabled';
                                                $color = 'btn-success';
                                                $url = '';
                                                $txt = "";
                                            }

                                            echo '<a class="btn '.$color.'" '.$url.'>'.$value['invoice']['status_name'].'</a>';
                                            echo $txt;
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else{
                        echo '<tr><td colspan="5"><h3 class="fcr tac">ไม่พบข้อมูลการอบรม</h3></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div><!-- ปิดบอดี้พาแนล-->
    </div> <!-- ปิดพาแนล-->
</section>
<script type="text/javascript">
    $("[ref=selector]").change(function(){
        if( $(this).val() != "" ){
            window.location = Event.URL + 'history?price=' + $(this).val();
        }
        else{
            window.location = Event.URL + 'history';
        }
    });
</script>