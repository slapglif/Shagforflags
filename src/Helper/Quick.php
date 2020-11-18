<?php

namespace App\Helper;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Templating\Helper\Helper;

class Quick extends Helper{

    /**
     * @var
     */
    private $_doctrine;

    /**
     * @var
     */
    private $_container;

    private $_templating;


    public function __construct($container, $doctrine, EngineInterface $templating)
    {
        $this->_doctrine = $doctrine;
        $this->_container = $container;
        $this->_templating = $templating;

        return $this;
    }

    public function addAlert($type,$close,$message){
        $this->getContainer()->get('session')->getFlashBag()->add('alert', array(
            'type' => $type,
            'close' => $close,
            'message' => $message
        ));
    }

    public function showAlert(){

        $alerts = $this->getContainer()->get('session')->getFlashBag()->get('alert');

        if(empty($alerts)) {
            return false;
        }

        $html = "";
        foreach($alerts as $alert){
            $html .= '<div class="alert alert-'.$alert["type"].' alert-dismissable">';
            $html .= '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
            $html .= $alert['message'];
            $html .= '</div>';
        }

        return $html;
    }

    public function notice(){
        $notice = $this->getContainer()->get('session')->getFlashBag()->get('notice');

        if(empty($notice)){
            return FALSE;
        }else {
            return $notice[0];
        }
    }

    /**
     * @param $toEmail
     * @param $subject
     * @param $template
     * @param $params
     * @param array $from
     * @return \Swift_Mime_MimePart
     */
    public function mail($toEmail, $subject, $template, $params, $attach = FALSE, $from = array('mail@shagforflags.com' => 'Shag For Flags')){
        $body = $this->_templating->render($template, $params);
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($toEmail)
            ->setBody($body, 'text/html');

        if($attach) {
            $attachment = \Swift_Attachment::fromPath($attach['path'])
                ->setFilename($attach['name']);

            $message->attach($attachment);
        }
        
        $mailer = $this->_container->get('mailer');
        try {
            if ($mailer->send($message)) {
                $spool = $mailer->getTransport()->getSpool();
                $transport = $this->_container->get('swiftmailer.transport.real');
                $spool->flushQueue($transport);
                //$mailer->getTransport()->stop();
                return TRUE;
            }
        } catch (\Exception $e) {
            return FALSE;
        }
        return FALSE;
    }

    public function checkAgeValidation($restriction_age, $birthdate) {
        $birthdate_array = explode("-", $birthdate);

        $today_date_object = date_create('today');
        $birthdate_date_object = date_create("{$birthdate_array[0]}-{$birthdate_array[1]}-{$birthdate_array[2]}");
        $age = date_diff($today_date_object, $birthdate_date_object)->y;

        if ($age >= $restriction_age) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getName(){}

    /**
     * @return Registry
     */
    public function getDoctrine(){
        return $this->_doctrine;
    }

    /**
     * @return Container
     */
    public function getContainer(){
        return $this->_container;
    }

    public function getHelper($name){
        return $this->getContainer()->get($name);
    }
}
