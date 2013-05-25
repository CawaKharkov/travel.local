<?php
/**
 * namespace
 */
namespace caUser\Entity;
use Doctrine\ORM\EntityRepository as Repository;


/**
 * Class CauserRepository
 * @package caUser\Repository
 */
class CauserRepository extends Repository
{
    /**
     * Save User
     * @param \caUser\Entity\Base\EntityDefault|\caUser\Entity\User $user
     * @return User
     */
    public function save(\caUser\Entity\Base\EntityDefault $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
        return $user;
    }

    /**
     * Delete User
     * @param \caUser\Entity\Base\EntityDefault|\caUser\Entity\User $user
     */
    public function delete(\caUser\Entity\Base\EntityDefault $user)
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}