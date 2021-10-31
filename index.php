<?php

class CreatorOrder {
    private $url;
    private $apiKey;    
    private $data; 


   public function __construct($url, $apiKey, $site, $customer, $offer, $order){       
    $this->url = $url;
    $this->apiKey = $apiKey;
    $this->data = array('apiKey' => $apiKey,
    'site' => $site,
    'order' => json_encode(array_merge($customer, $offer, $order))
   );
   } 

  public function create(){
    

    $data = http_build_query($data); 
    
    $ch = curl_init($this->url); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 

    $result = curl_exec($ch);
    curl_close($ch);
  
    return $result;
        
  }
}

class Order{
    private $orderType;
    private $orderMethod;
    private $number;    
    private $status;

    public function __construct($orderType, $orderMethod, $number,  $status){
        $this->orderType = $orderType;
        $this->orderMethod = $orderMethod;
        $this->number = $number;        
        $this->status = $status;
    }


 public function getOrder(){
      return array('orderType' => $this->orderType, 'orderMethod' => $this->orderMethod, 'number' => $this->number, 'status' =>  $this->status);

    }
}


class Customer {
    
    private $lastName;
    private $firstName;
    private $patronymic;
    private $customerComment;    

    public function __construct($lastName, $firstName, $patronymic, $customerComment){
           $this->lastName = $lastName;
           $this->firstName = $firstName;
           $this->patronymic = $patronymic;
           $this->customerComment = $customerComment;
           

    } 

    public function getCustomer(){
      return array('lastName' => $this->lastName, 'firstname' => $this->firstName, 
      'patronymic' => $this->patronymic);

    }

}

class Offer{
    private $code;
    private $name;
    private $comment;    

    public function __construct($code, $name, $comment){
        $this->code = $code; 
        $this->name = $name;   
        $this->comment = $comment;  
 } 
 
 public function getOffer(){
    return array('items' =>array(
      '0' => array(
        'externalIds' => array(
          '0'=>array('code' => $this->code,
            'value' => $this->name
          )
        ),
        'comment' => $this->comment
      )
    ));
    
  }
}




$customer = new Customer('Denisov','Mihail','Olegovich','https://github.com/MihailJa/superposuda');
$customer = $customer->getCustomer();

$offer = new Offer('AZ105R', 'Azalita', 'тестовое задание');
$offer = $offer->getOffer();

$order = new Order('fizik', 'test', '22011988', 'trouble');
$order = $order->getOrder();

$creator = new CreatorOrder('http://superposuda.retailcrm.ru/api/v5/orders/create', 'QlnRWTTWw9lv3kjxy1A8byjUmBQedYqb', 'site',
$customer, $offer, $order);
$result = $creator->create();







?>