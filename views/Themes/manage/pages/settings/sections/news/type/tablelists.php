<?php

$tr = "";
$tr_total = "";
$url = URL.'news_type/';
if( !empty($this->results['lists']) ){ 
    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 

        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $txtUpdated = 'ไม่มีการปรับปรุงข้อมูล';
        if( !empty($item['updated']) ){
            $txtUpdated = $this->fn->q('time')->live( $item['updated'] );
        }

        $action = '';

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            '<td class="name">'.

                '<div class="anchor clearfix">'.
                    
                    '<div class="content"><div class="spacer"></div><div class="massages">'.

                        '<div class="fullname"><a class="fwb">'. $item['name'].'</a></div>'.

                        '<div class="fss fcg whitespace">ปรับปรุงล่าสุด : '.$txtUpdated.'</div>'.
                    '</div>'.
                '</div></div>'.

            '</td>'.
            '<td class="status_th">'.$item['total_news'].'</td>'.
            '<td class="actions">'.
                '<div class="group-btn whitespace mts">'.
                    '<a data-plugins="dialog" href="'.$url.'edit/'.$item['id'].'" class="btn btn-no-padding btn-orange"><i class="icon-pencil"></i></a>'.
                    '<a data-plugins="dialog" href="'.$url.'del/'.$item['id'].'" class="btn btn-no-padding btn-red"><i class="icon-trash"></i></a>'.
                '</div>'.
            '</td>'.
        '</tr>';
    }
}

$table = '<table class="settings-table"><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';