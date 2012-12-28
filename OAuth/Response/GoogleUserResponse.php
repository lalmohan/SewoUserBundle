<?php

namespace Sewolabs\UserBundle\OAuth\Response;

use HWI\Bundle\OAuthBundle\OAuth\Response\AdvancedPathUserResponse;


/**
 * GoogleUserResponse
 *
 */
class GoogleUserResponse extends AdvancedPathUserResponse
{
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getValueForPath('email', false);
    }

    /**
     * {@inheritdoc}
     */
    public function getProfilePicture()
    {
        return $this->getValueForPath('profilepicture', false);
    }
}