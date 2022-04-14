<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'userName';

    protected $allowedFields = ['firstName, lastName, mail, password, userName'];

    public function getUser($userName = false)
    {
        if ($userName === false) {
            return $this->findAll();
        }

        return $this->where(['userName' => $userName])->first();
    }
}

?>