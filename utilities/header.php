<header>
    <div class="container">
        <div class="header-title">
            <h1>Registered Users</h1>
        </div>
        <div class="add-user btn">
            <a href="./create.php" type="button">Add user</a>
        </div>
        <div class="searchbar">
            
            <?php 
                $formSearch = new Form("get",'');
                $inps=[
                    [
                        "type"=>"search",
                        "name"=>"search",
                        "placeholder"=>"Search by full name"
                    ],
                    [
                        "type"=>"submit",
                        "value"=>"Search"
                    ]
                ];
                foreach($inps as $inp){
                    $formSearch->createInput($inp);
                }
                echo $formSearch->makeForm();
                ?>
            <!-- <form action="" method="get">
                <input type="text" name="search" class="form-control" placeholder="Search by name" value="< ?= $keyword ?>">
                <button type="submit">Search</button> -->
            </form>
        </div>
    </div>
</header>