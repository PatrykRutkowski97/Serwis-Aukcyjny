<?php
session_start();

if(!isset($_SESSION['zalogowany']) && !$_SESSION['zalogowany']) {
    header('Location: login.php');
    exit();
}


require_once('connect.php');

$sql = "SELECT * FROM articles WHERE author = :author";
$result = $pdo->prepare($sql);
$result->bindValue(':author', $_SESSION['login']);
$result->execute();

$result2 = $result->fetchAll(PDO::FETCH_ASSOC);
$length_array = count($result2);


?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,700" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">

    <title>Skup.pl | Sprzedam, kupię, zamienię</title>
  </head>
  <body>
    <?php include_once('navbar-login.php'); ?>

    <div class="container">
        <div class="row mx-auto d-block">  
            
            <div class="row">

            <?php
                if($length_array == 0) {
                    echo '<div class="row"><div class="col-lg-12">';
                    echo '<h3 class="text-center error">Nie masz jeszcze żadnych ogłoszeń</h3></div></div>';

                }
                else {
                    for($i = 0; $i < $length_array; $i++) {
                        echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
                        echo '<div class="card" style="width: 18rem;">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">'. $result2[$i]['title'] .'</h5>';
                        echo '<p class="card-text"><small class="text-muted">'. $result2[$i]['date'] .'</small></p>';
                        echo '<a href=single-add.php?id='. $result2[$i]['id'] .'><button type="button" class="btn btn-primary">Zobacz</button></a>';
                        echo '</div></div></div>';
                    }
                }
            ?>
                
            </div>
    </div>
            </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>