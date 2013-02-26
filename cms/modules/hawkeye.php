<?php
/**
 * Created by Esbocreations
 * Date: 26-2-13
 * Time: 9:34
 */
require_once CORE_PATH . 'classes/database.php';

class hawkeye extends base {

  private $tekkit_list = "tekkit.txt";
  private $minecraft_list = "default.txt";
  private $custom_list = "custom.txt";
  private $aPlayers = array();
  private $aWorlds = array();

  protected $oDatabase;

  public function __construct() {
    $this->oDatabase = new database();
    $this->load_data();
    parent::__construct();
  }

  private function load_data() {
    #Players
    $oResult = $this->oDatabase->query("SELECT player_id, player FROM " . HE_PLAYER_TABLE . "");
    if ($oResult) {
      $counter = 0;
      while ($oRow = $this->oDatabase->fetch_object($oResult)) {
        $this->aPlayers[$counter]['player_id'] = $oRow->player_id;
        $this->aPlayers[$counter]['player_name'] = $oRow->player;
        ++$counter;
      }
    }
    #Worlds
    $oResult = $this->oDatabase->query("SELECT world_id, world FROM " . HE_WORLD_TABLE . "");
    if ($oResult) {
      $counter = 0;
      while ($oRow = $this->oDatabase->fetch_object($oResult)) {
        $this->aWorlds[$counter]['world_id'] = $oRow->player_id;
        $this->aWorlds[$counter]['world_name'] = $oRow->world;
        ++$counter;
      }
    }
  }

  public function get_logdata($offset = 0, $limit = 30, $afilter = array()) {
    $aData = array();
    if (!empty($afilter)) {
      $where = "WHERE TRUE";
      if (!empty($afilter['x'])) {
        $where .= " AND (`x` BETWEEN " . ($afilter['x'] - $afilter['range']) . " AND " . ($afilter['x'] + $afilter['range']) . ")";
      }
      if (!empty($afilter['y'])) {
        $where .= " AND (`y` BETWEEN " . ($afilter['y'] - $afilter['range']) . " AND " . ($afilter['y'] + $afilter['range']) . ")";
      }
      if (!empty($afilter['z'])) {
        $where .= " AND (`z` BETWEEN " . ($afilter['z'] - $afilter['range']) . " AND " . ($afilter['z'] + $afilter['range']) . ")";
      }
      if (!empty($afilter['date_from'])) {
        $where .= " AND `date` >= " . $this->oDatabase->escape($afilter['date_from']) . " ";
      }
      if (!empty($afilter['date_to'])) {
        $where .= " AND `date` <= " . $this->oDatabase->escape($afilter['date_to']) . " ";
      }
      if (!empty($afilter['world'])) {
        $where .= " AND `world_id` = " . $this->oDatabase->escape($afilter['world']) . " ";
      }
      if (!empty($afilter['player_id'])) {
        $where .= " AND `player_id` = " . $this->oDatabase->escape($afilter['player_id']) . " ";
      }

    }
    $oResult = $this->oDatabase->query("SELECT * FROM " . HE_LOG_TABLE . " " . $where . " ORDER BY `date` DESC LIMIT $offset,$limit");
    if ($oResult) {
      $counter = 0;
      while ($oRow = $this->oDatabase->fetch_object($oResult)) {
        $aData[$counter]['data_id'] = $oRow->data_id;
        $aData[$counter]['date'] = $oRow->date;
        $aData[$counter]['player_id'] = $oRow->player_id;
        $aData[$counter]['action'] = $oRow->action;
        $aData[$counter]['world_id'] = $oRow->world_id;
        $aData[$counter]['x'] = $oRow->x;
        $aData[$counter]['y'] = $oRow->y;
        $aData[$counter]['z'] = $oRow->z;
        $aData[$counter]['data'] = $oRow->data;
        $aData[$counter]['plugin'] = $oRow->plugin;
        ++$counter;
      }
    }

    return $aData;
  }
}