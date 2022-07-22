<?php

namespace App\Classes;
use Mail;

class MailAssistant
{
  private $subject;
  private $destination;
  private $view;
  private $data;

  public function __construct($data){

    $this->setSubject($data['subject']);

    $this->setDestination($data['destination']);

    if(array_key_exists('view', $data)){

      $this->setView($data['view']);

    }else{
      
      $this->setView(null);

    }


    if(array_key_exists('data', $data)){

      $this->setData($data['data']);

    }else{
      
      $this->setData([]);

    }

    if(array_key_exists('attach', $data)){

      $this->setAttach($data['attach']);

    }else{
      
      $this->setAttach(null);

    }

  }

  private function setSubject($subject){
    $this->subject = $subject;
  }
  private function getSubject(){
    return $this->subject;
  }
  
  private function setAttach($attach){
    $this->attach = $attach;
  }
  private function getAttach(){
    return $this->attach;
  }
  
  private function setDestination($destination){
    $this->destination = $destination;
  }
  private function getDestination(){
    return $this->destination;
  }
  
  private function setView($view){
    $this->view = $view;
  }
  private function getView(){
    return $this->view;
  }
  
  private function setData($data){
    $this->data = $data;
  }
  private function getData(){
    return $this->data;
  }

  public function send(){
    $subject = $this->getSubject();

    $destination = $this->getDestination();

    $view = $this->getView();

    $data = $this->getData();
    
    $attach = $this->getAttach();

    Mail::send($view,$data,function($msg) use ($subject,$destination,$attach){

      $msg->from(env('MAIL_USERNAME'));

      $msg->subject($subject);

      $msg->to($destination);

      if($attach != null){

        $msg->attach($attach);

      }

    });
  }

}
