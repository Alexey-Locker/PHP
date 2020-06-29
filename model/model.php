<?php
/*
* 
*
* A class for connecting to a database and receiving data 
*       in the appropriate format. The format has been overridden by the job.
*
*/
class baseData{
private $dbh;

  /** 
   * @param string $host 
   * @param string $user 
   * @param string $pass 
   * @param string $db
   * @param string $charset 
   */
public function connectDB($host,$user,$pass, $db, $charset){
  
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  try {
    $this->dbh = new mysqli($host, $user, $pass);
    $this->dbh->select_db($db);
    $this->dbh->set_charset($charset);
    return true;
  } catch (\mysqli_sql_exception $e) {
    $this->dbh->query("CREATE DATABASE $db");
    $this->dbh->select_db($db);
    $this->dbh->query("CREATE TABLE `person` (
      `UID` int(11) NOT NULL,
      `Name` varchar(100) NOT NULL,
      `Age` varchar(100) NOT NULL,
      `Email` varchar(100) NOT NULL,
      `Phone` varchar(100) NOT NULL,
      `Gender` varchar(100) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    $this->dbh->set_charset($charset);
  }
}
/**
 * @param arr $array
 */
public function addPerson($array){
  foreach($array as $value){
    $arr = explode(",", $value);
    $sql = "SELECT * FROM `person` WHERE `UID` = '$arr[0]'";
    $result = mysqli_query($this -> dbh, $sql);
    $result = mysqli_fetch_assoc($result);
    if(!$result){
      $sql = "INSERT INTO person (UID,Name,Age,Email,Phone,Gender) VALUES (?,?,?,?,?,?)";
      $stmt= $this -> dbh ->prepare($sql);
      $stmt->bind_param("isssss", $arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5]);
      $result = $stmt->execute();
      return true;
    }else{
      $sql = "REPLACE INTO person (UID,Name,Age,Email,Phone,Gender) VALUES (?,?,?,?,?,?)";
      $stmt= $this -> dbh->prepare($sql);
      $stmt->bind_param("isssss", $arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5]);
     try{ 
       $result = $stmt->execute();
       return true;
     }catch(\mysqli_sql_exception $e){
       return false;
     }
    }
}
}

public function getPerson(){ 
  // Get data all person from database
  $sql = "SELECT * FROM `person`";
  $result = mysqli_query($this -> dbh, $sql);
  $result = mysqli_fetch_all($result);
  return $result;
}

public function clearRecords (){
  $sql = "DELETE FROM `person` WHERE UID";
  mysqli_query($this -> dbh, $sql);
}

}



function vardump($var) {
  highlight_string(var_export($var, true));
}

/*
 * 
 * 
 * 
 * Class inherited from baseDate 
 *                     Work with files
 * 
 * 
 */
class fileCSV extends baseData{
  private $nameFile;
  private $host;
  private $user;
  private $pass;
  private $db;
  private $charset;
  /** 
   * @param string $host 
   * @param string $user 
   * @param string $pass 
   * @param string $db
   * @param string $charset 
   */
  function __construct($host, $user,$pass,$db, $charset)  
  {
     
  // Сonstructor for connecting to the database 

    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
    $this->db = $db;
    $this->charset = $charset;
  }

  function uploadCSV ($file){  

    // User upploading file

    $nameFile = uniqid().".csv";
    move_uploaded_file($file["tmp_name"], "../files/".  $nameFile);
    $this->connectDB($this->host,$this->user,$this->pass, $this->db, $this->charset);
    return $nameFile;

  }
/**
 * @param string $name
 */
  function preparingCSV($name){ 

    // Download data from a database and create a file

    $this->connectDB($this->host,$this->user,$this->pass, $this->db, $this->charset);
    $result =$this->getPerson();
    $this->nameFile = $name.'.csv';
    $file = fopen("../files/" . $this->nameFile, 'w+');
    $text = "UID,Name,Age,Email,Phone,Gender \n";
    fwrite($file, $text);

  foreach($result as $arr){
    $text = implode(",", $arr);
    fwrite($file, $text);
  }

  fclose($file);
  }
  /**
   * @param string $name
   */
  function downloadFile($name) { 
    
    // Download the file to the user's PC

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $name);
    exit(readfile("../files/" . $this->nameFile));
  }
}