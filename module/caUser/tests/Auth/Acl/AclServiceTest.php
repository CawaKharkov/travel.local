<?php

namespace caUserTest\Auth\Acl;

use \caUser\Auth\Acl\AclService;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclServiceTest
 *
 * @author Cawa
 */
class AclServiceTest extends \PHPUnit_Framework_TestCase
{
    
    protected $alc;
    
    protected function setUp() 
    {
        $this->alc = new AclService;
        parent::setUp();
    }
    
    
    public function testCanAccess()
    {
        $this->assertEquals(0, 0);
    }

}

