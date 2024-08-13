<?php 

class CartManager extends DBManager{
    
    private $clientId;

    public function __construct(){
        parent::__construct();
        $this->columns = array('id' , 'client_id');
        $this->tableName = 'cart';

        $this->_initializeClientIdFromSession(); 
    }

    // Public Methods 
    // preleva il carrello dell'utente id, se non esiste nel db lo crea
    public function getCurrentCartId() {
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

    public function addTocart($productId, $cartId) {
        $quantity = 0;
        $result = $this->db->query("SELECT quantity FROM cart_item WHERE cart_id = $cartId AND product_id = $productId");
        if (count($result) > 0) {
            $quantity = $result[0]['quantity'];
        }
        $quantity++;

        if (count($result) > 0) {
            $this->db->query("UPDATE cart_item SET quantity = $quantity WHERE cart_id = $cartId AND product_id = $productId");
        } else {
            $cartItemMgr = new CartItemManager();
            $newId = $cartItemMgr->create([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        
    }
    
    // Private methods
    private function _initializeClientIdFromSession() {
        // preleva la super variabile SESSION e verifica se all'interno esiste client_id
        if(isset($_SESSION['client_id'])) {
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

class CartItemManager extends DBManager {
    public function __construct()
    {
        parent::__construct();
        $this->columns = array('id' , 'cart_id', 'product_id', 'quantity');
        $this->tableName = 'cart_item';
    }

}

?>