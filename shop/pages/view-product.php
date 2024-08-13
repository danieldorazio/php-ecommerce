<?php
//CONTROLLI {
//controllo che si faccia l'accesso a questo file passando da index.php e no direttamente dall'url quindi che si sia creata la costante ROOT_URL poichè nel file index viene incluso il file init
if (!defined('ROOT_URL')) {
    die;
}

//controllo della esistenza del valore id
if (!isset($_GET['id'])) {
    echo "<script>location.href='".ROOT_URL."';</script>";
    exit;
}

if (isset($_POST['add_to_cart'])) {

    $productId = htmlspecialchars(trim($_POST['id']));
    // addToCart Logic
    $cm = new CartManager();
    $cartId = $cm->getCurrentCartId();

    // aggiungi al carello "cartId" il prodotto productId
    $cm->addToCart($productId, $cartId);

    // stampare un messaggio per l'utente se l'inserimento è andato a buon fine
}

//sanificazione del campo in ingresso rende in stringa in contenuto, cosi da evitare l'esecuzione malevolo di codice per esempio <script>;
$id = htmlspecialchars(trim($_GET['id']));

//creazioone dell'oggetto prodotto dalla classe ProductManager che viene esteso da DBManager
$pm = new ProductManager();
$product = $pm->get($id);

//controllo l'esistenza del prodotto con id passato
if(!(property_exists($product, 'id'))) {
    echo "<script>location.href='".ROOT_URL."';</script>";
    exit;
}

//controlli }

?>

<div class="card m-5">
    <div class="card-body">
        <h5 class="card-title"><?php echo $product->name ?></h5>
        <p class="card-text"><?php echo $product->price ?></p>
        <p class="card-text"><?php echo $product->description ?></p>
        <form method="post">
            <input name="id" type="hidden" value="<?php echo $product->id ?>">
            <input name="add_to_cart" type="submit" class="btn btn-primary right" value="Aggiungi al carello">
        </form>
    </div>
</div>
