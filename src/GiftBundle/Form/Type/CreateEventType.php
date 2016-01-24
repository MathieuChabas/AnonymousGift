<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 13/01/16
 * Time: 16:54
 */

namespace GiftBundle\Form\Type;
use GiftBundle\Entity\UserEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CreateEventType extends AbstractType
{

    public function __construct()
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startdate','datetime',array('label' => 'Date de début',
                                                'widget' => 'single_text'))
            ->add('name','text',array('label' => 'Nom de l\'événement',
                                       'attr' => array('class' => 'form-control')))
            ->add('save', 'submit', array('label' => 'Créer',
                                            'attr' => array('class' => 'btn btn-default btn-raised'),));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $formEvent) {

        });
    }

    public function getName()
    {
        return 'giftbundle_form_event';
    }

}