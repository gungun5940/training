<section class="container main-container">
    <div style="padding-top:20px;">
        <div class="infobrline_orange">
            <b>* คำชี้แจง...</b><br>
            เนื่องจากหลักสูตรอบรมได้รับความสนใจเป็นจำนวนมาก<br>
            ดังนั้นศูนย์ถ่ายทอดเทคโนโลยีและวิศวกรรมจึงขอจำกัดสิทธิ์ โดยจำนวนผู้เข้าร่วมอบรมจริงจะขึ้นอยู่กับจำนวนผู้ยืนยันการลงทะเบียน<br>
            ผู้สมัครกรุณาเข้า<b><u>
                    <font color='#ac2925'>ยืนยันการลงทะเบียน</font>
                </u></b>ภายในระยะเวลาที่กำหนดเท่านั้น โดยยืนยันการลงทะเบียนได้ที่เมนู "ยืนยันการลงทะเบียน"<br>
            <b>** ต้องการยกเลิกการสมัคร ** </b>กรุณาโทรติดต่อศูนย์ถ่ายทอดเทคโนโลยีและวิศวกรรมโดยตรง 054-237399 ต่อ 6000 ต่อ 103<br>
            <br>
            <b>** ที่นั่งมีจำนวนจำกัด ** </b>ผู้ที่จะได้รับสิทธิ์เข้าร่วมอบรมจริง ขึ้นอยู่กับลำดับก่อน-หลังในการเข้ายืนยันการลงทะเบียน
        </div>
    </div>
    <div style="padding-left:20px;">
        <h4>จำนวนผู้เข้าอบรมในแต่ละหลักสูตร</h4>
        <h5>
            <font color="#3399CC">คลิกที่จำนวนผู้เข้าอบรมในแต่ละหลักสูตร เพื่อตรวจสอบรายชื่อ</font>
        </h5>
    

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
              <p></p>
                <form class="form-search" action="#">
                    <input class="inputtext search-input" type="text" id="search-query" placeholder="<?= $this->lang->translate('Search') ?>" name="q" autocomplete="off" value="<?= !empty($_GET["q"]) ? $_GET["q"] : "" ?>">
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
                        <th width="20%" style="vertical-align: middle;">หลักสูตร</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">รายละเอียด</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">วันที่เปิดลงทะเบียน</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">วันที่อบรม</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">จำนวนรับ<br>(คน)</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">จำนวนผู้<br>ลงทะเบียน</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">จำนวนผู้ยืนยัน<br>การลงทะเบียน</th>
                        <th width="9%" style="text-align: center;vertical-align: middle;">ค่าสมัครอบรม<br>(บาท)</th>
                        <th width="10%" style="text-align: center;vertical-align: middle;">ลงทะเบียน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->results['lists'])) {
                        foreach ($this->results['lists'] as $key => $value) {
                    ?>
                            <tr>
                                <td>
                                    <font color='red'><i class='fas fa-check-circle fa-1x'></i></font>
                                </td>
                                <td>
                                    <font size='3'><?= $value['course_name_th'] ?></font><br>
                                    <font size='2'><?= $value['course_name_en'] ?></font>
                                </td>
                                <td style="text-align: center;">
                                    <a href="#"><font color='red'><i class="far fa-file-pdf"></i></font></a>
                                </td>
                                <td style="text-align: center;">
                                    <?= $this->fn->q('time')->str_event_date($value['startdate_reg'], $value['enddate_reg'], true) ?>
                                </td>
                                <td style="text-align: center;">
                                    <?= $this->fn->q('time')->str_event_date($value['startdate'], $value['enddate'], true) ?>
                                </td>
                                <td style="text-align: center;">
                                    <?=$value['member']?>
                                </td>
                                <td style="text-align: center;">
                                    <a class="btn btn-info" href="<?= URL ?>course/<?= $value['id'] ?>"><?= $value['total_reg'] ?></a>
                                </td>
                                <td style="text-align: center;">
                                    <a class="btn btn-info" href="<?= URL ?>course/regconfirm/<?= $value['id'] ?>"><?= $value['total_confirm'] ?></a>
                                </td>
                                <td style="text-align: center;">
                                    <?php

                                    if ($value['price'] == 0.00) {
                                        echo "ฟรี";
                                    } else {
                                        $price = explode(".", $value['price']);
                                        echo $price[1] == 00 ? number_format($price[0]) . ".-" : number_format($value['price'], 2);
                                    }
                                    ?>
                                </td>
                                <?php
                                if (empty($this->me)) {
                                ?>
                                    <td style="text-align: center;">
                                        -
                                    </td>
                                    <?php
                                } elseif ($this->me['auth'] == "member") {
                                    if (!in_array($value['id'], $this->checkReg)) {
                                    ?>
                                        <td style="text-align: center;">
                                            <a href="<?= URL ?>course/register/<?= $value['id'] ?>" class="btn btn-primary" data-plugins="dialog">ลงทะเบียน</a>
                                        </td>
                                    <?php
                                    } else {
                                    ?>
                                        <td style="text-align: center;">
                                            <a class="btn btn-success disabled">ลงทะเบียนแล้ว</a>
                                        </td>
                                    <?php
                                    }
                                } elseif ($this->me['auth'] == "staff") {
                                    ?>
                                    <td style="text-align: center;">
                                        <a class="btn btn-danger disabled">ไม่มีสิทธิ์</a>
                                    </td>
                                <?php
                                }
                                ?>
                            </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td class="text-center" colspan="10"><h3 class="fcr fwb">ไม่มีหลักสูตรที่เปิดให้อบรมในขณะนี้</h3></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <div class="clearfix">
                <!-- shownum = แสดงหมายเลขหน้า
                   Short = จำกัดการแสดงผลหมายเลขหน้าเหลือ หน้า 2 หลัง 2
                   Warp = แสดงปุ่มกลับหน้าแรก / ไปหน้าสุดท้าย
              -->
                <?= $this->fn->Paginate($this->results['options'], ['shownum' => true, 'short' => false, 'warp' => false]) ?>
            </div>
        </div><!-- ปิดบอดี้พาแนล-->
    </div> <!-- ปิดพาแนล-->
</section>
<script type="text/javascript">
    $("[ref=selector]").change(function(){
        if( $(this).val() != "" ){
            window.location = Event.URL + 'course?price=' + $(this).val();
        }
        else{
            window.location = Event.URL + 'course';
        }
    });
</script>