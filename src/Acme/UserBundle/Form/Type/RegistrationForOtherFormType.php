<?php
namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



use Symfony\Component\OptionsResolver\OptionsResolver;


class RegistrationForOtherFormType  extends AbstractType 
//extends BaseType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       // parent::buildForm($builder, $options);
   
        $builder  ->add('email', 'email', array('label' => '邮箱', 'translation_domain' => 'FOSUserBundle'))
                
                
                ->add('name', null, array('label' => '姓名', 'translation_domain' => 'FOSUserBundle'))
              //  ->add('company', null, array('label' => '学校', 'translation_domain' => 'FOSUserBundle','required'=>true))
                
                 ->add('company', 'choice', 
                    array('label' => '学校',  
                        'choices' => array(           
                            "中国科学技术大学" =>"中国科学技术大学",
                            "合肥工业大学" =>"合肥工业大学",
                            "安徽大学" =>"安徽大学",
                            "安徽农业大学" =>"安徽农业大学",
                            "安徽医科大学" =>"安徽医科大学",
                            "安徽师范大学" =>"安徽师范大学",
                            "安徽建筑大学" =>"安徽建筑大学",
                            "安徽中医药大学" =>"安徽中医药大学",
                            "陆军军官学院" =>"陆军军官学院",
                            "合肥学院" =>"合肥学院",
                            "安徽理工大学" =>"安徽理工大学",
                            "安徽工业大学" =>"安徽工业大学",
                            "安徽工程大学" =>"安徽工程大学",
                            "淮北师范大学" =>"淮北师范大学",
                            "安徽财经大学" =>"安徽财经大学",
                            "皖南医学院" =>"皖南医学院",
                            "蚌埠医学院" =>"蚌埠医学院",
                            "淮南师范学院" =>"淮南师范学院",
                            "安徽科技学院" =>"安徽科技学院",
                            "阜阳师范学院" =>"阜阳师范学院",
                            "安庆师范学院" =>"安庆师范学院",
                            "合肥师范学院" =>"合肥师范学院",
                            "滁州学院" =>"滁州学院",
                            "池州学院" =>"池州学院",
                            "皖西学院" =>"皖西学院",
                            "宿州学院" =>"宿州学院",
                            "黄山学院" =>"黄山学院",
                            "巢湖学院" =>"巢湖学院",
                            "蚌埠学院" =>"蚌埠学院",
                            "铜陵学院" =>"铜陵学院"
                        ),
                        'placeholder' => '请选择'
                    ))
                
                
                
                ->add('address', null, array('label' => '部门', 'translation_domain' => 'FOSUserBundle','required'=>true,'attr'=>array('placeHolder' => '如:数学系或者教务处')))
                 
                 ->add('job', null, array('label' => '职务', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                 ->add('position', null, array('label' => '职称', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                
           //     ->add('gender', 'choice',array('label' => '性别', 
            //        'choices' => array(),
            //        'expanded' => true ))
                
                                ->add('gender', 'choice', 
                    array('label' => '性别',  
                        'choices' => array(           
                           '男' => '男', '女' => '女'
                        ),
                        'placeholder' => '请选择'
                    ))
                
                
                ->add('phone', null, array('label' => '手机', 'translation_domain' => 'FOSUserBundle','required'=>true))    
                ->add('telephone', null, array('label' => '固话', 'translation_domain' => 'FOSUserBundle','required'=>true,'attr'=>array('placeHolder' => '请留下您的办工电话')))
                
                
          //      ->add('needHotel', 'choice',array('label' => '住宿', 
          //          'choices' => array('需要住宿' => '需要住宿', '不需要住宿' => '不需要住宿'),
            //        'expanded' => true ,'required'=>false,
          //      'empty_value' => false))  
                
                
                          ->add('needHotel', 'choice', 
                    array('label' => '住宿',  
                        'choices' => array(           
                           '需要住宿' => '需要住宿', '不需要住宿' => '不需要住宿'
                        ),
                        'placeholder' => '请选择'
                    ))
                
                
                 ->add('liveinDate', 'date', array('label' => '入住时间：','required'=>false))  
                ->add('leaveDate', 'date', array('label' => '离开时间：','required'=>false))  
                
          //       ->add('isSingle', 'choice',array('label' => '单人房间', 
         //           'choices' => array('需要单间' => '需要单间', '不需要单间' => '不需要单间'),
         //           'expanded' => true ,'required'=>false,
           //     'empty_value' => false))  
                
                       ->add('isSingle', 'choice', 
                    array('label' => '单人房间',  
                        'choices' => array(           
                           '需要单间' => '需要单间', '不需要单间' => '不需要单间'
                        ),
                        'placeholder' => '请选择'
                    ))
                
                
                 ->add('moreForHotel', 'textarea', array('label' => '备注','required'=>false))    

            ;
               
        
    }
    public function getName()
    {
       
    return 'acme_user_registrationForOther';

    }
    
    
      public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\DemoBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'user_item',
        ));
    }

   
}