<?php

$cm = new CartManager();
$cartId = $cm->getCurrentCartId();


if (isset($_POST['minus'])) {
    // sanificare le informazioni passanti dal form
    $productId = htmlspecialchars(trim($_POST['id']));
    $cm->removeFromcart($productId, $cartId);
}

if (isset($_POST['plus'])) {
    // sanificare le informazioni passanti dal form
    $productId = htmlspecialchars(trim($_POST['id']));
    $cm->addTocart($productId, $cartId);
}

$cart_total = $cm->getCartTotal($cartId);
$cart_items = $cm->getCartItems($cartId);

?>



<div class="col-12 order-md-last mt-4">
    <?php if (count($cart_items) > 0): ?>
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Carrello</span>
            <span class="badge bg-primary rounded-pill text-white"><?php echo $cart_total['num_products'] ?> elementi nel carrello</span>
        </h4>



        <ul class="list-group mb-3">

            <?php foreach ($cart_items as $item): ?>

                <li class="list-group-item d-flex justify-content-between lh-sm p-4">
                    <div class="row w-100">

                        <div class="col-lg-4 col-6">
                            <h6 class="my-0"><?php echo $item['name'] ?></h6>
                            <small class="text-muted"><?php echo $item['description'] ?></small>
                        </div>

                        <div class="col-lg-2 col-6">
                            <span class="text-muted">&euro; <?php echo $item['single_price'] ?></span>
                        </div>

                        <div class="col-lg-4 col-6">
                            <form method="post">
                                <div class="cart-buttons btn-group " role="group">
                                    <button type="submit" name="minus" class="btn btn-sm btn-primary">-</button>
                                    <span class="text-muted"><?php echo $item['quantity'] ?></span>
                                    <button type="submit" name="plus" class="btn btn-sm btn-primary">+</button>
                                    <input type="hidden" name="id" value="<?php echo $item['id'] ?>" />
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-2 col-6">
                            <strong class="text-primary">&euro; <?php echo $item['total_price'] ?></strong>
                        </div>

                    </div>
                </li>
            <?php endforeach; ?>


            <li class="cart-total list-group-item d-flex justify-content-between p-4">
                <div class="row w-100">
                    <div class="col-lg-4 col-6">
                        <span class="">Totale</span>

                    </div>
                    <div class="col-lg-6 lg-screen"></div>
                    <div class="col-lg-2 col-6">
                        <strong>&euro; <?php echo $cart_total['total'] ?></strong>
                    </div>
                </div>
            </li>

        </ul>
        <hr>

        <button class="btn btn-primary btn-block">check-out</button>
    <?php else: ?>
        <p class="lead">Neassun elemento nel carrello...</p>
        <a href="<?php echo ROOT_URL ?>shop?page=products-list" class="btn btn-primary"> Torna a fare acquisti &raquo;</a>
    <?php endif; ?>
</div>