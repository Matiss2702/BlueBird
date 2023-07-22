<?php

namespace App\Models;

use App\Core\Model;

class Menu extends Model
{
    protected static $table = DB_PREFIX . 'menu';
    protected static $fillable = [
        'title',
        'slug',
        'orders',
        'id_parent',
        'zone',
        'status'
    ];

    protected $id;

    protected $title;
    protected $slug;
    protected $orders;
    protected $id_parent;
    protected $zone;
    protected $status;
    protected $created_at;
    protected $updated_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param String $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return String
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param String $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getOrders(): int
    {
        return $this->orders;
    }

    /**
     * @param int $orders
     */
    public function setOrders(int $orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @return String
     */
    public function getParent(): String
    {
        return $this->id_parent;
    }

    /**
     * @param String $id_parent
     */
    public function setParent(String $id_parent): void
    {
        $this->id_parent = $id_parent;
    }

    /**
     * @return int
     */
    public function getZone(): int
    {
        return $this->zone;
    }

    /**
     * @param int $zone
     */
    public function setZone(int $zone): void
    {
        $this->zone = $zone;
    }


    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
