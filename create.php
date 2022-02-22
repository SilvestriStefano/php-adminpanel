<?php

$nome = '';
$cognome = '';
$email = '';
$password = '';
$id_job = '';
$id_nation = '';

require_once './utilities/classes/Crud.php';
use framework\Crud;

$errors;

if (!empty($_POST)) {

    require_once './utilities/classes/Validation.php';
    $val = new Validation();

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id_job = isset($_POST['id_professione']) ? $_POST['id_professione'] : null;
    $id_nation = isset($_POST['id_nazione']) ? $_POST['id_nazione'] : null;

    $req_fields = [
        ['name'=>'nome',
         'value'=>$nome,
         'msg'=>"Please enter your name!"],
         ['name'=>'cognome',
         'value'=>$cognome,
         'msg'=>"Please enter your last name!"],
         ['name'=>'email',
         'value'=>$email,
         'msg'=>"Please enter an email!"],
         ['name'=>'password',
         'value'=>$password,
         'msg'=>"Missing password!"],
         ['name'=>'confirm_password',
         'value'=>$_POST['confirm_password'],
         'match'=>'password',
         'source_value'=>$password,
         'msg'=> 'It must match the password']
    ];
    $val->required($req_fields);
    $val->is_email($email);

    if ($val->success()) {
        $crud = new Crud();

        $headers = [
            "nome"=>$nome,
            "cognome"=>$cognome,
            "email"=>$email,
            "password"=>$password,
            "id_professione"=>$id_job,
            "id_nazione"=>$id_nation
        ];

        $created = $crud->create('anagrafica',$headers);
    }
    else{
        $errors = $val->get_errors();
    }

}

include_once './utilities/head.php'; ?>

<main class="forms">
    <div class="container">
        <div class="goback btn">
            <a class="go-back" href="./index.php">Back to users</a>
        </div>
        <div class="container-form">
        <?php if( isset($_GET['created']) && empty($errors) ){?>
            <div class='created btn'>
                Utente registrato!
            </div>
            <a class="go-back btn" href="?">Create a new one</a>
            <?php
                } else {      
            ?>
            <div class="form-title">
                <h1>Create new User</h1>
            </div>

            <?php 
            include_once './utilities/form-page.php';
            if( !empty($errors) ) {?>
                <script>
                    let errArr = <?= json_encode($errors)?>;
                    for(let key in errArr) {
                        let inp = document.querySelector(`input[name=${key}]`);
                        inp.classList.add('err');
                        inp.parentElement.classList.add('err');
                        inp.parentElement.setAttribute('data-error',`${errArr[key]}`);
                    };
                    </script>
                    <?php
                }     
            }
            ?>

        </div>
    </div>
</main>
<?php include_once './utilities/footer.php'; ?>


