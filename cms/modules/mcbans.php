<?php
/**
 * Created by Esbocreations B.V.
 * Date: 25-2-13
 * Time: 8:43
 */

class mc_bans extends base {

  private $api_url;
  private $api_key;
  private $aStatus = array('a' => 'Already banned',
                           'n' => 'Format of request incorrect',
                           'y' => 'Action succesfull',
                           'w' => 'Blacklisted word given.',
                           'e' => 'Error occured!');
  private $aBanStatus = array('i' => 'Ip has been banned',
                           'n' => 'Has no bans',
                           'b' => 'Has bans.',
                           'i' => 'Banned on server',
                           'g' => 'No reputation left',
                           't' => 'Temp ban recieved',
                           's' => 'Banned by server in a group your server is a part of');

  public function __construct(){
    $this->api_url = "http://api.mcbans.com/v2/".MCBANS_API."/";
    $this->api_key = MCBANS_API;
    parent::__construct();
  }

  public function check_reputation($user_name){

  }

  public function global_ban_user($user_name, $reason, $player_ip, $actionData){
    $aParams = array('exec' => 'globalBan', 'player' => $user_name, 'reason' => $reason, 'player_ip' => $player_ip, 'actionData' => $actionData);
    return $this->connect($aParams);
  }

  public function local_ban_user($user_name, $reason, $player_ip, $actionData){
    $aParams = array('exec' => 'localBan', 'player' => $user_name, 'reason' => $reason, 'player_ip' => $player_ip, 'actionData' => $actionData);
    return $this->connect($aParams);
  }

  public function temp_ban_user($user_name, $reason, $player_ip, $actionData){
    $aParams = array('exec' => 'tempBan', 'player' => $user_name, 'reason' => $reason, 'player_ip' => $player_ip, 'actionData' => $actionData);
    return $this->connect($aParams);
  }

  public function ip_ban($ip, $reason){
    $aParams = array('exec' => 'ipBan', 'ip' => $ip, 'reason' => $reason, 'admin' => $_SESSION['admin_name']);
    return $this->connect($aParams);
  }

  public function remove_ban($user_name){
    $aParams = array('exec' => 'unBan', 'player' => $user_name, 'admin' => $_SESSION['admin_name']);
    return $this->connect($aParams);
  }

  public function check_bans($user_name){
    $aParams = array('exec' => 'playerLookup', 'player' => $user_name);
    return $this->connect($aParams);
  }

  private function connect($aParams){
    //Connect to remote file of the client and send reference id to trigger the mailing.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->api_url);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $aParams);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Get the data, print it and close the session
    $data = curl_exec($ch);
    if($data !== true){
       #TODO: Add general error handling!
    } else{
      return json_decode($data);
    }
  }
}