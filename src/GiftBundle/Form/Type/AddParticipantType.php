<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/01/16
 * Time: 20:08
 */

namespace GiftBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresseEmail', 'text',array('label' => 'Adresse Email',
                                                'attr' => array('class' => 'form-control')))
            ->add('message', 'textarea',array('label' => 'Message',
                'attr' => array('class' => 'form-control')))
            ->add('save', 'submit', array('label' => 'Inviter',
                'attr' => array('class' => 'btn btn-default btn-raised')));
    }

    public function getName()
    {
        return 'giftbundle_form_add_participant';
    }

}