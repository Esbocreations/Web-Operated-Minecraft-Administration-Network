<?php
/**
 * Created by Esbocreations.
 * Date: 11-3-13
 * Time: 11:15
 */
class mc_login {
  private $login_url = "https://login.minecraft.net";
  private $check_url = "https://www.minecraft.net";

  public function login($aParams) {
    //Connect to remote file of the client and send reference id to trigger the mailing.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->login_url . '/?user=' . $aParams['username'] . '&password=' . $aParams['password'] . '&version=20');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Get the data, print it and close the session
    $data = curl_exec($ch);
    if ($data == 'Bad Login') {
      #TODO: Add general error handling!
    } else {
      return $data;
    }
  }

  public function check_premium($username) {
    //Connect to remote file of the client and send reference id to trigger the mailing.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->check_url . '/haspaid.jsp?user=' . $username);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Get the data, print it and close the session
    $data = curl_exec($ch);
    if ($data == 'Bad Request') {
      #TODO: Add general error handling!
    } else {
      return $data;
    }
  }
}
