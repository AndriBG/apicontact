<?php

include_once 'capa_entidad/contacts.php';
include_once 'capa_negocio/contact.php';

// 200 OK
// 201 Created
// 202 Accepted
// 400 Bad Request
// 404 Not Found
// 405 Method Not Allowed
// 500 Internet Server Error

$method = $_SERVER['REQUEST_METHOD'];

$contactService = new ContactBussiness();

if($method=='POST') {
    
    $contact = new Contact(null,$_POST['nombre'],$_POST['apellido'],$_POST['email']);
    $contactID = $contactService->insert($contact);

    header('HTTP/1.1 201');
    echo json_encode(array('message'=>'Contact created', 'contact_id'=>$contactID));
    die;

} elseif($method=='GET') {

    $contactsList = $contactService->list();

    header('HTTP/1.1 200');
    echo json_encode(array('message'=>'OK', 'data'=>$contactsList));
    die;

} elseif($method=='DELETE') {
    
    if(isset($_GET['id'])) {

        $status = $contactService->delete($_GET['id']);
        header('HTTP/1.1 200');
        if($status) echo json_encode(array('status'=>true,'message'=>'success'));
        else echo json_encode(array('status'=>false,'message'=>'failed'));
    } else {
        header('HTTP/1.1 400 Bad Request');
    }

    die;
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    die;
}

?>