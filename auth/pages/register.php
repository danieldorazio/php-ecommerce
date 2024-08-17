<?php

$errorMsg = "";

// controllo se l'utente è gia loggato cosi da non poter rientrare inutilmente nella pagina di register
if ($loggedInUser) {
    echo '<script>location.href="' . ROOT_URL . 'public"</script>';
    exit;
}

// logica di register che controlla l'esistenza dai valori inseriti all'interno del form 
if (isset($_POST['register'])) {

    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    $userMgr =  new UserManager();
    if ($userMgr->passwordsMatch($password, $confirm_password)) {

        $result = $userMgr->register($email, $password);

        if ($result) {
            echo '<script>location.href="' . ROOT_URL . 'auth?page=login"</script>';
            exit;
        } else {
            $errorMsg = "Email già registrata...";
        }
    } else {
        $errorMsg = "Le password non corrispondono...";
    }
}

?>

<h2>Registrazione</h2>

<form method="post">

    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" id="email" type="text" class="form-control">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" id="password" type="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="confirm_password">Conferma Password</label>
        <input name="confirm_password" id="confirm_password" type="password" class="form-control">
    </div>

    <div class="text-danger">
        <?php echo $errorMsg ?>
    </div>

    <button class="btn btn-primary" type="submit" name="register">Register</button>
</form>

Hai gia un account?<a href="<?php echo ROOT_URL ?>auth?page=login">Effettua il login &raquo;</a>