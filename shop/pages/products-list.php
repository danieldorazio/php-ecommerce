<?php

//CONTROLLI 
//controllo che si faccia l'accesso a questo file passando da index.php e no direttamente dall'url quindi che si sia creata la costante ROOT_URL poichè nel file index viene incluso il file init
if (!defined('ROOT_URL')) {
    die;
}

//controlli

$productMgr = new ProductManager();
$products = $productMgr->getAll();
// var_dump($products);

?>

<div class="row">
    <?php if ($products) : ?>
        <?php foreach ($products as $product) : ?>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product->name ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $product->price ?></h6>
                    <p class="card-text"><?php echo $product->description ?></p>
                    <a href="<?php echo ROOT_UTL . 'shop?page=view-product&id=' . $product->id ?>" class="card-link">Vedi &raquo;</a>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else :?>
            <p>Nessum Prodotto disponibile...</p>
    <?php endif; ?>
</div>