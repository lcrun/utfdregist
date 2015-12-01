<?php

namespace Acme\DemoBundle\Controller;





use Symfony\Component\HttpFoundation\StreamedResponse;
use Acme\DemoBundle\Entity\User;
//use TaSurvey\DefaultBundle\Form\ExamType;

use Acme\DemoBundle\Entity\SignUp;

use Acme\DemoBundle\Entity\Backend;

use Acme\UserBundle\Form\Type\RegistrationForOtherFormType;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

 class RegistrationForOtherController extends Controller
{
     
      private function getCurrentConference(){
        $backend = $this->getDoctrine()->getManager()
                ->getRepository('AcmeDemoBundle:Backend')->findOneBy(array());
        $conference = null;
        if($backend != null){
            $conference = $this->getDoctrine()->getManager()
                    ->getRepository('AcmeDemoBundle:Conference')->find($backend->getConferenceId());
        }
        return $conference;
    }
    
    public function registAction(Request $request)
    {
       //    $creator = $this->getUser();
      //  if (!is_object($creator) || !$creator instanceof UserInterface) {
      //      throw new AccessDeniedException('This user does not have access to this section.');
    //    } 
    
        $conference = $this->getCurrentConference();
        $now = new \DateTime();
        $errorTip = null;
        if($conference == null || $conference->getDueDate()<$now){
            $errorTip = "暂无可会议可报名！";
        }
        
    
        $userManager = $this->get('fos_user.user_manager');
     
        $user = $userManager->createUser();
        $user->setEnabled(true);


         $form = $this->createForm(new RegistrationForOtherFormType(),$user);
        
   
        $form->handleRequest($request);
        $user->setUsername($user->getEmail());
        $user->setPlainPassword('123456');
        $user->setCreator($this->getUser());
        
           $ifuser  = $this->getDoctrine()->getManager()
                ->getRepository('AcmeDemoBundle:User')->findByEmail($user->getEmail());
            if($ifuser   != null ){
            $errorTip = "用户已经注册过，请登陆后往“个人中心”注册会议！";
        }
        
        else{
           

                if ($form->isValid()) {
                   // $event = new FormEvent($form, $request);
                //    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);



                    $userManager->updateUser($user);

                    //报名成功
                    $result = $this->signUpSuccess($user);
                    if($result['success']){
                        return $this->redirect($this->generateUrl("_regist_for_other_show"));
                    } else {
                        $errorTip = $result['msg'];
                    }

            
                }

        }
        
        return $this->render('AcmeDemoBundle:RegistrationForOther:register.html.twig', array(
            'form' => $form->createView(),
            'errorTip' => $errorTip
        ));
        
        
        

        
    }
    
    

       private function signUpSuccess($user){
        $conference = $this->getCurrentConference();
        $now = new \DateTime();
        if($conference == null || $conference->getDueDate()<$now){
            return array('success'=>false, 'msg'=>'暂无可会议可报名！');
        }
        $signUp = $this->getDoctrine()->getManager()
                    ->getRepository('AcmeDemoBundle:SignUp')->findOneBy(array('user'=>$user, 'conference'=>$conference));
        if($signUp == null){
            $signUp = new \Acme\DemoBundle\Entity\SignUp(); 
            $signUp->setUser($user);
        
          //  $signUp->setCreator($creator);
            $signUp->setConference($conference);
            $signUp->setSignUpDate($now);
            //try{
                $this->getDoctrine()->getManager()->persist($signUp);
                $this->getDoctrine()->getManager()->flush();
                //发送提醒邮件
                $this->sendSuccessEmail($user, $conference);
                return array('success'=>true, 'msg'=>'报名成功！');
            //} catch (\Exception $ex){
            //    return array('success'=>false, 'msg'=>'报名失败！'+$ex->getMessage());
            //}
        } else {
            return array('success'=>false, 'msg'=>'重复报名！');
        }
    }
    
    
        
    private function sendSuccessEmail($user, $conference){
        $mailer = $this->get('mailer');
        $from= $this->container->getParameter('mailer_user');
        $url = $this->generateUrl('_sign_show', array(), true);
        $message = $mailer->createMessage()
            ->setSubject('您已成功报名了会议－－'.$conference->getConferenceName())
            ->setFrom($from)
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'AcmeUserBundle:Default:signUpEmail.html.twig',
                    array('conference' => $conference, 'user'=>$user, 'url'=>$url)
                ),
                'text/html'
            )
        ;
        $res = $mailer->send($message);
    }

    
    

    
     /**
     * ShowUpAction
     */
    
    
    public function registrationForOtherSignShowAction()
    {
        
         $now = new \DateTime();
        $user = $this->getUser();
      //  if (!is_object($user) || !$user instanceof UserInterface) {
      //      throw new AccessDeniedException('This user does not have access to this section.');
      //  } 
        $subUsers = $user->getSubUsers();
        $status = array();
        foreach($subUsers as $subUser){
            
            $signUp =  $this->getDoctrine()->getManager()
                ->getRepository('AcmeDemoBundle:SignUp')->findOneBy(
                array(
                        'user' => $subUser,
                        'conference' => $this->getCurrentConference()
                  )
            );
         
            if  ($this->getCurrentConference()->getDueDate() < $now)
                { 
                $status[] = "已截止";
            } else if($signUp ==  null){
                 $status[] = "未报名";
            } else {
                
               
                    $status[] = "已报名";

            }
        }

        return $this->render('AcmeDemoBundle:RegistrationForOther:RegistrationForOtherShow.html.twig', 
                array(
                    'subUsers' => $subUsers,
                    'status' => $status
                ));
    }
    
 
    
    public function registrationForOtherDissignAction(Request $request, $id)
    {
         $user = $this->getUser();
       // if (!is_object($user) || !$user instanceof UserInterface) {
      //      throw new AccessDeniedException('This user does not have access to this section.');
      //  }
/*
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user
        ));
        */
         $subUser = $this->getDoctrine()->getManager()
                ->getRepository('AcmeDemoBundle:User')->findById($id);    
         

         
           
         $signUp =  $this->getDoctrine()->getManager()
                ->getRepository('AcmeDemoBundle:SignUp')->findOneBy(
                array(
                        'user' => $subUser,
                        'conference' => $this->getCurrentConference()
                  )
            );

        if($signUp->getUser()->getCreator() == $user){
        $this->getDoctrine()->getManager()->remove($signUp);
        $this->getDoctrine()->getManager()->flush();
        }
        
        
        return $this->redirect($this->generateUrl("_regist_for_other_show"));
    }
    
    
     public function registrationForOtherSignAction(Request $request, $id)
    {
         $user = $this->getUser();
       // if (!is_object($user) || !$user instanceof UserInterface) {
      //      throw new AccessDeniedException('This user does not have access to this section.');
      //  }
/*
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user
        ));
        */
         $subUser = $this->getDoctrine()->getManager()
                ->getRepository('AcmeDemoBundle:User')->findOneById($id);    
         

        if($subUser->getCreator() == $user){
            
         $signUp = new \Acme\DemoBundle\Entity\SignUp(); 
         $signUp->setUser($subUser);
         $now = new \DateTime();

            $signUp->setConference( $this->getCurrentConference());
            $signUp->setSignUpDate($now);
            //try{
                $this->getDoctrine()->getManager()->persist($signUp);
                $this->getDoctrine()->getManager()->flush();
                

        }
    
    
     
        return $this->redirect($this->generateUrl("_regist_for_other_show"));
    }     
  
    
  

}
