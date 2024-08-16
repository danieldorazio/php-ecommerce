<?php

class CartManager extends DBManager
{

    private $clientId;

    public function __construct()
    {
        parent::__construct();
        $this->columns = array('id', 'client_id');
        $this->tableName = 'cart';

        $this->_initializeClientIdFromSession();
    }

    // Public Methods 
    // preleva il carrello dell'utente id, se non esiste nel db lo crea
    public function getCurrentCartId()
    {
        $cartId = 0;

        $result = $this->db->query("SELECT * FROM cart WHERE client_id = '$this->clientId'");
        if (count($result) > 0) {
            $cartId = $result[0]['id'];
        } else {
            $cartId = $this->create([
                'client_id' => $this->clientId
            ]);
        }
        return $cartId;
    }
    // preleva il numero di oggetti che compone il carrello dell'utente id e il totale del prezzo
    public function getCartTotal($cartId)
    {
        $result = $this->db->query("
        SELECT SUM(quantity) AS num_products, SUM(quantity* price) AS total
        FROM cart_item 
        INNER JOIN product
            ON cart_item.product_id = product.id
        WHERE cart_id = $cartId
        ");
        return $result[0];
    }

    // preleva il le informazione degli oggetti che compone il carrello dell'utente id e il totale del prezzo per ogni tipologia di oggetto 
    public function getCartItems($cartId)
    {
        return $this->db->query("
        SELECT  product.name AS name,
            product.description AS description,
            product.price AS single_price,
            cart_item.quantity AS quantity,
            product.price * cart_item.quantity AS total_price,
            product.id AS id
        FROM cart_item
        INNER JOIN product
           ON cart_item.product_id = product.id
        WHERE cart_item.cart_id = $cartId
        ");
    }

    //aggiunge un prodotto specifico al carrello 
    public function addTocart($productId, $cartId)
    {
        $quantity = 0;
        $result = $this->db->query("SELECT quantity FROM cart_item WHERE cart_id = $cartId AND product_id = $productId");
        if (count($result) > 0) {
            $quantity = $result[0]['quantity'];
        }
        $quantity++;

        if (count($result) > 0) {
            $this->db->execute("UPDATE cart_item SET quantity = $quantity WHERE cart_id = $cartId AND product_id = $productId");
        } else {
            $cartItemMgr = new CartItemManager();
            $newId = $cartItemMgr->create([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }
    }


    //rimuove un prodotto specifico al carrello 
    public function removeFromcart($productId, $cartId)
    {
        $quantity = 0;
        $result = $this->db->query("SELECT quantity, id FROM cart_item WHERE cart_id = $cartId AND product_id = $productId");
        $cartItemId = $result[0]['id'];
        if (count($result) > 0) {
            $quantity = $result[0]['quantity'];
        }
        $quantity--;

        if ($quantity > 0) {
            $this->db->execute("UPDATE cart_item SET quantity = $quantity WHERE cart_id = $cartId AND product_id = $productId");
        } else {
            $cartItemMgr = new CartItemManager();
            $cartItemMgr->delete($cartItemId);
        }
    }

    // Private methods
    private function _initializeClientIdFromSession()
    {
        // preleva la super variabile SESSION e verifica se all'interno esiste client_id
        if (isset($_SESSION['client_id'])) {
            $this->clientId = $_SESSION['client_id'];
        } else {
            // genera una stringa casuale
            $str = substr(md5(mt_rand()), 0, 20);
            // settare clientId con questa stringa
            $_SESSION['client_id'] = $str;
            $this->clientId = $str;
        }
    }
}

class CartItemManager extends DBManager
{
    public function __construct()
    {
        parent::__construct();
        $this->columns = array('id', 'cart_id', 'product_id', 'quantity');
        $this->tableName = 'cart_item';
    }
}
