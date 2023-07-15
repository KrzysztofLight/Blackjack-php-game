<?php
    session_start();
    // sprawdz_wygrana();
    $nazwy = ['C','D','T','P'];
    $numery = ['2','3','4','5','6','7','8','9','10','A','K','Q','J'];
    if(!isset($_SESSION['gracz']) && !isset($_SESSION['komputer'])){
        $_SESSION['gracz'] = array();
        $_SESSION['komputer'] = array();
        if(count($_SESSION['gracz']) < 2 && count($_SESSION['komputer']) < 2){
            for($i=0;$i<2;$i++){
                // $_SESSION['gracz'][$i] = $nazwy[rand(0,3)]."/".$numery[rand(0,12)];
                dobierz_gracz($nazwy,$numery);
                dobierz_komputer($nazwy,$numery);
                // $_SESSION['komputer'][$i] = $nazwy[rand(0,3)]."/".$numery[rand(0,12)];
                
            }
        }
    }

    if(!isset($_SESSION['komputer_pass'])){
        $_SESSION['komputer_pass'] = false;
    }

    if(isset($_GET['pass']) || isset($_GET['dobierz'])){
        odpal_ai($nazwy,$numery);
    }

    if(isset($_GET['dobierz'])){
        dobierz_gracz($nazwy,$numery);
    }

    function sprawdz_wygrana(){
        $_SESSION['punkty_komputer'] > $_SESSION['punkty_gracz'] ? $_SESSION['wygrana'] = 'k' : $_SESSION['wygrana'] = 'g';
    }

    if(!isset($_SESSION['punkty_gracz'])){
        $_SESSION['punkty_gracz'] = 0;
    }
    if(!isset($_SESSION['punkty_komputer'])){
        $_SESSION['punkty_komputer'] = 0;
    }

    if(isset($_GET["zakoncz"])){
        session_destroy();
        header('location: index.php');
    }

    // if(isset($_GET["pass"])){
    //     komputer_dobierz();
    // }


    function dobierz_komputer($nazwy,$numery){
        $_SESSION['komputer'][count($_SESSION['komputer'])] = $nazwy[rand(0,3)]."/".$numery[rand(0,12)];
        $str = $_SESSION['komputer'][count($_SESSION['komputer'])-1];
        $punkty = explode("/",$str);
        switch($punkty[1]){
            case 'A':
                $_SESSION['punkty_komputer'] += 11;
                break;
            case 'K':
            case 'Q':
            case 'J':
                $_SESSION['punkty_komputer'] += 10;
                break;
            case '2':
                $_SESSION['punkty_komputer'] += 2;
                break;
            case '3':
                $_SESSION['punkty_komputer'] += 3;
                break;
            case '4':
                $_SESSION['punkty_komputer'] += 4;
                break;
            case '5':
                $_SESSION['punkty_komputer'] += 5;
                break;
            case '6':
                $_SESSION['punkty_komputer'] += 6;
                break;
            case '7':
                $_SESSION['punkty_komputer'] += 7;
                break;
            case '8':
                $_SESSION['punkty_komputer'] += 8;
                break;
            case '9':
                $_SESSION['punkty_komputer'] += 9;
                break;
            case '10':
                $_SESSION['punkty_komputer'] += 10;
                break;
        }
        // $_SESSION['punkty_gracz'] += ($punkty);
        if($_SESSION['punkty_komputer'] > 21){
            $_SESSION['wygrana'] = 'g';
        }
        else if($_SESSION['punkty_komputer'] == 21){
            $_SESSION['wygrana'] = 'k';
        }
    }

    function dobierz_gracz($nazwy,$numery){

        $_SESSION['gracz'][count($_SESSION['gracz'])] = $nazwy[rand(0,3)]."/".$numery[rand(0,12)];
        $str = $_SESSION['gracz'][count($_SESSION['gracz'])-1];
        $punkty = explode("/",$str);
        switch($punkty[1]){
            case 'A':
                $_SESSION['punkty_gracz'] += 11;
                break;
            case 'K':
            case 'Q':
            case 'J':
                $_SESSION['punkty_gracz'] += 10;
                break;
            case '2':
                $_SESSION['punkty_gracz'] += 2;
                break;
            case '3':
                $_SESSION['punkty_gracz'] += 3;
                break;
            case '4':
                $_SESSION['punkty_gracz'] += 4;
                break;
            case '5':
                $_SESSION['punkty_gracz'] += 5;
                break;
            case '6':
                $_SESSION['punkty_gracz'] += 6;
                break;
            case '7':
                $_SESSION['punkty_gracz'] += 7;
                break;
            case '8':
                $_SESSION['punkty_gracz'] += 8;
                break;
            case '9':
                $_SESSION['punkty_gracz'] += 9;
                break;
            case '10':
                $_SESSION['punkty_gracz'] += 10;
                break;
        }
        // $_SESSION['punkty_gracz'] += ($punkty);
        if($_SESSION['punkty_gracz'] > 21){
            $_SESSION['wygrana'] = 'k';
        }
        else if($_SESSION['punkty_gracz'] == 21){
            $_SESSION['wygrana'] = 'g';
        }
        else if ($_SESSION['punkty_gracz'] == 21 && $_SESSION['punkty_komputer']){
            $_SESSION['wygrana'] = 'r';
        }
    }

    function odpal_ai($nazwy,$numery){
        if($_SESSION['punkty_komputer'] <= 16){
            dobierz_komputer($nazwy,$numery);
        }
        else if($_SESSION['punkty_komputer'] < 21){
            $_SESSION['komputer_pass'] = true;
        }
        if($_SESSION["komputer_pass"] == true && isset($_GET['pass'])){
            if($_SESSION['punkty_gracz'] > $_SESSION['punkty_komputer']){
                $_SESSION['wygrana'] = 'g';
            }
            else if ($_SESSION['punkty_gracz'] == $_SESSION['punkty_komputer']){
                $_SESSION['wygrana'] = 'r';
            }
            else $_SESSION['wygrana'] = 'k';
        }

    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: green;
            text-align:center;
            font-weight:bolder;
            margin-top:10%;
            font-size:150%;
        }
        input{
            font-size:110%;
        }
    </style>
</head>
<body>
    <form method="GET">
        <?php
        echo "<p>Twoje punkty: ".$_SESSION['punkty_gracz']."</p>\n";
        echo "<p>Punkty komputera: ".$_SESSION['punkty_komputer']."</p>\n";
        ?>
        <input type="submit" name="zakoncz" value="Zakończ"> 
        <?php
        if(!isset($_SESSION['wygrana'])){
            echo "<input type=\"submit\" name=\"pass\" value=\"Pass\">\n";
            echo "<input type=\"submit\" name=\"dobierz\" value=\"Dobierz Karte\">\n";
            echo "<p>Twoje karty: </p>";
            for($i=0;$i<count($_SESSION['gracz']); $i++){
                echo $_SESSION['gracz'][$i];
                echo "<br>";
            }
            echo "<p>Karty komputera:</p>";
            for($i=0;$i<count($_SESSION['komputer']); $i++){
                echo $_SESSION['komputer'][$i];
                echo "<br>";
            }
        }
        else{
            if($_SESSION['wygrana'] == 'k'){
                echo "<p>Komputer wygral</p>";
            }
            else if($_SESSION['wygrana'] == 'r') echo "<br><p>Remis</p>";
            else echo "<br>\n<p>Gracz wygral</p>";
        }
        ?>
    </form>
</body>
</html>