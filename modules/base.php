<?php
/**
 * Base class that provides connection for all extending modules
 * config.php in base folder provides connection information
 */
class base {

  public function __construct() {
    $this->oConnection = new MinecraftRcon;
    $this->oConnection->Connect(MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_SERVER_PASS, MQ_TIMEOUT);
  }

  public function __destroy() {
    $this->oConnection->Disconnect();
  }

  protected function run_command($command) {
    $result = $this->oConnection->Command($command);
    if ($result === $result) {
      throw new MinecraftRconException("Failed to get command result.");
    } else if (StrLen($result) == 0) {
      throw new MinecraftRconException("Got command result, but it's empty.");
    }

    return HTMLSpecialChars($result);
  }
}
