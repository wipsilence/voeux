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

class AgentEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('nom')
			->add('prenom')
			//Pour avoir le champs avec un menu déroulant :
			->add('grade')
			->add('domicile', TextType::class, array(
				'mapped' => false,
				))
			->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
				'label' => 'form.email', 
				'translation_domain' => 'FOSUserBundle',
				'csrf_token_id' => 'registration'))
            ->add('username', null, array(
				'label' => 'form.username', 
				'translation_domain' => 'FOSUserBundle',
				'csrf_token_id' => 'registration'))
            ->add('qualification',EntityType::class, array(
					'class' => 'AV\ListeVoeuBundle\Entity\Qualification',
					'multiple' => 'true',
					'expanded' => 'true',
					'choice_label' => 'nom',
					)
				)
			->add('roles', ChoiceType::class,  array( 
					'label' => 'Rôles',
					'choices' => array(
						'agent' => 'ROLE_USER', 
						'administrateur' => 'ROLE_ADMIN'
						),
					'multiple'  => true,
					'expanded' => true,
					)
				)
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
