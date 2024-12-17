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

        //Salvando borda e massa na pizza
        $stm = $conn->prepare("INSERT INTO pizzas (borda_id, massa_id) VALUES (:borda, :massa)");

        //Filtrando inputs/Ligando os parâmetros passados a uma variável
        $stm->bindParam(":borda", $borda, PDO::PARAM_INT);
        $stm->bindParam(":massa", $massa, PDO::PARAM_INT);

        $stm->execute();

        //Resgatando o id da última pizza inserida
        $pizzaId = $conn->lastInsertId();

        $stm = $conn->prepare("INSERT INTO pizza_sabor (pizza_id, sabor_id) VALUES (:pizza, :sabor)");

        //Repetição até salvar todos os sabores

        foreach ($sabores as $sabor) {

        //Filtrando inputs/Ligando os parâmetros passados a uma variável
        $stm->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);
        $stm->bindParam(":sabor", $sabor, PDO::PARAM_INT);

        $stm->execute();

        }

        //Criar o pedido da pizza
        $stm = $conn->prepare("INSERT INTO pedidos (pizza_id, status_id) VALUES (:pizza, :status)");

        //Status sempre inicia com 1 = em produção
        $statusId = 1;

        //Filtrando inputs
        $stm->bindParam(":pizza", $pizzaId);
        $stm->bindParam(":status", $statusId);

        $stm->execute();

        // Exibir mensagem de sucesso
        $_SESSION["msg"] = "Seu pedido foi registrado com sucesso";
        $_SESSION["status"] = "success";

        }

        //Retorna para página inicial
        header("location: ..");

    }

?>