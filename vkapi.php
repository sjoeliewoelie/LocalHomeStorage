 <?php 
class vkapi{
  public $userinfo;
  public function checkauth(){
    if(isset($_SESSION['access_token'])){
      return true;
    }else{
      return false;
    }
  }
  function getinfo(){
    if($this->checkauth()){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, 'https://api.vk.com/method/users.get?user_ids='.$_SESSION['user_id'].'&fields=photo_50');
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