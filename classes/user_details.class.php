<?php  

Class User_details {

	private $m_sUserzorgvoor;
	private $m_sUserdesc;
	private $m_sUserwoonplaats;
	private $m_sUserid;

	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "Userzorgvoor":
			$this->m_sUserzorgvoor = $p_vValue;
			break;

			case "Userdesc":
			$this->m_sUserdesc = $p_vValue;
			break;

			case "Userwoonplaats":
			$this->m_sUserwoonplaats = $p_vValue;
			break;

			case "Userid":
			$this->m_sUserid = $p_vValue;
			break;
		}	   
	}
		
	public function __get($p_sProperty)
	{
		switch($p_sProperty)
		{
			case "Userzorgvoor": 
			return $this->m_sUserzorgvoor;
			break;

			case "Userdesc": 
			return $this->m_sUserdesc;
			break;

			case "Userwoonplaats": 
			return $this->m_sUserwoonplaats;
			break;

			case "Userid": 
			return $this->m_sUserid;
			break;
	    }
	}
    
    public function Update()
	{	
		require ("connection.class.php");

		$sql = "update tbl_user_details set user_detail_zorgvoor='$this->Userzorgvoor', user_detail_desc='$this->Userdesc', user_detail_woonplaats='$this->Userwoonplaats' where fk_user_id = $this->Userid;";
		$db->query($sql);
	}

	public function Save()
	{	
		require ("connection.class.php");

		$sql = "insert into tbl_user_details(user_detail_zorgvoor, user_detail_desc, user_detail_woonplaats, fk_user_id) values ('$this->Userzorgvoor', '$this->Userdesc', '$this->Userwoonplaats', '$this->Userid')";
		$db->query($sql);
	}
}
?>