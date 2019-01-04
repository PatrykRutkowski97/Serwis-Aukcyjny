<?php
session_start();

if(!isset($_SESSION['zalogowany']) && !$_SESSION['zalogowany']) {
    header('Location: login.php');
    exit();
}
else {

if(isset($_POST['send'])) {

    require_once('connect.php');

    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
    $condition = filter_var($_POST['condition'], FILTER_SANITIZE_STRING);
    $desc = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $highlighted = filter_var($_POST['highlighted'], FILTER_SANITIZE_STRING);
    // Komunikaty o błędach
    $error = false;
    $error_title = '';
    $error_price = '';
    $error_condition = '';
    $error_desc = '';
    $error_city = '';
    $error_name = '';
    $error_phone = '';
    $error_highlighted = '';

    if(empty($title) || strlen($title) > 70) {
        $error_title = '<div class="alert alert-danger" role="alert">Podany tytuł jest nieprawidłowy lub zbyt długi <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if(empty($price) || !is_numeric($price)) {
        $error_price = '<div class="alert alert-danger" role="alert">Podana cena jest nieprawidłowa <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if($condition == 'Wybierz...') {
        $error_condition = '<div class="alert alert-danger" role="alert">Wybierz stan przedmiotu <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if(empty($desc) || strlen($desc) > 1000) {
        $error_desc = '<div class="alert alert-danger" role="alert">Podany opis jest nieprawidłowy lub zbyt długi <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if(empty($city) || is_numeric($city)) {
        $error_city = '<div class="alert alert-danger" role="alert">Podane miasto jest nieprawidłowe <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if(empty($phone) || !is_numeric($phone)) {
        $error_phone = '<div class="alert alert-danger" role="alert">Podany numer telefonu jest nieprawidłowy <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if($highlighted == 'Wybierz...') {
        $error_highlighted = '<div class="alert alert-danger" role="alert">Wybierz opcję czy wyróżnić ogłoszenie<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }

    if(!$error) {

        $sql = "INSERT INTO articles (title,price,condition_art,description,city,name,phone,author, highlighted, date) VALUES (:title,:price,:condition_art,:description,:city,:name,:phone,:author, :highlighted,:date)";
        $statment = $pdo->prepare($sql);    // przygotowanie zapytania SQL
        $statment->bindValue(':title', mb_strtolower($title, 'UTF-8'));     //bindowanie podstawionych wartosc
        $statment->bindValue(':price', $price);
        $statment->bindValue(':condition_art', $condition);
        $statment->bindValue(':description', $desc);
        $statment->bindValue(':city', $city);
        $statment->bindValue(':name', $name);
        $statment->bindValue(':phone', $phone);
        $statment->bindValue(':author', $_SESSION['login']);
        $statment->bindValue(':highlighted', $highlighted);
        $statment->bindValue(':date', date('Y-m-d'));

        $result = $statment->execute();     // wykonanie zapytania do bazy danych

        // jeżeli wszystko OK - resetowanie wprowadzonych wartosci do pól
        if($result) {
            $success = '<div class="alert alert-success" role="alert">Twoje ogłoszenie zostało dodane<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $title = '';
            $price = '';
            $condition = '';
            $desc = '';
            $city = '';
            $name = '';
            $phone = '';
            $highlighted = '';
        }   // jesli cos poszło nie tak
        else {
            $error_add = '<div class="alert alert-danger" role="alert">Ups.. Coś poszło nie tak. Artykuł nie został dodany. Spróbuj ponownie.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
        
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
    <!-- Navbar -->
    <?php include_once('navbar-login.php'); ?>

    <section id="add_ad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">Dodaj ofertę</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mx-auto d-block ">
                    <form enctype="multipart/form-data" actiono="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-add-ad" id="form">
                        <div class="form-group">
                        <?php
                        //  jeżeli jest jakis problem nie przez użytkownika
                        if(isset($error_add)) {
                            echo $error_add;
                            unset($error_add);
                        }
                        //  błąd wprowadzonego tytułu
                        if(isset($error_title)) {
                            echo $error_title;
                            unset($error_title);
                        }
                        //  błąd wprowadzonej ceny
                        if(isset($error_price)) {
                            echo $error_price;
                            unset($error_price);
                        }
                        //  nie wprowadzono stanu przedmiotu
                        if(isset($error_condition)) {
                            echo $error_condition;
                            unset($error_condition);
                        }
                        //  błąd wprowadzonego opisu
                        if(isset($error_desc)) {
                            echo $error_desc;
                            unset($error_desc);
                        }
                        //  błąd wprowadzonego miasta
                        if(isset($error_city)) {
                            echo $error_city;
                            unset($error_city);
                        }
                        //  błąd wprowadzonego imienia
                        if(isset($error_name)) {
                            echo $error_name;
                            unset($error_name);
                        }
                        //  błąd wprowadzonego telefonu
                        if(isset($error_phone)) {
                            echo $error_phone;
                            unset($error_phone);
                        }
                        //  błąd ze zdjęciem
                        if(isset($error_image)) {
                            echo $error_image;
                            unset($error_image);
                        }
                        //  wszystko OK - Sukces
                        if(isset($success) && $success) {
                            echo $success;
                            $success = '';
                        }
                        ?>
                            <label for="title">Wpisz tytuł <span class="required">*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php if(isset($title)) echo $title; ?>" maxlength="70">
                            <small class="form-text text-muted">Pozostało <span id="title_length"></span> znaków</small>
                        </div>
                        <div class="form-group">
                            <label for="price">Cena <span class="required">*</span></label>
                            <input type="text" class="form-control" name="price" id="price" value="<?php if(isset($price)) echo $price; ?>" placeholder="np. 700 (bez zł)">
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2" for="condition">Stan <span class="required">*</span></label>
                            <select class="custom-select mr-sm-2" name="condition" id="condition" value="<?php if(isset($condition)) echo $condition; ?>">
                                <option selected>Wybierz...</option>
                                <option value="new">Nowe</option>
                                <option value="used">Używane</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="desc">Opis <span class="required">*</span></label>
                            <textarea class="form-control" name="desc" id="desc" rows="4" maxlength="1000"><?php if(isset($desc)) echo $desc; ?></textarea>
                            <small class="form-text text-muted">Pozostało <span id="desc_length"></span> znaków</small>
                        </div>
                        <div class="form-group">
                            <label for="city">Miasto <span class="required">*</span></label>
                            <input type="text" class="form-control" name="city" id="city" value="<?php if(isset($city)) echo $city; ?>">
                        </div>
                        <div class="form-group">
                            <label for="name">Podaj imię <span class="required">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($name)) echo $name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefon <span class="required">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php if(isset($phone)) echo $phone; ?>" placeholder="np. 785201302">
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2" for="highlighted">Wyróżnienie <span class="required">*</span></label>
                            <select class="custom-select mr-sm-2" name="highlighted" id="highlighted">
                                <option selected>Wybierz...</option>
                                <option value="1">Tak</option>
                                <option value="0">Nie</option>
                            </select>
                        </div>
                        <button type="submit" name="send" id="send" class="btn btn-primary">Dodaj ogłoszenie</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/add_validate.js"></script>
</body>
</html>