<?php  

Class Evenement_deelnemen {

	private $m_iUser_id;
	private $m_sUser_name;
	private $m_iEvenement_id;

	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "User_id":
			$this->m_iUser_id = $p_vValue;
			break;

			case "User_name":
			$this->m_sUser_name = $p_vValue;
			break;

			case "Evenement_id":
			$this->m_iEvenement_id = $p_vValue;
			break;
		}	   
	}

    public function __get($p_sProperty)
	{
		switch($p_sProperty)
		{
			case "User_id": 
			return $this->m_iUser_id;
			break;

			case "User_name": 
			return $this->m_sUser_name;
			break;

			case "Evenement_id": 
			return $this->m_iEvenement_id;
			break;
        }
	}

	public function Save()
	{	
		require ("connection.class.php");

		$sql = "insert into tbl_evenement_deelnames (fk_evenement_id, fk_user_id, fk_user_name) values ('$this->Evenement_id', '$this->User_id', '$this->User_name');

				update tbl_evenementen set evenement_n_visit = evenement_n_visit+1 where evenement_id='$this->Evenement_id'";

		$db->multi_query($sql);
	}
	
}

?>