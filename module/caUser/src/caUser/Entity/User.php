<?php
/**
 * namespace
 */
namespace caUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use caUser\Framework\EntityDefault as Entity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
}