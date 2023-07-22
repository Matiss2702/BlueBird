<?php

namespace App\Models;

use App\Core\Model;
use App\Models\User;

class UserRole extends Model
{
    protected static $table = DB_PREFIX . 'user_role';
    protected static $fillable = ['id_user', 'id_role'];

    protected $id;

    protected $id_user;
    protected $id_role;

    public function getId()
    {
        return $this->id;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getIdRole()
    {
        return $this->id_role;
    }

    public function setIdRole($id_role)
    {
        $this->id_role = $id_role;
    }

    public static function addUserRoleSetup($user)
    {
        if (!$user) {
            return;
        }

        $AURS = self::where('id_user', $user->getId());

        die(var_dump($user));
        if($AURS){
            $AURS->setIdRole(1);
            $AURS->setIdUser($user);
        }
    }
}
