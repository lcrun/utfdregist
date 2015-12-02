<?php
namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends BaseType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('username');
        $builder->add('name', null, array('label' => '姓名', 'translation_domain' => 'FOSUserBundle'))
                ->add('company', null, array('label' => '学校', 'translation_domain' => 'FOSUserBundle','required'=>true))
                ->add('address', null, array('label' => '部门', 'translation_domain' => 'FOSUserBundle','required'=>true,'attr'=>array('placeHolder' => '如:数学系或者教务处')))
                 
                 ->add('job', null, array('label' => '职务', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                 ->add('position', null, array('label' => '职称', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                
                ->add('gender', 'choice',array('label' => '性别', 
                    'choices' => array('男' => '男', '女' => '女'),
                    'expanded' => true ))
                ->add('phone', null, array('label' => '手机', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                ->add('telephone', null, array('label' => '固话', 'translation_domain' => 'FOSUserBundle','required'=>true,'attr'=>array('placeHolder' => '请留下您的办工电话')))
                
                
                ->add('needHotel', 'choice',array('label' => '住宿', 
                    'choices' => array('需要住宿' => '需要住宿', '不需要住宿' => '不需要住宿'),
                    'expanded' => true ,'required'=>false))  
                
                 ->add('liveinDate', 'date', array('label' => '入住时间：','required'=>false))  
                ->add('leaveDate', 'date', array('label' => '离开时间：','required'=>false))  
                
                 ->add('isSingle', 'choice',array('label' => '单人房间', 
                    'choices' => array('需要单间' => '需要单间', '不需要单间' => '不需要单间'),
                    'expanded' => true ,'required'=>false))  
                 ->add('moreForHotel', 'textarea', array('label' => '备注','required'=>false))    
                
                
            ;
               
        
    }
    public function getName()
    {
       
    return 'acme_user_registration';

    }
}