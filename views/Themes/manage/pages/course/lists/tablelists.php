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

        $updatedStr = "-";
        if( !empty($item['updated']) ) $updatedStr = $this->fn->q('time')->stamp( $item['updated'] );

        $option = '';
        foreach ($this->status as $key => $value) {
            $sel = $item["status"] == $value["id"] ? 'selected="1"' : '';
            $option .= '<option '.$sel.' value="'.$value["id"].'">'.$value["name"].'</option>';
        }

        $status = '<select class="inputtext" data-plugins="_update" data-options="'.$this->fn->stringify(array('url' => URL. 'course/setData/'.$item['id'].'/course_status', 'message'=>'เปลี่ยนสถานะเรียบร้อยแล้ว')).'">'.$option.'</select>';

        $btnOpenTxt = "ปิดหลักสูตร";
        $btnOpenClr = "btn-red";
        // $btnOpenUrl = URL."course/opencourse/{$item['id']}"; (dialog)
        if( !empty($item['open_status']) ){
            $btnOpenTxt = "เปิดหลักสูตร";
            $btnOpenClr = "btn-green";
        }

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            '<td class="image">
                <div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-book"></i></div></div>
            </td>'.

            '<td class="status_th">
                Tech'.$item['code'].'
            </td>'.

            '<td class="name">'.
                
                 '<div class="anchor clearfix">'.
                    
                    '<div class="content"><div class="spacer"></div><div class="massages">'.

                        '<div class="fullname"><a class="fwb" data-plugins="dialog" href="'.URL.'course/edit/'.$item['id'].'">'.$item['name_th'].'</a></div>'.

                        '<div class="subname fsm fcg meta">ภาษาอังกฤษ : '.$item['name_en'].'</div>'.
                        '<div class="subname fsm fcg meta">ปรับปรุงล่าสุด : '.$updatedStr.'</div>'.

                    '</div>'.
                '</div></div>'.

            '</td>'.

            '<td class="number">
                '.$item['hours'].' ชั่วโมง
            </td>'.

            '<td class="status_th">
                <a class="btn btn-blue" href="'.URL.'manage/course/history/'.$item['id'].'">แสดงประวัติ</a>
            </td>'.

            /*
            '<td class="status_th">
                <a class="btn btn-blue" data-plugins="dialog" href="'.URL.'course/openhistory/'.$item['id'].'">แสดงประวัติ</a>
            </td>'.
            */

            '<td class="status_th">
                <a class="btn '.$btnOpenClr.'">'.$btnOpenTxt.'</a>
            </td>'.

            '<td class="status_th">
                '.$status.'
            </td>'.

            '<td class="actions whitespace">'.
                '<span class="gbtn">
                    <a data-plugins="dialog" href="'.URL.'course/edit/'.$item['id'].'" class="btn btn-no-padding btn-orange"><i class="icon-pencil"></i></a>
                </span>'.
                '<span class="gbtn">
                    <a data-plugins="dialog" href="'.URL.'course/del/'.$item['id'].'" class="btn btn-no-padding btn-red"><i class="icon-trash"></i></a>
                </span>'.
            '</td>'.

        '</tr>';
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';