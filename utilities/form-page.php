<?php
require_once './utilities/classes/Form.php';

require_once './utilities/classes/Crud.php';
use framework\Crud;

if(!isset($_GET['id'])){
    $form = new Form('post','?created=true');
} else{
    $form = new Form('post');
}
$inps=[
    [
        "type"=>"text",
        "name"=>"nome",
        "value"=>$nome,
        // "required"=>true,
        "placeholder"=>"Nome"
    ],
    [
        "type"=>"text",
        "name"=>"cognome",
        "value"=>$cognome,
        // "required"=>true,
        "placeholder"=>"Cognome"
    ],
    [
        "type"=>"email",
        "name"=>"email",
        "value"=>$email,
        // "required"=>true,
        "placeholder"=>"Inserisci la tua email"
    ]
];
foreach($inps as $inp){
    $form->createInput($inp);
}
if(!isset($_GET['id'])){
    $pwd = [
        "type"=>"password",
        "name"=>"password",
        "value"=>$password,
        // "required"=>true,
        "placeholder"=>"Immetti una password"
    ];
    $conf_pwd = [
        "type"=>"password",
        "name"=>"confirm_password",
        "value"=>$password,
        // "required"=>true,
        "placeholder"=>"Ripeti la password"
    ];
    $form->createInput($pwd);
    $form->createInput($conf_pwd);
}

/*+++++++++++++++++++++++++++++
    input radio for job
+++++++++++++++++++++++++++++++*/
$crud = new Crud();
$jobs=$crud->read_all('professione');
$radios_job=[
    "type"=>"radio",
    "name"=>"id_professione",
    "title"=>"Seleziona una professione",
    'choices'=>[],
    'div_class'=>'radioBtns'
];
foreach ($jobs as $ind => $job) {
    /*controlla se l'utente ha una professione*/
    if ($id_job == $job['id']) {
        $radios_job['choices'][] = ['id'=>"job".($ind+1),"input_class"=>"radio","value"=>$job['id'],'checked'=>true,"label"=> $job['nome']];
    } else {                     
        $radios_job['choices'][] = ['id'=>"job".($ind+1),"input_class"=>"radio","value"=>$job['id'],"label"=> $job['nome']];
    }
}
$form->createInput($radios_job);

/*+++++++++++++++++++++++++++++
    input radio for nation
+++++++++++++++++++++++++++++++*/
$crud = new Crud();
$nations=$crud->read_all('nazione');
$radios_nation=[
    "type"=>"radio",
    "name"=>"id_nazione",
    "title"=>"Seleziona una nazione",
    'choices'=>[],
    'div_class'=>'radioBtns'
];
foreach ($nations as $ind => $nat) {
    /*controlla se l'utente ha una professione*/
    if ($id_nation == $nat['id']) {
        $radios_nation['choices'][] = ['id'=>"nation".($ind+1),"input_class"=>"radio","value"=>$nat['id'],'checked'=>true,"label"=> $nat['name']];
    } else {                     
        $radios_nation['choices'][] = ['id'=>"nation".($ind+1),"input_class"=>"radio","value"=>$nat['id'],"label"=> $nat['name']];
    }
}
$form->createInput($radios_nation);

$form->createInput(["type"=>"submit","value"=>"Submit", "input_class"=>"submit"]);
echo $form->makeForm();
?>