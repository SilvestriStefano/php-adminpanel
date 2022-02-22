<?php


//if the url does not have an id go back
$id = $_GET['id'] ?? false;
if (!$id) {
    header('location: ./index.php');
    die();
}


require_once './utilities/classes/Crud.php';
use framework\Crud;


$crud = new Crud();


$sql_elem = 'anagrafica.id,anagrafica.nome, anagrafica.cognome, anagrafica.email, 
anagrafica.password, anagrafica.id_professione, anagrafica.id_nazione, 
nazione.name as nation, professione.nome as job ';
$sql_table = 'anagrafica LEFT JOIN professione ON anagrafica.id_professione = professione.id
LEFT JOIN nazione ON anagrafica.id_nazione = nazione.id';
$user = $crud->read_elems_by($sql_elem,$sql_table,'anagrafica.id',$id);

//set the parameter values
$nome = $user[0]['nome'];
$cognome = $user[0]['cognome'];
$email = $user[0]['email'];
$password = $user[0]['password'];
$job = $user[0]['job'];
$id_job = $user[0]['id_professione'];
$nation = $user[0]['nation'];
$id_nation = $user[0]['id_nazione'];


if (!empty($_POST)) { //if the POST is not empty

    require_once './utilities/classes/Validation.php';
    $val = new Validation();
    
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
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
         'msg'=>"Please enter an email!"]
        ];

    $val->required($req_fields);
    $val->is_email($email);

    if ($val->success()) { //if there are no errors

        $crud = new Crud('project_db');
        $headers = [
            "nome"=>$nome,
            "cognome"=>$cognome,
            "email"=>$email,
            "password"=>$password,
            "id_professione"=>$id_job,
            "id_nazione"=>$id_nation
        ];
        $updated = $crud->update('anagrafica',$headers,$id);


        if ($updated) {
            header('location: ./update.php?id='.$id);
            die();
        } else {
            
        }
    }
    else{
        $errors = $val->get_errors();
    }
}

?>

<!--start the page-->
<?php include_once './utilities/head.php';
?>

<main class="forms">
    <div class="container">
        <div class="goback btn">
            <a class="go-back" href="./index.php">Back to users</a>
        </div>
        <div class="container-form">
            <div class="form-title">
                <h1>
                    <?php if (!empty($_POST) && empty($errors)) {
                        echo $_POST['nome']." ".$_POST['cognome'];
                    } else {
                        echo $user[0]['nome']." ".$user[0]['cognome'];
                    } ?>
                </h1>
            </div>
            <!--include the form if requested otherwise show the info-->
            <!-- forse sarebbe meglio farlo con javascript...  -->
            <?php 
                $update = $_GET['update'] ?? null;
                if ($update) { 
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
                ?>
                    <a class="go-back btn" href="?id=<?= $user[0]['id'] ?>">Go back</a>
            <?php } else {?>
                    <div class="userInfo">
                        <div class="email"><?= $email  ?></div>
                        <div class="nation"><?= $nation ?></div>
                        <div class="job"><?= $job ?></div>
                    </div>
                    <div class="edit btn">
                        <a href="?id=<?= $user[0]['id'] ?>&update=true">Modifica</a>
                    </div>
            <?php }; ?>
        </div>
    </div>
</main>
<?php include_once './utilities/footer.php'; ?>