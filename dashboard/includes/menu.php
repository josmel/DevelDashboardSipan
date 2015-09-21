<?php

include_once 'psl-config.php';

function create_list() {
    $link = mysql_connect(HOST, USER, PASSWORD);
    mysql_select_db(DATABASE, $link);
    $refs = array();
    $list = array();
    $sql = "SELECT menu_item_id, menu_parent_id,menu_url, menu_item_name FROM menu_items ORDER BY menu_item_name";
    $result = mysql_query($sql);
    while ($data = @mysql_fetch_assoc($result)) {
        $thisref = &$refs[$data['menu_item_id']];
        $thisref['menu_parent_id'] = $data['menu_parent_id'];
        $thisref['menu_item_name'] = $data['menu_item_name'];
        $thisref['menu_url'] = $data['menu_url'];
        $thisref['menu_item_id'] = $data['menu_item_id'];
        if ($data['menu_parent_id'] == 0) {
            $list[$data['menu_item_id']] = &$thisref;
        } else {
            $refs[$data['menu_parent_id']]['children'][$data['menu_item_id']] = &$thisref;
        }
    }

    $idUser = $_SESSION['user_id'];
    $sqlTwo = "SELECT idMenu FROM menuUser where idUser=$idUser";
    $resulta = mysql_query($sqlTwo);
    while ($datasa = @mysql_fetch_assoc($resulta)) {
        $lista[] = $datasa['idMenu'];
    }

    foreach ($list as $key => $v) {
        if (in_array($v['menu_item_id'], $lista)) {
            $ke[] = array('url' => $v['menu_url'], 'descripcion' => utf8_encode($v['menu_item_name']),
                'hijos' => hijos($v['children']));
        }
    }

    return $ke;
}

function hijos($list) {
    foreach ($list as $key => $ca) {
        $valo[] = array('url' => $ca['menu_url'], 'descripcion' => utf8_encode($ca['menu_item_name']))
        ;
    }
    return $valo;
}

function menuPadre() {
    $link = mysql_connect(HOST, USER, PASSWORD);
    mysql_select_db(DATABASE, $link);
    $refs = array();
    $list = array();
    $sql = "SELECT menu_item_id, menu_parent_id,menu_url, menu_item_name FROM menu_items ORDER BY menu_item_name";
    $result = mysql_query($sql);
    while ($data = @mysql_fetch_assoc($result)) {
        $thisref = &$refs[$data['menu_item_id']];
        $thisref['menu_parent_id'] = $data['menu_parent_id'];
        $thisref['menu_item_name'] = $data['menu_item_name'];
        $thisref['menu_item_id'] = $data['menu_item_id'];
        $thisref['menu_url'] = $data['menu_url'];
        if ($data['menu_parent_id'] == 0) {
            $list[$data['menu_item_id']] = &$thisref;
        } else {
            $refs[$data['menu_parent_id']]['children'][$data['menu_item_id']] = &$thisref;
        }
    }

    foreach ($list as $key => $v) {

        $ke[] = array('id' => $v['menu_item_id'], 'descripcion' => utf8_encode($v['menu_item_name']));
    }
    return $ke;
}
