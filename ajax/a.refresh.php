<?php 

include_once(__DIR__.'/../classes/c.user.php');
include_once(__DIR__.'/../classes/c.transaction.php');

session_start();

if(!empty($_GET)){
    $curr = User::getMyCurrency($_GET['id']);

    $response = [
        'status'    => 'succes',
        'body'      => $curr,
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response); //{'status' : 'succes'};
    
}else{
    
    header('Content-Type: application/json');
    echo json_encode("{'status' : 'failed'}"); //{'status' : 'failed'};
}

?>