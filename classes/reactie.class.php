<?php  

Class Reactie {

	private $m_sDescription;
	private $m_sDate;
	private $m_iVraag_id;
	private $m_iErvaring_id;
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

			case "Vraag_id":
			$this->m_iVraag_id = $p_vValue;
			break;

			case "Ervaring_id":
			$this->m_iErvaring_id = $p_vValue;
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

			case "Vraag_id": 
			return $this->m_iVraag_id;
			break;

			case "Ervaring_id": 
			return $this->m_iErvaring_id;
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

		$sql = "insert into tbl_reacties(reactie_description, reactie_date, reactie_likes, fk_vraag_id, fk_ervaring_id, fk_evenement_id, fk_user_id, fk_user_name, fk_user_privilege) 
				values ('$this->Description', '$this->Date', 0, '$this->Vraag_id', '$this->Ervaring_id', '$this->Evenement_id', '$this->User_id', '$this->User', '$this->User_privilege');";

		if ($this->Ervaring_id !== 0)
		{
			$sql .= " update tbl_ervaringen set ervaring_reacties = ervaring_reacties+1 where ervaring_id = $this->Ervaring_id;";
		}
		else if ($this->Vraag_id !== 0)
		{
			$sql .= " update tbl_vragen set vraag_reacties = vraag_reacties+1 where vraag_id = $this->Vraag_id;";
		}

		$db->multi_query($sql);
	}
	
}

?>