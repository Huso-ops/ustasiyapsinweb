<?php 
include '../functions.php';
$x = $_POST['x'];
if(isset($x)){
    echo "don't try";
}

$data = json_encode($_POST);
switch($x){
    case "register": 
        $s =  curlJson('ustasiyapsin-api.herokuapp.com/api/auth/register', json_decode($data), 'POST');
        print_r($s);
        if($s['message'] == "Register Successfully"){
            header('Location: ' . $_SERVER['HTTP_REFERER']. '?d=ok');
        }else{
                header('Location: ' . $_SERVER['HTTP_REFERER']. '?d=hata&m='.$s['message']);
            }
        break;
    case "login": 
        $giris =  curlJson('ustasiyapsin-api.herokuapp.com/api/auth/login', json_decode($data), 'POST');
        if($giris = "Wrong Mail Or Gsm" || $giris = "Wrong Password"){
            header('Location: ' . $_SERVER['HTTP_REFERER']. '?&=hata&m='.$giris);
        }
        else if($giris['success'] == true){
            $_SESSION['id'] = $giris['data']['_id'];
            $_SESSION['accessToken'] = $giris['data']['accessToken'];
            $_SESSION['name'] = $giris['data']['name'];
            header('Location: ' . $_SERVER['HTTP_REFERER']. '?d=ok');

        }else{
            header('Location: ' . $_SERVER['HTTP_REFERER']. '?&=hata&m='.$giris);
        }
        break;
}
?>