<?php

class UserManager extends DBManager
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'user';
        $this->columns = ['id', 'email', 'password', 'user_type_id'];
    }

    // Public Methods 
    // chiamata GET per verificare se le credenziali siano corrette 
    public function login($email, $password)
    {
        $result = $this->db->query("
            SELECT *
            FROM user 
            WHERE email = '$email'
            AND password = MD5('$password');
        ");

        if (count($result) > 0) {
            $user = (object) $result[0];
            // _setUser è una Private Methods
            $this->_setUser($user);
            return true;
        }

        return false;
    }

    // Private Methods
    // funzione che setta i valori prelevati e condivide nella sessione 
    private function _setUser($user)
    {
        $userToStore = (object) [
            'id' => $user->id,
            'email' => $user->email,
            'is_admin' => $user->user_type_id == 1
        ];
        $_SESSION['user'] = $userToStore;
    }
}
