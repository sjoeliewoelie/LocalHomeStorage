 <?php 
class vkapi{
  public $userinfo;
  public $userdata;
  public function checkauth(){
    if(isset($_SESSION['access_token'])){
      return true;
    }else{
      return false;
    }
  }
  function getData(){
    if($this->checkauth()){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, 'https://api.vk.com/method/audio.get?owner_id='.$_SESSION['user_id'].'&v=5.2&count=50&access_token='.$_SESSION['access_token']);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
      $out = curl_exec($curl);
      $this->userdata = json_decode($out);
      curl_close($curl);
      return $this->userdata;
    }
    return false;  
  }
  function getinfo(){
    if($this->checkauth()){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, 'https://api.vk.com/method/users.get?user_ids='.$_SESSION['user_id'].'&v=5.2&fields=photo_50');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
      $out = curl_exec($curl);
      $this->userinfo = json_decode($out);
      curl_close($curl);
      return $this->userinfo;
    }
    return false;
  }
}
?>