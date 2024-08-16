<?php

$errorMsg = "";

// controllo se l'utente è gia loggato cosi da non poter rientrare inutilmente nella pagina di login
if ($loggedInUser) {
    echo '<script>location.href="' . ROOT_URL . 'public"</script>';
    exit;
}

// logica di login che controlla l'esistenza dai valori inseriti all'interno del form 
if (isset($_POST['login'])) {

    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $userMgr =  new UserManager();
    $result = $userMgr->login($email, $password);

    if ($result) {
        echo '<script>location.href="' . ROOT_URL . 'public"</script>';
        exit;
    } else {
        $errorMsg = "Login Fallito...";
    }
}

?>

<form method="post">

    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" id="email" type="text" class="form-control">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" id="password" type="password" class="form-control">
    </div>

    <div class="text-danger">
        <?php echo $errorMsg ?>
    </div>

    <button class="btn btn-primary" type="submit" name="login">Login</button>
</form>