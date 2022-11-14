<?php

include_once '../capa_entidad/contacts.php';
include_once '../capa_negocio/Contact.php';

// 200 OK
// 201 Created
// 202 Accepted
// 400 Bad Request
// 404 Not Found
// 405 Method Not Allowed
// 500 Internet Server Error

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Content-Type: multipart/form-data");
header("Allow: GET, POST, DELETE");



$method = $_SERVER['REQUEST_METHOD'];
$contactService = new ContactBussiness();

if($method=='POST') {

    if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email'])) {
      $contact = new Contact(null,$_POST['nombre'],$_POST['apellido'],$_POST['email']);
      $contactID = $contactService->insert($contact);
  
      header('HTTP/1.1 201');
      echo json_encode(array('message'=>'Contact created', 'contact_id'=>$contactID));
    }

    header('HTTP/1.1 400');
    
    die;

} elseif($method=='GET') {

    $contactsList = $contactService->list();

    header('HTTP/1.1 200');
    echo json_encode(array('message'=>'OK', 'data'=>$contactsList));
    die;

} elseif($method=='DELETE') {
  // var_dump($method);die;
    $data = explode("&", file_get_contents("php://input"));
    $id = json_decode($data[0])->id;
    
    if(isset($id) && is_integer($id)) {

        $status = $contactService->delete($id);
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