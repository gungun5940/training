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

        $image = !empty($item['image_url']) ? $this->fn->imageBox($item['image_url'], 100): '';

        $createdStr = $this->fn->q('time')->live( $item['created'] );
        $updatedStr = "ไม่มีการปรับปรุงข้อมูล";
        if( !empty($item['updated']) ) $updatedStr = $this->fn->q('time')->stamp( $item['updated'] );

        $option = '';
        foreach ($this->status as $key => $value) {
            $sel = $item["status"] == $value["id"] ? 'selected="1"' : '';
            $option .= '<option '.$sel.' value="'.$value["id"].'">'.$value["name"].'</option>';
        }

        $status = '<select class="inputtext" data-plugins="_update" data-options="'.$this->fn->stringify(array('url' => URL. 'news/setData/'.$item['id'].'/new_status', 'message'=>'เปลี่ยนสถานะเรียบร้อยแล้ว')).'">'.$option.'</select>';

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            '<td class="image">
                '.$image.'
            </td>'.

            '<td class="name">'.
                
                 '<div class="anchor clearfix">'.
                    
                    '<div class="content"><div class="spacer"></div><div class="massages">'.

                        '<div class="fullname"><a class="fwb" href="'.URL.'manage/news/edit/'.$item['id'].'">'.$item['title'].'</a></div>'.
                        '<div class="subname fsm fcg meta">ประเภท/หมวดหมู่ : '.$item['type_name'].'</div>'.
                        '<div class="subname fsm fcg meta">เขียนเมื่อ : '.$createdStr.'</div>'.
                        '<div class="subname fsm fcg meta">ปรับปรุงเมื่อ : '.$updatedStr.'</div>'.

                    '</div>'.
                '</div></div>'.

            '</td>'.

            '<td class="status_th">
                '.$item['viewer'].'
            </td>'.

            '<td class="status_th">
                '.$status.'
            </td>'.

            '<td class="actions whitespace">'.
                '<span class="gbtn">
                    <a href="'.URL.'manage/news/edit/'.$item['id'].'" class="btn btn-no-padding btn-orange"><i class="icon-pencil"></i></a>
                </span>'.
                '<span class="gbtn">
                    <a data-plugins="dialog" href="'.URL.'news/del/'.$item['id'].'" class="btn btn-no-padding btn-red"><i class="icon-trash"></i></a>
                </span>'.
            '</td>'.

        '</tr>';
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';