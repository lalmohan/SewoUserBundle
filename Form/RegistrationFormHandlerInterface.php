<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sewolabs\UserBundle\Form;

use Sewolabs\UserBundle\OAuth\Response\UserResponseInterface;

use Symfony\Component\Form\Form,
    Symfony\Component\HttpFoundation\Request;

/**
 * FormHandlerInterface
 *
 * Interface for objects that are able to handle a form.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
interface RegistrationFormHandlerInterface
{
    /**
     * Processes the form for a given request.
     *
     * @param Request $request Active request
     * @param Form    $form    Form to process
     *
     * @return boolean True if the processing was successful
     */
    function process(Request $request, Form $form, UserResponseInterface $userInformation);
}
