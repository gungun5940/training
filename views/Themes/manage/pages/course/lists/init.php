<?php

$title[] = array('key'=>'image', 'text'=>'');
$title[] = array('key'=>'status_th', 'text'=>'รหัสหลักสูตร');
$title[] = array('key'=>'name', 'text'=>'ชื่อหลักสูตร', 'sort'=>'name_th');
$title[] = array('key'=>'number', 'text'=>'จำนวนชั่วโมง', 'sort'=>'hours');
$title[] = array('key'=>'status_th', 'text'=>'ดูประวัติการเปิด/ปิด');
$title[] = array('key'=>'status_th', 'text'=>'สถานะเปิด/ปิดหลักสูตร');
$title[] = array('key'=>'status_th', 'text'=>'สถานะหลักสูตร');
$title[] = array('key'=>'actions', 'text'=>'จัดการ');

$this->tabletitle = $title;
$this->getURL =  URL.'manage/course/';