<?php
/**
 * namespace
 */
namespace caUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use caUser\Entity\Base\EntityDefault as Entity;

/**
 * @ORM\Entity(repositoryClass="caUser\Entity\CauserRepository")
 * @ORM\Table(name="causer", options={"collate"="utf8_general_ci"})
 */
class Causer extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


}