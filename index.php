<?php
include_once './utilities/classes/Crud.php';
use framework\Crud;

//check whether there was a request of deletion
if(isset($_GET['deleted'])){
    $crud = new Crud();
    $crud->delete('anagrafica',$_POST['id']);
}




$limitUsersOnPage = 3; 
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$crud = new Crud();
$tot_pg = $crud->pagination('anagrafica', $limitUsersOnPage);



//get the users based on the search
$keyword = $_GET['search'] ?? null;

$sql_elem = 'anagrafica.id,anagrafica.nome,anagrafica.cognome';
$sql_table = 'anagrafica ';
$order = ['key'=>'id', 'dir'=>'DESC'];
            
    
if ($keyword) {//if we are looking for something
    $arr_key = ['anagrafica.nome','anagrafica.cognome']; //where do we want to look
    
    $users = $crud->search($sql_elem, $sql_table, $keyword, $arr_key, 'OR', $order);

} else { //otherwise
    
    $inizio = ($page - 1) * $limitUsersOnPage;
    $sql_order = "ORDER BY ".$order['key']." ".$order['dir'];
    
    $sql_table_limited = $sql_table.$sql_order." LIMIT $limitUsersOnPage OFFSET $inizio";
    
    $users = $crud->read_elems($sql_elem,$sql_table_limited);
}


//start the HTML page
include_once './utilities/head.php';
include_once './utilities/classes/Form.php';

?>



<main class="home">
    <?php require_once './utilities/header.php'; ?>
    <div class="container">
        <div class="container-cards">
            <?php
            
            foreach ($users as $i => $user) { ?>
            <div class="accordion-item card">
                <div class="card-title">
                    <div class="card-icon">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                    </div>
                    <div class="card-user"><?= $user['nome'] . " " . $user['cognome'] ?></div>
                </div>
                <div class="content hidden">
                    <div class="card-footer">
                        <div class="edit btn">
                            <a href="./update.php?id=<?= $user['id'] ?>">Mostra/Modifica</a>
                        </div>
                        <div class="delete">
                            <?php
                                $formDelete = new Form('post',"?deleted=yes");
                                $inpsDelete = [
                                    ["type"=>"hidden","name"=>'id',"value"=>$user['id']],
                                    ["type"=>'submit',"value"=>"Elimina"]
                                ];
                                foreach($inpsDelete as $inp){
                                    $formDelete->createInput($inp);
                                };
                                echo $formDelete->makeForm();
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>


    <?php //show page numbers if search is empty or no search query has been made
        if(!$keyword): ?>
    <div class="pages">
        <?php
        for($pg = 1; $pg<=$tot_pg; $pg++){
            if($pg == $page){?>
                <a href="?page=<?=$pg?>" class="current"><?=$pg?></a>
        <?php } else { ?>
                <a href="?page=<?=$pg?>"><?=$pg?></a>
        <?php }
        //add fwd and bck btns and go-to-pg
        }?>
    </div>
    <?php endif ?>
</main>

<script src="./js/script.js"></script>
<?php include_once './utilities/footer.php'; ?>