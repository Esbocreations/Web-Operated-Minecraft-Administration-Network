<?php
class database {

  private $m_sDbHost;
  private $m_sDbUser;
  private $m_sDbPass;
  private $m_sDbName;
  private $m_objDbLink;
  private $m_objResult;

  public function __construct($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $data = DB_DATA) {
    $this->m_sDbHost = $host;
    $this->m_sDbUser = $user;
    $this->m_sDbPass = $pass;
    $this->m_sDbName = $data;

    $this->connect();
  }

  private function connect() {
    $this->m_objDbLink = new mysqli($this->m_sDbHost, $this->m_sDbUser, $this->m_sDbPass, $this->m_sDbName);
    if (mysqli_connect_error()) {
      die('error connecting to db');
    }
  }

  public function close() {
    if (is_object($this->m_objDbLink)) {
      $this->m_objDbLink->close();
    }
  }

  public function query($p_sQuery) {
    if (!is_object($this->m_objDbLink) || !$this->m_objDbLink->ping()) {
      $this->close();
      $this->connect();
    }

    $this->m_objResult = $this->m_objDbLink->query($p_sQuery);

    if ($this->m_objDbLink->error) {
      trigger_error('Query Error ' . $p_sQuery . ' MySQli Error: ' . $this->m_objDbLink->error);
    }
    return $this->m_objResult;
  }

  /*
   *	$p_rResult must be a MySQLi_result object!
   *	$p_sType is a CONSTANT value
   *	source: http://nl3.php.net/manual/en/mysqli-result.fetch-array.php
   *
   *	This optional parameter is a constant indicating what type of array should be produced from the current row data.
   *	The possible values for this parameter are the constants MYSQLI_ASSOC, MYSQLI_NUM, or MYSQLI_BOTH.
   *	Defaults to MYSQLI_BOTH. By using the MYSQLI_ASSOC constant this function will behave identically to the
   *	mysqli_fetch_assoc(), while MYSQLI_NUM will behave identically to the mysqli_fetch_row() function.
   *	The final option MYSQLI_BOTH will create a single array with the attributes of both.
   */
  public function makeArray($p_sType = MYSQLI_ASSOC) {
    $aResult = array();
    $i = 0;
    # Process each record in the while loop
    while ($aFields = $this->m_objResult->fetch_array($p_sType)) {
      foreach ($aFields as $sField => $mValue) { # Now process each field for each record
        $aResult[$i][$sField] = $mValue; # Each record gets its own array key and each field its own sub-key
      } # with as value its value from the query result
      $i++;
    }
    return $aResult;
  }

  public function num_rows() {
    return $this->m_objResult->num_rows;
  }

  public function fetch_object() {
    return $this->m_objResult->fetch_object();
  }

  public function escape($p_sString) {
    return $this->m_objDbLink->escape_string($p_sString);
  }

  public function getInsertId() {
    return $this->m_objDbLink->insert_id;
  }

  public function getAffectedRows() {
    return $this->m_objDbLink->affected_rows;
  }

  public function freeResult() {
    $this->m_objResult->free();
  }

  public function length() {
    return $this->m_objResult->length();
  }

  public function insert_id() {
    return $this->m_objDbLink->insert_id;
  }
}

?>
<?php
abstract class mysql_init {
  private static $m_objInstance = null;

  public static function instantiate() {
    if (!self::$m_objInstance) {
      self::$m_objInstance = new database($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $data = DB_DATA);
    }
    return self::$m_objInstance;
  }
}

?>