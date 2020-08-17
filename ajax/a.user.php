<?php 

include_once(__DIR__.'/../classes/c.user.php');

session_start();

if(!empty($_GET)){
    $userData = User::getUserById($_GET['id']);

    $response = [
        'status'    => 'succes',
        'body'      => $userData,
    ];

    header('Content-Type: application/json');
    echo json_encode($response); //{'status' : 'succes'};

}else{
    
    header('Content-Type: application/json');
    echo json_encode("{'status' : 'failed'}"); //{'status' : 'failed'};
}

?>
