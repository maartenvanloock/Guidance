<?php  

Class Ervaring_vt {

	private $m_iUser_id;
	private $m_iErvaring_id;
	private $m_sErvaring_st;

	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "User_id":
			$this->m_iUser_id = $p_vValue;
			break;

			case "Ervaring_id":
			$this->m_iErvaring_id = $p_vValue;
			break;

			case "Ervaring_st":
			$this->m_sErvaring_st = $p_vValue;
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

			case "Ervaring_id": 
			return $this->m_iErvaring_id;
			break;

			case "Ervaring_st":
			$this->m_sErvaring_st = $p_vValue;
			break;
        }
	}

	public function Save()
	{	
		require ("connection.class.php");

		if ($this->m_sErvaring_st == "up")
		{
			$sql = "insert into tbl_ervaringen_vt(fk_user_id, fk_ervaring_id) 
				values ('$this->User_id', '$this->Ervaring_id');

				update tbl_ervaringen set ervaring_likes = ervaring_likes+1 where ervaring_id = $this->Ervaring_id;";
		}
		else if ($this->m_sErvaring_st == "down")
		{
			$sql = "insert into tbl_ervaringen_vt(fk_user_id, fk_ervaring_id) 
				values ('$this->User_id', '$this->Ervaring_id');

				update tbl_ervaringen set ervaring_likes = ervaring_likes-1 where ervaring_id = $this->Ervaring_id;";
		}

		$db->multi_query($sql);
	}
	
}

?>