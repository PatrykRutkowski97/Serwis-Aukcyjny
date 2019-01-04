<?php
session_start();

if(!isset($_SESSION['zalogowany']) && !$_SESSION['zalogowany']) {
    header('Location: login.php');
    exit();
}


require_once('connect.php');

$sql = "SELECT * FROM articles ORDER BY id DESC ";
$result = $pdo->prepare($sql);
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
    
    <!-- Navbar -->
       
    <?php include_once('navbar-login.php'); ?>

    <div class="container">
        <div class="row mx-auto d-block">  
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="form-search"> 
            <div class="form-group row">
              <div class="col-sm-6 my-1">
                <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
                <div class="input-group">
                <input class="form-control" name="search" id="search" type="text" placeholder="Szukaj spośród <?php echo $length_array; ?> ogłoszeń...">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fas fa-search"></i></div>
                </div>
              </div>
            </div>
          </form>
    </div>


    

        </div>
        <div class="row searching-table">  
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
              <table class="table table-hover">
                <tbody>
                    <?php
                            if($length_array == 0) {
                              echo '<div class="row"><div class="col-lg-12">';
                              echo '<h3 class="text-center error ">W bazie danych nie ma żdanych ogłoszeń</h3></div>';
                              echo '</div><div class="row"><div class="col-lg-12">';
                              echo '<img src="img/date.jpg" class="img-fluid" alt="Responsive image">';
                              echo '</div></div>';
                            }
                            for($i = 0; $i < $length_array; $i++) {
                              if($result2[$i]['highlighted'] == 1) {
                                $add_highlighted = '<span class="badge badge-warning">Wyróżnione</span>';
                              }
                              echo '<tr>';
                              if(isset($add_highlighted) && !empty($add_highlighted)) {
                                echo '<td>'. $add_highlighted . '</td>';
                              } else {
                                echo '<td></td>';
                              }
                              echo '<td class="title">' . ucfirst($result2[$i]['title']) . '</td>';
                              echo '<td><p class="font-weight-bold">' . number_format($result2[$i]['price'], 0, ',', ' ') . ' zł</p></td>';
                              echo '<td>' . $result2[$i]['city'] . '</td>';
                              echo '<td>'. $result2[$i]['date'] .'</td>';
                              echo '<td><a href=single-add.php?id='. $result2[$i]['id'] .'><button type="button" class="btn btn-primary">Zobacz</button></a></td>';
                              echo '</tr>';
                              unset($add_highlighted);
                            }                      
                      ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


              


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/search.js"></script>
  </body>
</html>