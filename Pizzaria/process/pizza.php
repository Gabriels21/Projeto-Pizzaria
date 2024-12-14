<?php
    
    include_once("conn.php");

    //Conseguimos saber se o método é um GET(acessando) ou POST(enviando)
    $method = $_SERVER["REQUEST_METHOD"]; 

    //Se for GET(acessando): regasta os dados (opções), para a montagem do pedido
    if($method === "GET"){

        /*Váriavel quer armazena as query responsável por resgatar todas as bordas
        que estão cadastradas no banco de dados*/
        $bordasQuery = $conn->query("SELECT * FROM bordas;");

        /*Váriavel que executa a váriavel $bordasQuery(que é uma query) transferindo 
        os dados da query para um array, possibilitando a manipulação dos dados do BD
        no front-end*/
        $bordas = $bordasQuery->fetchALL();

        /*Váriavel quer armazena as query responsável por resgatar todas as massas
        que estão cadastradas no banco de dados*/
        $massasQuery = $conn->query("SELECT * FROM massas;");

        /*Váriavel que executa a váriavel $massasQuery(que é uma query) transferindo 
        os dados da query para um array, possibilitando a manipulação dos dados do BD
        no front-end*/
        $massas = $massasQuery->fetchALL();

        /*Váriavel quer armazena as query responsável por resgatar todos os sabores
        que estão cadastradas no banco de dados*/
        $saboresQuery = $conn->query("SELECT * FROM sabores;");

        /*Váriavel que executa a váriavel $saboresQuery(que é uma query) transferindo 
        os dados da query para um array, possibilitando a manipulação dos dados do BD
        no front-end*/
        $sabores = $saboresQuery->fetchALL();

        //print_r($sabores);

    //Se for POST(enviando) criação do pedido
    }else if($method === "POST"){

        $data = $_POST;

        $borda = $data["borda"];
        $massa = $data["massa"];
        $sabores = $data["sabores"];

        //Validação de sabores máximo
        if(count($sabores) > 3){
            $_SESSION["msg"] = "Escolher no máximo 3 sabores!";
            $_SESSION["status"] = "warning";
        }else{

            echo "Validado";
            exit;

        }

        //Retorna para página inicial
        header("location: ..");

    }

?>