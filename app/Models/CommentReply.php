<?php

namespace App\Models;

use App\Core\Model;

class CommentReply extends Model
{
    protected static $table = DB_PREFIX . 'comment_reply';
    protected static $fillable = ['id_comment', 'id_user', 'content', 'id_status', 'created_at', 'updated_at'];

    protected $id;
    protected $id_comment;
    protected $id_user;
    protected $content;
    protected $id_status;
    protected $created_at;
    protected $updated_at;

    private $username = '';

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdComment()
    {
        return $this->id_comment;
    }

    public function setIdComment($id_comment)
    {
        $this->id_comment = $id_comment;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getIdStatus() {
        return $this->id_status;
    }

    public function setIdStatus($id_status) {
        $this->id_status = $id_status;
    }
}
