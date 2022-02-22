<?php 
namespace framework;

use PDO;
use PDOException;



Class Crud{
    private $db= '';

    public function __construct(){
        $this->db = $this->connect();
    }

    private function connect(){
        try{
            $hostname = 'ec2-54-194-147-61.eu-west-1.compute.amazonaws.com';
            $dbname = "de2t8rh32ih0oa";
            $user = 'lfgyjihaddnknf';
            $pass = '050d35c4a16b985b0e7e01673f6e42463365d083ea5db3a10c0def77da25bf7e';
            $dsn = "pgsql:host=$hostname;port=5432;dbname=$dbname";
            return new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        }catch(PDOException $e){
            var_dump($e->getMessage());
            die();
        }
    }
    
    /*================================
                C R E A T E
    ==================================*/
    public function create($table_name,$arr_headers){
        $sql = "INSERT INTO $table_name (";
        $ind=0;
        $headers_length = count($arr_headers)-1;
        foreach($arr_headers as $header=>$val){
            if($ind==$headers_length){
                $sql.="$header)";
            } else{
                $sql.="$header,";
            }
            $ind++;
        };
        $sql.=" VALUES (";
        
        $ind=0;
        foreach($arr_headers as $header=>$val){
            if($ind==$headers_length){
                $sql.=":$header)";
            } else{
                $sql.=":$header,";
            }
            $ind++;
        };

        $query = $this->db->prepare($sql);
        
        foreach($arr_headers as $header=>$val){
            $query->bindValue(":$header", $val);
        };
        

        if($query->execute()){
            return true;
        }else{
            var_dump($query->errorInfo());
            die();
        }

    }
    
    /*================================
                R E A D 
    ==================================*/
    public function read_all($table_name){
        $sql = "SELECT * FROM $table_name";

        $query = $this->db->prepare($sql);
        if($query->execute()){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            var_dump($query->errorInfo());
            die();
        }

    }


    public function read_all_by_id($table_name,$id){
        $sql = "SELECT * FROM $table_name WHERE id = $id";

        $query = $this->db->prepare($sql);
        if($query->execute()){
            return $query->fetch(PDO::FETCH_ASSOC);
        }else{
            var_dump($query->errorInfo());
            die();
        }
    }


    public function read_all_by($table_name,$key,$val){
        $sql = "SELECT * FROM $table_name WHERE $key = $val";

        $query = $this->db->prepare($sql);
        if($query->execute()){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            var_dump($query->errorInfo());
            die();
        }

    }

    public function read_elems($elems,$table_name){
        $sql = "SELECT $elems FROM $table_name";

        $query = $this->db->prepare($sql);
        if($query->execute()){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            var_dump($query->errorInfo());
            die();
        }

    }

    public function read_elems_by_id($elems,$table_name,$id){
        $sql = "SELECT $elems FROM $table_name WHERE id = $id";

        $query = $this->db->prepare($sql);
        if($query->execute()){
            return $query->fetch(PDO::FETCH_ASSOC);
        }else{
            var_dump($query->errorInfo());
            die();
        }
    }


    public function read_elems_by($elems,$table_name,$key,$val){
        $sql = "SELECT $elems FROM $table_name WHERE $key = $val";

        $query = $this->db->prepare($sql);
        if($query->execute()){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            var_dump($query->errorInfo());
            die();
        }

    }


    
    /*================================
                U P D A T E
    ==================================*/
    public function update($table_name,$arr_headers,$id){
        $sql = "UPDATE $table_name SET ";
        $ind=0;
        foreach($arr_headers as $header=>$val){
            if($ind==count($arr_headers)-1){
                $sql.="$header=:$header";
            } else{
                $sql.="$header=:$header,";
            }
            $ind++;
        };
        $sql.=" WHERE id=$id";

        $query = $this->db->prepare($sql);
        
        foreach($arr_headers as $header=>$val){
            $query->bindValue(":$header", $val);
        };
        

        if($query->execute()){
            return true;
        }else{
            var_dump($query->errorInfo());
            die();
        }

    }
    
    /*================================
                D E L E T E
    ==================================*/
    public function delete($table_name,$id){
        $sql = "DELETE FROM $table_name WHERE id = $id";
        $query = $this->db->prepare($sql);
        
        if($query->execute()){
            return true;
        }else{
            var_dump($query->errorInfo());
            die();
        }

    }
    
    /*================================
            P A G I N A T I O N
    ==================================*/
    public function pagination($table_name, $elems_on_page){
        
        $sqlLIM = "SELECT id FROM $table_name";
        $queryLIM = $this->db->prepare($sqlLIM);
        if($queryLIM->execute()){
            $elems_on_page = $elems_on_page;     
            $numero_righe = $queryLIM->rowCount();
            $totPag = ceil($numero_righe / $elems_on_page);
            return $totPag;
        }
        else{
            var_dump($queryLIM->errorInfo());
            return false;
        }

    }
    
    /*================================
                S E A R C H
    ==================================*/
    public function search($elems, $table_name, $keyword, $arr_key, $logical_operator='', $order=''){
        
        $sqlLIM = "SELECT $elems FROM $table_name WHERE ";
        $keys_length = count($arr_key);
        if($keys_length>0 && !empty($logical_operator)){
            $ind = 0;
            foreach($arr_key as $key){
                if($ind==$keys_length-1){
                    $sqlLIM .= "$key ILIKE :keyword ";
                }else{
                    $sqlLIM .= "$key ILIKE :keyword $logical_operator ";
                }
                $ind++;
            };
            $order_by = !empty($order) ? "ORDER BY ".$order['key']." ".$order['dir'] : '' ;
            $sqlLIM .= $order_by;
        };
        
        $queryLIM = $this->db->prepare($sqlLIM);
        
        $queryLIM->bindValue(":keyword", "%$keyword%");

        if($queryLIM->execute()){
            return $queryLIM->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            var_dump($queryLIM->errorInfo());
        }

    }
  
}