<?php  

Class Reactie_vt {

	private $m_iUser_id;
	private $m_iReactie_id;

	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "User_id":
			$this->m_iUser_id = $p_vValue;
			break;

			case "Reactie_id":
			$this->m_iReactie_id = $p_vValue;
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

			case "Reactie_id": 
			return $this->m_iReactie_id;
			break;
        }
	}

	public function Save()
	{	
		require ("connection.class.php");

		$sql = "insert into tbl_reacties_vt(fk_user_id, fk_reactie_id) 
				values ('$this->User_id', '$this->Reactie_id');

				update tbl_reacties set reactie_likes = reactie_likes+1 where reactie_id = $this->Reactie_id;";
		$db->multi_query($sql);
	}
	
}

?>