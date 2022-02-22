<?php
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$id_job = isset($_POST['id_professione']) ? $_POST['id_professione'] : null;
$id_nation = isset($_POST['id_nazione']) ? $_POST['id_nazione'] : null;

if (!$nome) {    
    $errors[] = 'User name is required';
}
if (!$cognome) {
    $errors[] = 'User lastname is required';
}
if (!$email) {
    $errors[] = 'User email is required';
}
if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = 'Please enter a valid email address';
}

// $isset =$_GET['id']??null;
if(!isset($_GET['id'])){
    $password = md5($_POST['password']);
    if (!$password) {
        $errors[] = 'Please enter a password';
    }
}