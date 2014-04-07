<?php  

Class User {

	private $m_sUsername;
	private $m_sPassword;
	private $m_sPrivilege;

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

			case "Userprivilege":
			$this->m_sPrivilege = $p_vValue;
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

			case "Userprivilege": 
			return $this->m_sPrivilege;
			break;
	    }
	}
    
	public function UserAvailable()
	{
		require ("connection.class.php");

		/*mysql_connect('localhost','root','');
        mysql_select_db('debug');*/
		$sql = "select user_name from tbl_users where user_name = '".$this->Username."'";
		//$result = mysql_query($sql);
		$result = $db->query($sql);

		$numRows = mysqli_num_rows($result);

		if($numRows == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

    public function Save()
	{	
		require ("connection.class.php");

		//$db = new Db();
		$sql = "insert into tbl_users(user_name, user_profile_path, user_password, user_privilege) values ('$this->Username', ' ', '$this->Userpassword', '$this->Userprivilege')";
		//$db->conn->query($sql);
		$db->query($sql);
	}
}
?>