<?php
    $server = "localhost";
    $username = "php_mysql";
    $password = "hunt88";
    $db = "persons";
    $con = mysqli_connect($server, $username, $password, $db);

    if(!$con){
      die("Connection error: " . mysqli_connect_error());
    }
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta name="description" content="Książka kontaktów. Idealne i łatwe w obsłudze narzędzie do zapisywania danych kontaktowych przyjaciół">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Książka adresowa</title>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="css/custom.css">
	</head>

<body>
  <div class="container">
    <div class="jumbotron">
				<header>
					<h1>Książka adresowa.<br><small>Zarządzaj efektywnie swoimi kontaktami.</small></h1>
				</header>
    </div>
    <div class="row">


        <!-- Searching user form -->
    <form class="col-lg-5" method="post">
      <fieldset>
          <legend>Znajdź osobę</legend>
              <div class="form-group">
                  <label for='search_user'>Szukaj:</label>
                  <input type='text' id='search_user' class="form-control" name='key' placeholder="np. imię lub nazwisko lub adres lub numer telefonu">
              </div>
              <div class="form-group">
                  <input type='submit' class="btn btn-primary" name='find' value="Wyszukaj">
              </div>
      </fieldset>
    </form>

  <?php
        // If statement for FORM

    if(isset($_GET['edt_id'])) {
        $sql = "SELECT * FROM person WHERE id='$_GET[edt_id]'";
        $run = mysqli_query($con, $sql);
      while($rows = mysqli_fetch_assoc($run)) {
          $userName = $rows['name'];
          $userSurname = $rows['surname'];
          $userAddress = $rows['address'];
          $userPhone = $rows['phone'];
    }
  ?>

  <form class="col-lg-5 col-lg-offset-2" method="post">
      <fieldset>
          <legend>Edytuj kontakt</legend>
              <div class="form-group">
                <label for="name">Imię:</label>
                <input type="text" id="name" name="edt_username" value="<?php echo $userName; ?>" class="form-control" placeholder="Write your name" required>
              </div>
              <div class="form-group">
                <label for="surname">Nazwisko:</label>
                <input type="text" id="surname" name="edt_usersurname" value="<?php echo $userSurname; ?>" class="form-control" placeholder="Write your surname" required>
              </div>
              <div class="form-group">
                <label for="address">Adres:</label>
                <input type="text" id="address" name="edt_address" value="<?php echo $userAddress; ?>" class="form-control" placeholder="Write your address" required>
              </div>
              <div class="form-group">
                <label for="phone_nr">Telefon:</label>
                <input type="tel" id="phone_nr" name="edt_phonenumber" value="<?php echo $userPhone; ?>" class="form-control" placeholder="Write your phone number" required>
              </div>
              <div class="form-group">
                <input type="hidden" value="<?php echo $_GET['edt_id']?>" name="edt_user_id">
                <input type="submit" value="Zmień" name="edt_user" class="btn btn-primary">
              </div>
      </fieldset>
  </form>

  <?php   } else {  ?>

  <form class="col-lg-5 col-lg-offset-2" method="post">
      <fieldset>
          <legend>Dodaj nowy kontakt</legend>
              <div class="form-group">
                  <label for="name">Imię:</label>
                  <input type="text" id="name" name="username" class="form-control" placeholder="np. Adam" required>
              </div>
              <div class="form-group">
                  <label for="surname">Nazwisko:</label>
                  <input type="text" id="surname" name="usersurname" class="form-control" placeholder="np. Kowalski" required>
              </div>
              <div class="form-group">
                  <label for="address">Adres:</label>
                  <input type="text" id="address" name="address" class="form-control" placeholder="np. Wolności 11 Warszawa " required>
              </div>
              <div class="form-group">
                  <label for="phone_nr">Telefon:</label>
                  <input type="tel" id="phone_nr" name="phonenumber" class="form-control" placeholder="np. 333 222 111" required>
              </div>
              <div class="form-group">
                  <input type="submit" name="submit" class="btn btn-primary" value="Dodaj">
              </div>
      </fieldset>
  </form>

  <?php }   ?>

  </div>
  <br>

  <div class="row">
    <table class="table table-hover">
      <thead>
          <tr class="success">
              <th>ID</th>
              <th>Imię</th>
              <th>Nazwisko</th>
              <th>Adres</th>
              <th>Telefon</th>
              <th></th>
              <th></th>
          </tr>
      </thead>
      <tbody>

  <?php
      if(isset($_POST['key'])) {
          $key = $_POST['key'];
          $sql = "SELECT * FROM person WHERE name='$key' OR surname='$key' OR phone = '$key' OR address LIKE '%$key%'";
          $run = mysqli_query($con, $sql);

        while($rows = mysqli_fetch_assoc($run)) {
            $findName = $rows['name'];
            $findSurname = $rows['surname'];
            $findAddress = $rows['address'];
            $findPhone = $rows['phone'];

            echo "<tr>
                      <td>$rows[id]</td>
                      <td>$rows[name]</td>
                      <td>$rows[surname]</td>
                      <td>$rows[address]</td>
                      <td>$rows[phone]</td>
                      <td><a href='index.php?edt_id=$rows[id]' class='btn btn-success'>Edytuj</a></td>
                      <td><a href='index.php?del_id=$rows[id]' class='btn btn-danger'>Usuń</a></td>
                    </tr>";
        }

      } else if (isset($_GET['byName'])) {
            $sql = "SELECT * FROM person ORDER BY name";
            $run = mysqli_query($con, $sql);

          while($rows = mysqli_fetch_assoc($run)) {
              echo "<tr>
                      <td>$rows[id]</td>
                      <td>$rows[name]</td>
                      <td>$rows[surname]</td>
                      <td>$rows[address]</td>
                      <td>$rows[phone]</td>
                      <td><a href='index.php?edt_id=$rows[id]' class='btn btn-success'>Edytuj</a></td>
                      <td><a href='index.php?del_id=$rows[id]' class='btn btn-danger'>Usuń</a></td>
                    </tr>";
          }

      } else if (isset($_GET['bySurname'])) {
            $sql = "SELECT * FROM person ORDER BY surname";
            $run = mysqli_query($con, $sql);

          while($rows = mysqli_fetch_assoc($run)) {
              echo "<tr>
                      <td>$rows[id]</td>
                      <td>$rows[name]</td>
                      <td>$rows[surname]</td>
                      <td>$rows[address]</td>
                      <td>$rows[phone]</td>
                      <td><a href='index.php?edt_id=$rows[id]' class='btn btn-success'>Edytuj</a></td>
                      <td><a href='index.php?del_id=$rows[id]' class='btn btn-danger'>Usuń</a></td>
                    </tr>";
          }
       } else {
            $sql ="SELECT * FROM person";
            $run = mysqli_query($con, $sql);

          while($rows = mysqli_fetch_assoc($run)) {
              echo "<tr>
                      <td>$rows[id]</td>
                      <td>$rows[name]</td>
                      <td>$rows[surname]</td>
                      <td>$rows[address]</td>
                      <td>$rows[phone]</td>
                      <td><a href='index.php?edt_id=$rows[id]' class='btn btn-success'>Edytuj</a></td>
                      <td><a href='index.php?del_id=$rows[id]' class='btn btn-danger'>Usuń</a></td>
                    </tr>";
            }
      }
  ?>

      </tbody>
    </table>
  </div>
  <br>

  <div class="row">
    <a href='index.php?byName' class="btn btn-success">Sortuj wg imion</a>
    <a href='index.php?bySurname' class="btn btn-success">Sortuj wg nazwisk</a>
  </div>
  <br>
  <div class="row">
		<footer>
      <p>Public Project <span class="pull-right"><a href="#">Privacy</a> | <a href="#">ToS</a> | <a href="#">Contact</a></span></p>
		</footer>
	</div>


  </div>

