<?php

namespace AV\ListeVoeuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\UserBundle\Util\LegacyFormHelper;

class AgentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('nom')
			->add('prenom')
			->add('grade')
			// POur avoir le champs avec un menu déroulant :
			//~ ->add('grade', ChoiceType::class, array(
				//~ 'choices' => array(
				//~ 'Inspecteur' => 'Inspecteur',	
				//~ 'Contrôleur' => 'Contrôleur',
				//~ )))
			->add('domicile', TextType::class, array(
				'mapped' => false,
				))
			//~ ->add('username',TextType::class)
			//~ ->add('email',EmailType::class)
			//~ ->add('password',PasswordType::class)
			->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
				'label' => 'form.email', 
				'translation_domain' => 'FOSUserBundle',
				'csrf_token_id' => 'registration'))
            ->add('username', null, array(
				'label' => 'form.username', 
				'translation_domain' => 'FOSUserBundle',
				'csrf_token_id' => 'registration'))
            ->add('password', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
                'csrf_token_id' => 'registration'
            ))
			->add('submit',SubmitType::class);
		

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AV\ListeVoeuBundle\Entity\Agent'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'av_listevoeubundle_agent';
    }


}
