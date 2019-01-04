<?php
session_start();

if(!isset($_SESSION['zalogowany']) && !$_SESSION['zalogowany']) {
    header('Location: login.php');
    exit();
}

require_once('connect.php');

$sql = "SELECT * FROM articles WHERE id = :id";
$statement = $pdo->prepare($sql);
@$statement->bindValue(':id', $_GET['id']);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);

if(!$result) {
    $error_statment = true;
}

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
  <body >

    <?php include_once('navbar-login.php'); ?>

    <div class="container shadow p-3 mb-5 bg-light rounded" id="single-add">
        <div class="container">
            <?php
                if(isset($error_statment)) {
                    echo '<div class="row"><div class="col-lg-12">';
                    echo '<a href="panel.php" class="btn btn-outline-primary">Powrót</a><h3 class="text-center error ">Ups.. Wygląda na to, że nie ma takiego ogłoszenia</h3></div>';
                    echo '</div><div class="row"><div class="col-lg-12">';
                    echo '<img src="img/error.png" class="img-fluid" alt="Responsive image" >';
                    echo '</div></div>';
                }
                else {
                
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <button type="button" class="btn btn-outline-primary back back_btn" id="back">Powrót</button>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?php 
                        echo '<h3 class="text-center text-primary font-weight-bold" id="main-title">' .  ucfirst($result['title']) . '</h3>';
                    ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?php 
                        echo '<p class="text-center p-3 mb-2 bg-primary text-white font-weight-bold" id="price">' .  number_format($result['price'], 0, ',', ' ') . ' zł</p>';
                    ?>
                </div>
                </div>
            </div>

            <div class="row">
                <div class="container">
                    <div class="col-lg-10 mx-auto d-block">
                            <?php echo '<p class="text-muted text-justify description" style="margin-top: 10%; margin-bottom: 10%">' . $result['description'] . '</p>'; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?php echo '<p class="bg-primary text-white text-center font-weight-bold info-block">' . $result['name'] . '</p>'; ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?php echo '<p class="bg-primary text-white text-center font-weight-bold info-block">' . $result['city'] . '</p>'; ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?php echo '<p class="bg-primary text-white text-center font-weight-bold info-block" id="telephone">' . number_format($result['phone'], 0, ',', '-') . '</p>'; ?>
                </div>
            </div>

            <?php } ?>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        document.getElementById('back').addEventListener('click', () => {
        window.history.back();
        });
    </script>
</body>
</html>