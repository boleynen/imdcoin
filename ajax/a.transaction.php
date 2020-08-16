<?php 

include_once(__DIR__.'/../classes/c.transaction.php');

session_start();

if(!empty($_GET)){
    $transactions = Transaction::getTransactionById($_GET['id']);

    $response = [
        'status'    => 'succes',
        'body'      => $transactions,
    ];

    header('Content-Type: application/json');
    echo json_encode($response); //{'status' : 'succes'};

}else{
    
    header('Content-Type: application/json');
    echo json_encode("{'status' : 'failed'}"); //{'status' : 'failed'};
}

?>