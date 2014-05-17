<?php  

Class Reactie_evenement {

	private $m_sDescription;
	private $m_sDate;
	private $m_iEvenement_id;
	private $m_iUser_id;
	private $m_sUser;
	private $m_sUser_privilege;

	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "Description":
			$this->m_sDescription = $p_vValue;
			break;

			case "Date":
			$this->m_sDate = $p_vValue;
			break;

			case "Evenement_id":
			$this->m_iEvenement_id = $p_vValue;
			break;

			case "User_id":
			$this->m_iUser_id = $p_vValue;
			break;

			case "User":
			$this->m_sUser = $p_vValue;
			break;

			case "User_privilege":
			$this->m_sUser_privilege = $p_vValue;
			break;
		}	   
	}

    public function __get($p_sProperty)
	{
		switch($p_sProperty)
		{
			case "Description": 
			return $this->m_sDescription;
			break;

			case "Date": 
			return $this->m_sDate;
			break;

			case "Evenement_id": 
			return $this->m_iEvenement_id;
			break;

			case "User_id": 
			return $this->m_iUser_id;
			break;

			case "User": 
			return $this->m_sUser;
			break;

			case "User_privilege": 
			return $this->m_sUser_privilege;
			break;
        }
	}

	public function Save()
	{	
		require ("connection.class.php");

		$sql = "insert into tbl_reacties_evenementen(reactie_description, reactie_date, fk_evenement_id, fk_user_id, fk_user_name, fk_user_privilege) 
				values ('$this->Description', '$this->Date', '$this->Evenement_id', '$this->User_id', '$this->User', '$this->User_privilege');";

		$sql .= " update tbl_evenementen set evenement_reacties = evenement_reacties+1 where evenement_id = $this->Evenement_id;";

		$db->multi_query($sql);
	}
	
}

?>