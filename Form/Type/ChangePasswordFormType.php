<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sewolabs\UserBundle\Form\Type;

use Symfony\Component\Security\Core\Validator\Constraint\UserPassword;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('new', 'repeated', array(
            'type' => 'password',
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'form.new_password'),
            'second_options' => array('label' => 'form.new_password_confirmation'),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FOS\UserBundle\Form\Model\ChangePassword',
            'intention'  => 'change_password',
        ));
    }

    public function getName()
    {
        return 'sewolabs_user_change_password';
    }
}
