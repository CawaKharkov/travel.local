<?php
/**
 * namespace
 */
namespace caUser\Framework;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnitityBase for inheriting
 */
use caUser\Framework\Exception\InvalidEntityBaseException;

Class EntityBase
{
    /**
     * Construct function
     * Check data on massive and check protected properties if it describe, and set properties
     *
     * @param null $data
     * #return $this
     */
    public function __construct($data = null)
    {
        if (is_array($data))
        {
            foreach($data as $key => $val)
            {
                if (property_exists($this, $key))
                {
                    try {

                        $this->checkProtectAndSet($key, $val);

                    } catch(InvalidEntityBaseException $e) {

                        echo $e->getMessage();
                    }
                }

            }

        } else {

        }
        //return $this;

    }

    /**
     * Magic function for add settler and getter to
     * custom entity
     *
     * @param $name
     * @param $arg
     * @return $this->$property
     * @return $this
     */
    public function __call($name, $arg)
    {
        $pattern = strtolower(substr($name, 0, 3));
        if ($pattern == "get")
        {
            $property = substr($name, 3, strlen($name));
            if ( property_exists($this, lcfirst($property)) )
            {
                $property = lcfirst($property);
                return $this->$property;
            }
        }

        if ($pattern == "set")
        {
            $property = substr($name, 3, strlen($name));
            if ( property_exists($this, lcfirst($property)) )
            {
                $arg = array_shift($arg);
                if (!is_null($arg))
                {

                    $property = lcfirst($property);
                    try {

                        $this->checkProtectAndSet($property, $arg);

                    } catch(InvalidEntityBaseException $e) {

                        echo $e->getMessage();
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Function for check protected properties and set it
     *
     * @param $property
     * @return bool
     */
    public function checkProtectAndSet($property , $val)
    {
        if(property_exists($this, 'protectedProperties'))
        {
            if(in_array($property, $this->protectedProperties))
            {
                throw new InvalidEntityBaseException("Invalid argument (" . $property .  "); ");
            } else {
                $this->$property = $val;
            }
        }
    }
}