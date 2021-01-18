<section class="container main-container" style="padding-top:20px;">
    <div style="padding-left:20px;">
        <h4>รายชื่อผู้เข้าอบรมในหลักสูตร</h4>
        <h5>
            ชื่อภาษาไทย : <font color="#3399CC"><?=$this->course['name_th']?></font><br/>
            ชื่อภาษาอังกฤษ : <font color="#3399CC"><?=$this->course['name_en']?></font>
        </h5>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover">
                <thead>
                    <tr>
                        <!-- <th width="5%">ที่</th>
                        <th width="10%">คำนำหน้า</th>
                        <th width="30%">ชื่อ</th>
                        <th width="30%">นามสกุล</th>
                        <th width="25%">วันที่สมัคร</th> -->
                        <th width="5%" class="text-center">ที่</th>
                        <th width="75%">ชื่อ - สกุล</th>
                        <th width="20%" class="text-center">วันที่สมัคร</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if( !empty($this->results) ){
                        $no = 1;
                        foreach ($this->results as $key => $value) {
                            ?>
                            <tr>
                                <td class="text-center"><?=$no?></td>
                                <td><?=$value["mem_fullname"]?></td>
                                <td class="text-center"><?=$this->fn->q('time')->dateTH( $value['date'] )?></td>
                            </tr>
                            <?php
                            $no++;
                        }
                    }
                    else{
                        ?>
                        <tr><td colspan="3"><h5 class="text-center fcr">ไม่มีข้อมูลผู้สมัคร</h5></td></tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div><!-- ปิดบอดี้พาแนล-->
    </div> <!-- ปิดพาแนล-->
</section>