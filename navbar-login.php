<nav class="navbar navbar-expand-lg navbar-light bg-white ">
    <div class="container">
  <a class="navbar-brand" href="index.php">Skup.pl</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>
    <form class="form-inline my-2 my-lg-0">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown" id="main_login">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['login']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="myadd.php">Moje ogłoszenia</a>
            <a class="dropdown-item" href="panel.php">Szukaj</a>
            <a class="dropdown-item" href="add.php">Dodaj</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Wyloguj się</a>
            </div>
        </li>
    </ul>
    </form>
  </div>
</div>
</nav>