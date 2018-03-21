<?php
header('Content-Type: application/json');

if (isset($_GET['action'])) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if (isset($_GET['postid'])) {
        $id = filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_NUMBER_INT);
        App::deletePost($id);
        return '{"Message" : "Suppression ok." }';
    } else {
        echo '{"Message" : "Aucun id reçu en paramètre."}';
    }
} else {
    echo '{"Message" : "Aucune action reçue en paramètre." }';
}

// Nécessaire lorsqu'on retourne du json
/*
if (isset ( $_POST ['idLesson'] )) {
    $id = $_POST ['idLesson'];
    // Je récupère l'id de guidance
    // $id = -1;
    // if (isset($_POST['guidanceId']))
    // $id = $_POST['guidanceId'];

    // if ($id > 0){
    $criterias = ECriteriaManager::getInstance ()->getCriteriasByLesson ( $id );
    if ($criterias === false) {
        echo '{ "ReturnCode": 2, "Message": "Un problème de récupération des données de getAllCriterias()"}';
        exit ();
    }
    $jsn = json_encode ( $criterias );
    if ($jsn == FALSE) {
        $code = json_last_error ();
        echo '{ "ReturnCode": 3, "Message": "Un problème d\'encodage json (' . $code . ')"}';
        exit ();
    }
    // Si j'arrive ici, ouf... c'est tout bon
    echo '{ "ReturnCode": 0, "Data": ' . utf8_encode ( $jsn ) . '}';
    exit ();
}

// }

// Si j'arrive ici, c'est pas bon
echo '{ "ReturnCode": 1, "Message": "Aucun paramètre reçu"}';
*/