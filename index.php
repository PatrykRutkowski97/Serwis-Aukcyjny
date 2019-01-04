<?php
session_start();

if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']) { // sprawdzanie czy użytkownik nie jest już przypadkiem zalogowany
    header('Location: panel.php');
    exit();
}

if(isset($_POST['send'])) {     // jesli wysłano formularz kontaktowy
    //  sprawdzanie poprawnosci danych z formularza
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $surname = trim(filter_var($_POST['surname'], FILTER_SANITIZE_STRING));
    $text = trim(filter_var($_POST['text'], FILTER_SANITIZE_STRING));
    // Error forms
    $error_email = '';
    $error_name = '';
    $error_surname = '';
    $error_text = '';
    $error = false;

    //  jesli email jest nieprawidłowy lub puste pole
    if(!$email || empty($email)) {
        $error_email = '<div class="alert alert-danger" role="alert">Podany email jest nieprawidłowy <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }
    //  jesli imie jest nieprawidłowe lub puste pole
    if(!$name || empty($name)) {
        $error_name = '<div class="alert alert-danger" role="alert">Podane imię jest nieprawidłowe <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }
    //  jesli nazwisko jest nieprawidłowe lub puste pole
    if(!$surname || empty($surname)) {
        $error_surname = '<div class="alert alert-danger" role="alert">Podane nazwisko jest nieprawidłowe <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }
    //  jesli wiadomosc jest nieprawidłowa lub puste pole
    if(!$text || empty($text)) {
        $error_text = '<div class="alert alert-danger" role="alert">Podana wiadomość jest nieprawidłowa <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $error = true;
    }
    //  jesli wysztko jest OK - nie ma błędów
    if(!$error) {
        @$sendMail = mail('root@gmail.com','Wiadomosc z formularza',$text);
        //  jesli email wysłano prawidłowo
        if($sendMail) {
            $sucess_mail = '<div class="alert alert-success" role="alert">Twoja wiadomość została wysłana prawidłowa <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
        //  jesli nie wysłano maila
        else {
            $error_mail = '<div class="alert alert-warning" role="alert">Twoja wiadomość nie została wysłana <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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


    <div class="container">
    <div hidden id="sended"><?php if(isset($sended)) echo $sended; ?></div>

        <!--  Header  -->
    <header id="header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h2 class="text-center">Sprzedam, kupię, zamienię</h2><br>
                <p class="text-center">Lorem ipsum dolor sit amet felis. Aliquam malesuada ultricies. Donec rutrum euismod, massa dui dui, in wisi. Phasellus dui aliquam eros in nulla dictum suscipit wisi. Sed justo neque, mattis nec, hendrerit sollicitudin orci. </p>
        
                <div class="form-group col-lg-10 mx-auto d-block">
                    <a href="panel.php" class="btn btn-primary mx-auto d-block">Zobacz ogłoszenia</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <img id="head" src="img/person.jpg" class="img-fluid mx-auto d-block">
            </div>
        </div>
    </header>


    <!-- Section ONE -->
    <section id="one">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">What you can do with Apres</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 text-center mx-auto d-block">
                <p>Apres is where you give your data superpowers, integrated to fit your team's needs, and built to let anyone unlock the potential of their data.</p>
            </div>
        </div>
         <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 text-center">
                <i class="fas fa-mobile-alt fa-5x "></i>
                <p class="title font-weight-bold">Data Enrichment</p>
                <p>Enrich your current database with web research, cleaning, de-duplication and more.</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 text-center">
                <i class="fab fa-cc-paypal fa-5x "></i>
                <p class="title font-weight-bold">Computer Vision</p>
                <p>Enrich your current database with web research, cleaning, de-duplication and more.</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 text-center">
                <i class="fas fa-coins fa-5x"></i>
                <p class="title font-weight-bold">Text Analysis</p>
                <p>Enrich your current database with web research, cleaning, de-duplication and more.</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 text-center">
                <i class="fab fa-linode fa-5x"></i>
                <p class="title font-weight-bold">Transcription</p>
                <p>Enrich your current database with web research, cleaning, de-duplication and more.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="#" class="text-center  mx-auto d-block">Learn more about our features</a>
            </div>
        </div>
    </section>

        <!-- Section TWO  -->

        <section id="two">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">Drag, drop, automate</h1>
                 </div>
            </div>
            <div class="row">
                <div class="col-lg-8 text-center mx-auto d-block">
                    <p>Apres is an easy-to-use visual tool that lets you build custom data automations and ship them directly in your app without writing any code.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <img src="img/one.jpg" class="img-fluid mx-auto d-block">
                    <p>Integrations to import for your current data, software and systems, then scheduling to automate it.</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <img src="img/two.jpg" class="img-fluid mx-auto d-block">
                    <p>Integrations to import for your current data, software and systems, then scheduling to automate it.</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <img src="img/three.jpg" class="img-fluid mx-auto d-block">
                    <p>Integrations to import for your current data, software and systems, then scheduling to automate it.</p>
                </div>
            </div>
        </section>

        </div>

            <section id="three" class="bg-primary">
                <div class="container">
                    <h1 class="text-center">Zobacz wszystkie oferty</h1>
                    <h4 class="text-center">Nie czekaj, zarejestruj się</h4>
                    <div class="text-center">
                        <a href="register.php" class="btn btn-light btn-lg">Zarejestruj się</a>
                    </div>
                    
                </div>
            </section>


            <section id="contact">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="text-center">Kontakt</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mx-auto d-block">
                            <form actiono="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="form-group">
                                <?php
                                //  Mail wysłano prawidłowo - OK
                                    if(isset($sucess_mail)) {
                                        echo $sucess_mail;
                                        unset($sucess_mail);
                                    }
                                    // jesli wszystkie pole OK ale nie wysłano maila
                                    if(isset($error_mail)) {
                                        echo $error_mail;
                                        unset($error_mail);
                                    }
                                    //  błąd z adresem email
                                    if(isset($error_email)) {
                                        echo $error_email;
                                        unset($error_email);
                                    }
                                    //  błąd z imieniem
                                    if(isset($error_name)) {
                                        echo $error_name;
                                        unset($error_name);
                                    }
                                    //  błąd z nazwiskiem
                                    if(isset($error_surname)) {
                                        echo $error_surname;
                                        unset($error_surname);
                                    }
                                    //  błąd z wiadomoscią
                                    if(isset($error_text)) {
                                        echo $error_text;
                                        unset($error_text);
                                    }
                                ?>
                                    <label for="email">Adres email</label>
                                    <input type="text" class="form-control" name="email" id="email">
                                    <small id="emailHelp" class="form-text text-muted">Twój email jest zawsze <b>bezpieczny</b>.</small>
                                </div>
                                <div class="form-group">
                                    <label for="name">Podaj imię</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="surname">Podaj nazwisko</label>
                                    <input type="text" class="form-control" name="surname" id="surname">
                                </div>
                                <div class="form-group">
                                    <label for="text">Wiadomość</label>
                                    <textarea class="form-control" name="text" id="text" rows="3"></textarea>
                                </div>
                                <button type="submit" name="send" id="send" class="btn btn-primary">Dodaj ogłoszenie</button>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </section>

    <?php include_once('footer.php'); ?>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/script.js"></script>
    <script>
        // Form Validation 
        const email = document.getElementById('email');
        const name = document.getElementById('name');
        const surname = document.getElementById('surname');
        const text = document.getElementById('text');
        const btn_submit = document.getElementById('send');

        btn_submit.addEventListener('click', e => {
            if(email.value == '') {
                email.classList.add('is-invalid');
                e.preventDefault();     
            }
            if(name.value == '') {
                name.classList.add('is-invalid');
                e.preventDefault();     
            }
            if(surname.value == '') {
                surname.classList.add('is-invalid');
                e.preventDefault();     
            }
            if(text.value == '') {
                text.classList.add('is-invalid');
                e.preventDefault();     
            }

            document.getElementById('contact').scrollIntoView();
        });
    </script>
  </body>
</html>