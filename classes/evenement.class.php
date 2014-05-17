<?php  

Class Evenement {

	private $m_sTitle;
	private $m_sDescription;
	private $m_sAddress;
	private $m_sUser;
	private $m_iUser_id;
	private $m_sDate;
	private $m_iTime_start;
	private $m_iTime_stop;
	private $m_sTags;

	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "Title":
			$this->m_sTitle = $p_vValue;
			break;

			case "Description":
			$this->m_sDescription = $p_vValue;
			break;

			case "Address":
			$this->m_sAddress = $p_vValue;
			break;

			case "User":
			$this->m_sUser = $p_vValue;
			break;

			case "User_id":
			$this->m_iUser_id = $p_vValue;
			break;

			case "Date":
			$this->m_sDate = $p_vValue;
			break;

			case "Time_start":
			$this->m_iTime_start = $p_vValue;
			break;

			case "Time_stop":
			$this->m_iTime_stop = $p_vValue;
			break;

			case "Tags":
			$this->m_sTags = $p_vValue;
			break;
		}	   
	}

    public function __get($p_sProperty)
	{
		switch($p_sProperty)
		{
			case "Title": 
			return $this->m_sTitle;
			break;

			case "Description": 
			return $this->m_sDescription;
			break;

			case "Address": 
			return $this->m_sAddress;
			break;

			case "User": 
			return $this->m_sUser;
			break;

			case "User_id": 
			return $this->m_iUser_id;
			break;

			case "Date": 
			return $this->m_sDate;
			break;

			case "Time_start": 
			return $this->m_iTime_start;
			break;

			case "Time_stop": 
			return $this->m_iTime_stop;
			break;

			case "Tags": 
			return $this->m_sTags;
			break;
        }
	}

	public function Save()
	{	
		require ("connection.class.php");

		$sql = "insert into tbl_evenementen (evenement_title, evenement_description, evenement_adress, evenement_n_visit, evenement_reacties, evenement_time_start, evenement_time_stop, evenement_date, fk_user_id, fk_user_name) 
				values ('$this->Title', '$this->Description', '$this->Address', 0, 0, '$this->Time_start', '$this->Time_stop', '$this->Date', '$this->User_id', '$this->User')";
		$db->query($sql);

		$reactie_id_tags = mysqli_insert_id($db);
    	return $reactie_id_tags;
	}
}

?>