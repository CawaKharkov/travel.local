<?php
/**
 * namespace
 */
namespace caUser\Framework;

use caUser\Framework\EntityBase;
use Doctrine\ORM\Mapping as ORM;

class EntityDefault extends EntityBase
{
    protected $protectedProperties = ['id'];

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    public $password;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    public $username;
}