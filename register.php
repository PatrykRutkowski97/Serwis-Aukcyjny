<?php
session_start();

if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']) { // sprawdzanie czy użytkownik nie jest już przypadkiem zalogowany
    header('Location: panel.php');
    exit();
}

require_once('connect.php');

require_once('password.php');

if(isset($_POST['send'])) {
    $error = false;
    $error_login = '';
    $error_password = '';
    $error_email = '';
    $add_user = false;
    //----------------------------------
    $login = trim(filter_var($_POST['login'], FILTER_SANITIZE_STRING));
    $password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
    $password2 = trim(filter_var($_POST['password2'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));

    $sql = "SELECT COUNT(login) AS num FROM users WHERE login= :login";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':login', $login);
    $statement->execute();

    $sql2 = "SELECT COUNT(email) AS num FROM users WHERE email= :email";
    $statement2 = $pdo->prepare($sql2);
    $statement2->bindValue(':email', $email);
    $statement2->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $row2 = $statement2->fetch(PDO::FETCH_ASSOC);

    if($row['num'] > 0) {
        $error_login = '<div class="alert alert-danger" role="alert">Podany login jest już zajęty <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if(empty($login)) {
        $error_login = '<div class="alert alert-danger" role="alert">Podany login jest nieprawidłowy <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if($row2['num'] > 0) {
        $error_email = '<div class="alert alert-danger" role="alert">Podany email jest już zajęty <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if(empty($email) || !$email) {
        $error_email = '<div class="alert alert-danger" role="alert">Podany email jest nieprawidłowy <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }

    if($password !== $password2) {
        $error_password = '<div class="alert alert-danger" role="alert">Podane hasła muszą być identyczne <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }   

    if(strlen($password) < 6) {
        $error_password = '<div class="alert alert-danger" role="alert">Hasło musi się składać z min 6 znaków<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if(empty($password) || empty($password2)) {
        $error_password = '<div class="alert alert-danger" role="alert">Podane hasło jest nieprawidłowe <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }
    
    if($error == false) {

        $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

        $sql = "INSERT INTO users (login, password, email) VALUES (:login, :password, :email)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':login', $login);
        $statement->bindValue(':password', $passwordHash);
        $statement->bindValue(':email', $email);

        $result = $statement->execute();
        $add_user = true;

        $to = $email;
        $subject = 'Rejestracja skup.pl';
        $message = 'Twoje konto zostało prawidłowo zarejestrowane w serwisie skup.pl';
        $emailSend = mail($to, $subject, $message);

        if($email) {
            $success_email = '<div class="alert alert-success" role="alert">Na twój email wysłaliśmy potwierdzenie rejestracji <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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
                    <h1 class="text-center">Zarejestruj się</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mx-auto d-block">
                    <form actiono="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group">
                            <?php 
                            //  Prawidłowo dodano użytkownika
                                if(isset($add_user) && $add_user == true) {
                                    echo '<div class="alert alert-success" role="alert">';
                                    echo "Gratulacje <b>$login</b>. Twoje konto zostało utworzone.";
                                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                    echo '</div>';
                                    $add_user = false;
                                    $login = '';
                                    $email = '';
                                }
                                if(isset($success_email)) {
                                    echo $success_email;
                                }

                            //  Błąd z loginem
                                if(isset($error_login)) {
                                    echo $error_login;
                                    unset($error_login);
                                }

                                if(isset($error_password)) {
                                    echo $error_password;
                                    unset($error_password);
                                }

                                if(isset($error_email)) {
                                    echo $error_email;
                                    unset($error_email);
                                }
                                 ?>
                            <label for="login">Podaj login</label>
                            <input type="text" class="form-control" name="login" id="login" value="<?php if(isset($login)) echo $login ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Podaj hasło</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password2">Powtórz hasło</label>
                            <input type="password" class="form-control" name="password2" id="password2">
                        </div>
                        <div class="form-group">
                            <label for="email">Podaj email</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="<?php if(isset($email)) echo $email ?>">
                        </div>
                        <button type="submit" name="send" class="btn btn-primary">Rejestruj</button>
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