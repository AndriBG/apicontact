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
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Content-Type: multipart/form-data");
header("Allow: GET, POST, DELETE, PUT");



$method = $_SERVER['REQUEST_METHOD'];
$contactService = new ContactBussiness();
$contactsList = $contactService->list();
// var_dump($method,$_POST);die;
if($method=='POST') {

    if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email'])) {
      $contact = new Contact(null,$_POST['nombre'],$_POST['apellido'],$_POST['email']);
      $contactID = $contactService->insert($contact);
      $contact->id = $contactID;
  
      header('HTTP/1.1 201');
      echo json_encode(array('message'=>'Contact created', 'contact'=>$contact));
    //   echo json_encode(array('message'=>'Contact created', 'contact_id'=>$contactID, 'contacts'=>$contactsList));
      die;
    }

    header('HTTP/1.1 400');
    die;

} elseif($method=='GET')
{
    if($contactsList) 
    {
        header('HTTP/1.1 200');
        echo json_encode(array('status'=>true, 'data'=>$contactsList));
        die;
    } else
    {
        header('HTTP/1.1 400');
        echo json_encode(array('status'=>false, 'data'=>null));
        die;
    }

} elseif($method=='DELETE')
{
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
} elseif($method=='PUT') 
{
    $data = explode("&", file_get_contents("php://input"));
    var_dump($data);die;
    $id = json_decode($data[0])->id;
    
    if(isset($id) && is_integer($id)) {

        $status = $contactService->update($id);
        header('HTTP/1.1 200');
        if($status) echo json_encode(array('status'=>true,'message'=>'success'));
        else echo json_encode(array('status'=>false,'message'=>'failed'));
    } else {
        header('HTTP/1.1 400 Bad Request');
    }

    die;
} else 
{
    header('HTTP/1.1 405 Method Not Allowed');
    die;
}

?>