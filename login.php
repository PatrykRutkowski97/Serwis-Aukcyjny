<?php
session_start();

if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']) { // sprawdzanie czy użytkownik nie jest już przypadkiem zalogowany
    header('Location: panel.php');
    exit();
}

require_once('password.php');   // dołączenie biblioteki
require_once('connect.php');    //dołączenie bazdy danych

if(isset($_POST['send'])) {
    $login = trim(filter_var($_POST['login'], FILTER_SANITIZE_STRING));     // pole login z formularza
    $password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));   // pole hasło z formularza

    $sql = "SELECT login, password FROM users WHERE login = :login";    // zapytanie sql
    $statement = $pdo->prepare($sql);   // przygotowanie zapytania do bazy
    $statement->bindValue(':login',$login);     //zbindowanie wartosci podstawionych w zapytaniu sql

    $statement->execute();  // wykonanie zapytania

    $user = $statement->fetch(PDO::FETCH_ASSOC);    //tablica asocjacyjna z wartosciami z bazy

    if($user === false) {
        $error = '<div class="alert alert-danger" role="alert">Nieprawidłowy login lub hasło<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
    else {
        $validPassword = password_verify($password, $user['password']);

        if($validPassword) {
            $_SESSION['zalogowany'] = true;
            $_SESSION['login'] = $user['login'];

            header('Location: panel.php');
            exit();
        }
        else {
            $error = '<div class="alert alert-danger" role="alert">Nieprawidłowy login lub hasło<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
    }
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
  <body>

    <!-- Navbar navigation -->

    <?php include_once('navbar-logout.php'); ?>

          <section id="one">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="text-center">Zaloguj się</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mx-auto d-block">
                        <form actiono="panel.php" method="post">
                        <?php if(isset($error) && !empty($error)) { echo $error; unset($error);} ?>
                            <div class="form-group">
                                <label for="login">Podaj login</label>
                                <input type="text" class="form-control" name="login" value="<?php if(isset($_POST['login'])) echo $login; ?>">
                            </div>
                            <div class="form-group">
                                <label for="surname">Podaj hasło</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button type="submit" name="send" class="btn btn-primary">Zaloguj się</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>