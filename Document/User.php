<?php
// src/Acme/UserBundle/Entity/User.php

namespace Sewolabs\UserBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $facebookId;

    /**
     * @MongoDB\String
     */
    protected $googleId;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

	/**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

	/**
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

	 /**
     * Sets the facebookId.
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }
	 /**
     * Sets the googleId.
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }
	
}