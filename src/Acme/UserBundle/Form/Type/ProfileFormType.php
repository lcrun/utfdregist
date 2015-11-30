<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\UserBundle\Form\Type;


use  FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;


class ProfileFormType extends BaseType
{
   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildUserForm($builder, $options);
          $builder->add('name', null, array('label' => '姓名', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                  ->add('company', null, array('label' => '学校', 'translation_domain' => 'FOSUserBundle','required'=>true))
                
                  ->add('job', null, array('label' => '职务', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                ->add('position', null, array('label' => '职称', 'translation_domain' => 'FOSUserBundle','required'=>true))
                ->add('gender', 'choice',array('label' => '性别', 
                    'choices' => array('男' => '男', '女' => '女'),
                    'expanded' => true ))
                ->add('phone', null, array('label' => '手机', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                  ->add('telephone', null, array('label' => '固话', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                ->add('address', null, array('label' => '部门', 'translation_domain' => 'FOSUserBundle','required'=>true))
                
                
                                ->add('needHotel', 'choice',array('label' => '住宿', 
                    'choices' => array('需要' => '需要', '不需要' => '不需要'),
                    'expanded' => true ))
                
                 ->add('liveinDate', 'date', array('label' => '入住时间：',))
                ->add('leaveDate', 'date', array('label' => '离开时间：',))
                
                 ->add('isSingle', 'choice',array('label' => '单人房间', 
                    'choices' => array('需要' => '需要', '不需要' => '不需要'),
                    'expanded' => true ))
                 ->add('moreForHotel', 'textarea', array('label' => '备注'))    
                
                
                
                
                
                
                
                ;

        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));
    }

    
    public function getName()
    {
        return 'acme_user_profile';
    }

   
}
