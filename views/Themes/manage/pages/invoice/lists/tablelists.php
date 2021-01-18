<?php
//print_r($this->results['lists']); die;
$tr = "";
$tr_total = "";

if( !empty($this->results['lists']) ){ 
    //print_r($this->results); die;

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 
        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";

        $createdStr = $this->fn->q('time')->live( $item['created'] );
        $updatedStr = "";
        if( !empty($item['updated']) ) $updatedStr = $this->fn->q('time')->stamp( $item['updated'] );

        $option = '';
        foreach ($this->status as $key => $value) {
            $sel = $item["status"] == $value["id"] ? 'selected="1"' : '';
            $option .= '<option '.$sel.' value="'.$value["id"].'">'.$value["name"].'</option>';
        }

        $status = '<select class="inputtext" data-plugins="_update" data-options="'.$this->fn->stringify(array('url' => URL. 'invoice/setData/'.$item['id'].'/inv_status', 'message'=>'เปลี่ยนสถานะเรียบร้อยแล้ว')).'">'.$option.'</select>';

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            '<td class="image">
                <div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-money"></i></div></div>
            </td>'.

            '<td class="name">'.
                
                 '<div class="anchor clearfix">'.
                    
                    '<div class="content"><div class="spacer"></div><div class="massages">'.

                        '<div class="fullname"><a class="fwb" href="#">'.$item['name'].'</a></div>'.

                        '<div class="subname fsm fcg meta">รหัสประจำตัว : '.$item['code'].'</div>'.
                        '<div class="subname fsm fcg meta">ร้องขอเมื่อ : '.$createdStr.'</div>'.

                    '</div>'.
                '</div></div>'.

            '</td>'.

            '<td class="address">
                '.$item['add_num'].' <span class="fwb">ถ.</span>'.$item['add_street'].'<br>
                <span class="fwb">ต.</span>'.$item['district']['name'].' <span class="fwb">อ.</span>'.$item['amphure']['name'].'<br>
                <span class="fwb">จ.</span>'.$item['province']['name'].' '.$item['add_zipcode'].'
            </td>'.

            '<td class="status_th">
                '.$status.'
            </td>'.

            // '<td class="actions whitespace">'.
            //     '<span class="gbtn">
            //         <a href="'.URL.'manage/invoice/edit/'.$item['id'].'" class="btn btn-no-padding btn-orange"><i class="icon-pencil"></i></a>
            //     </span>'.
            //     '<span class="gbtn">
            //         <a data-plugins="dialog" href="'.URL.'members/del/'.$item['id'].'" class="btn btn-no-padding btn-red"><i class="icon-trash"></i></a>
            //     </span>'.
            // '</td>'.

        '</tr>';
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';