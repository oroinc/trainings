<?php

namespace Training\Bundle\UserNamingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Training\Bundle\UserNamingBundle\Entity\UserNamingIntegrationSettings;

class NamingTypeIntegrationSettingsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'url',
            TextType::class,
            [
                'label' => 'training.usernaming.integration.settings.url.label',
                'required' => true,
                'constraints' => [new NotBlank()],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserNamingIntegrationSettings::class,
        ]);
    }
}
