<?php
$cm = new CartManager();
$cartId = $cm->getCurrentCartId();
$cart_total = $cm->getCartTotal($cartId);
var_dump($cart_total['num_products']);

?>


<footer class="bg-dark">
    <hr>
    <p class="container text-light">Copyright &copy; 2024</p>
</footer>

<script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://bootswatch.com/_vendor/prismjs/prism.js"></script>

<script src="<?php echo ROOT_URL; ?>/assets/js/main.js"></script>

<!-- manipolazione del DOM per mandare il dato aggiornato del numero di elementi presenti nel carrello nell'header, si mette nel footer perchè deve essere aggiornato per ultimo -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.js-totCartItems').innerHTML = '<?php echo $cart_total['num_products']; ?>';
    });
</script>
</body>

</html>