</body>
</html>

<?php
//ADDING  NEW  USER
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])) {
      $userName = mysqli_real_escape_string($con, strip_tags($_POST['username']));
      $userSurname = mysqli_real_escape_string($con, strip_tags($_POST['usersurname']));
      $userAddress = mysqli_real_escape_string($con, strip_tags($_POST['address']));
      $userPhone = mysqli_real_escape_string($con, strip_tags($_POST['phonenumber']));

      $add_sql = "INSERT INTO person VALUES (NULL, '$userName', '$userSurname', '$userAddress', '$userPhone')";

    if(mysqli_query($con, $add_sql)) { ?>
      <script>window.location="index.php"</script>
  <?php
      }
    }
  }

//DELETING USER
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  if(isset($_GET['del_id'])){
    $del_sql = "DELETE FROM person WHERE id='$_GET[del_id]'";

  if(mysqli_query($con, $del_sql)) { ?>
    <script>window.location="index.php"</script>
  <?php
      }
    }
  }

//EDITING  USER
if($_SERVER['REQUEST_METHOD'] === 'POST'){
   if(isset($_POST['edt_user'])) {
     $edt_userName = mysqli_real_escape_string($con, strip_tags($_POST['edt_username']));
     $edt_userSurname = mysqli_real_escape_string($con, strip_tags($_POST['edt_usersurname']));
     $edt_userAddress = mysqli_real_escape_string($con, strip_tags($_POST['edt_address']));
     $edt_userPhone = mysqli_real_escape_string($con, strip_tags($_POST['edt_phonenumber']));

     $edt_sql = "UPDATE person SET name='$edt_userName', surname='$edt_userSurname', address='$edt_userAddress', phone='$edt_userPhone' WHERE id='$_POST[edt_user_id]'";

    if(mysqli_query($con, $edt_sql)) { ?>
       <script>window.location="index.php"</script>
  <?php
      }
    }
  }
  ?>
