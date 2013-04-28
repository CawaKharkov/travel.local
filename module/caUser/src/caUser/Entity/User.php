<?php
/**
 * namespace
 */
namespace caUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use caUser\Framework\EntityDefault as Entity;

/**
 * @ORM\Entity(repositoryClass="\caUser\Repository\UserRepository")
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


}