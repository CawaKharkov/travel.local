<?php
/**
 * namespace
 */
namespace Application\Entity\User;

use caUser\Entity\Base\EntityDefault as Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Application\Entity\User
 * @ORM\Entity(repositoryClass="Application\Entity\User\UserRepository")
 * @ORM\Table(name="user", options={"collate"="utf8_general_ci"})
 */
class User extends Base
{

}