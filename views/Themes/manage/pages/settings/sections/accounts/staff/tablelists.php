<?php

$tr = "";
$tr_total = "";
$url = URL.'staff/';
if( !empty($this->results['lists']) ){ 
    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 

        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $status = '';
        $color = '';
        if( $item['status'] == "1" ) $color = 'green';
        if( $item['status'] == "2" ) $color = 'red';
        $status = '<a class="btn btn-'.$color.'">'.$item['status_name'].'</a>';

        $subtext = 'Username : '.$item['username'];
        $express = '';

        $disabled = '';
        if( $item['id'] == $this->me['id'] ){
            $disabled = ' disabled';
        }

        if( $item['owner'] == 1 ){
            $disabled = ' disabled';
        }

        $txtUpdated = 'ไม่มีการปรับปรุงข้อมูล';
        if( !empty($item['updated']) ){
            $txtUpdated = $this->fn->q('time')->live( $item['updated'] );
        }

        $action = '';

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            '<td class="type">'.$item['refno'].'</td>'.

            '<td class="name">'.

                '<div class="anchor clearfix">'.
                    
                    '<div class="content"><div class="spacer"></div><div class="massages">'.

                        '<div class="fullname"><a class="fwb">'. $item['fullname'].'</a></div>'.

                        '<div class="subname fsm fcg meta">'.$subtext.'</div>'.

                        '<div class="fss fcg whitespace">ปรับปรุงล่าสุด : '.$txtUpdated.'</div>'.
                    '</div>'.
                '</div></div>'.

            '</td>'.

            '<td class="status_th">'.$item['role_name'].(!empty($item['owner']) ? '<div class="fss fcg whitespace">(ROOT)</div>' : '').'</td>'.
            '<td class="status_th">'.$status.'</td>'.
            '<td class="actions">'.
                '<div class="group-btn whitespace mts">'.
                    '<a data-plugins="dialog" href="'.$url.'password/'.$item['id'].'" class="btn btn-no-padding btn-blue'.$disabled.'"><i class="icon-key"></i></a>'.
                    '<a data-plugins="dialog" href="'.$url.'edit/'.$item['id'].'" class="btn btn-no-padding btn-orange'.$disabled.'"><i class="icon-pencil"></i></a>'.
                    '<a data-plugins="dialog" href="'.$url.'del/'.$item['id'].'" class="btn btn-no-padding btn-red'.$disabled.'"><i class="icon-trash"></i></a>'.
                '</div>'.
            '</td>'.
        '</tr>';
    }
}

$table = '<table class="settings-table"><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';