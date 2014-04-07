<?php  

Class Login {

	private $m_sUsername;
	private $m_sPassword;

	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "Username":
			$this->m_sUsername = $p_vValue;
			break;

			case "Userpassword":
			$this->m_sPassword = $p_vValue;
			break;
		}	   
	}
		
	public function __get($p_sProperty)
	{
		switch($p_sProperty)
		{
			case "Username": 
			return $this->m_sUsername;
			break;

			case "Userpassword": 
			return $this->m_sPassword;
			break;
	    }
	}
    
	public function Canlogin()
	{
		require ("connection.class.php");

		/*mysql_connect('localhost','root','');
        mysql_select_db('debug');*/
		$sql = "select * from tbl_users where user_name = '".$this->Username."'";
		//$result = mysql_query($sql);
		$result = $db->query($sql);

		$numRows = mysqli_num_rows($result);

		if($numRows == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>