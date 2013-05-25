<?php
/**
 * namespace
 */
namespace caUser\Entity\Base;

use caUser\Entity\Base\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

class EntityDefault extends EntityBase
{
    protected $protectedProperties = ['created'];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    public function __construct($data = null)
    {
        $this->created = new DateTime('now', new \DateTimeZone('UTC'));
        return parent::__construct($data);

    }
}