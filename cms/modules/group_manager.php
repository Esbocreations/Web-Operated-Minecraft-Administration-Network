<?php

class group_manager extends base {
  public function __construct(){
    parent::__construct();
  }

  public function promote_user($username, $world){
    return $this->run_command("manpromote ".$username." ".$world."");
  }

  public function demote_user($username, $world){
    return $this->run_command("mandemote ".$username." ".$world."");
  }

  public function move_user($username, $group, $world){
    return $this->run_command("manuadd ".$username." ".$group." ".$world."");
  }

  public function remove_user($username, $group, $world){
    return $this->run_command("manudel ".$username." ".$group." ".$world."");
  }

  public function check_user($username){
    return $this->run_command("manwhois ".$username);
  }

  public function add_group($group_name){
    return $this->run_command("mangadd ".$group_name);
  }

  public function remove_group($group_name){
    return $this->run_command("mangdel ".$group_name);

  }

  public function set_parent($group, $parent){
    return $this->run_command("mangaddi ".$group." ".$parent);
  }

  public function remove_parent($group, $parent){
    return $this->run_command("mangdeli ".$group." ".$parent);
  }

}
