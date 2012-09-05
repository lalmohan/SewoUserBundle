<?php

namespace Sewolabs\UserBundle\OAuth\Response;

use HWI\Bundle\OAuthBundle\OAuth\Response\AdvancedPathUserResponse;


/**
 * FacebookUserResponse
 *
 */
class FacebookUserResponse extends AdvancedPathUserResponse
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