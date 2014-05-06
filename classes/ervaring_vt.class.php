<?php  

Class Ervaring_vt {

	private $m_iUser_id;
	private $m_iErvaring_id;
	private $m_sErvaring_st;
	private $m_iUser_id_m;
	private $m_iUser_up_v;
	private $m_iUser_down_v;


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

			case "User_id_m":
			$this->m_iUser_id_m = $p_vValue;
			break;

			case "User_up_v":
			$this->m_iUser_up_v = $p_vValue;
			break;

			case "User_down_v":
			$this->m_iUser_down_v = $p_vValue;
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

			case "User_id_m":
			return $this->m_iUser_id_m;
			break;

			case "User_up_v":
			return $this->m_iUser_up_v;
			break;

			case "User_down_v":
			return $this->m_iUser_down_v;
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

					update tbl_ervaringen set ervaring_likes = ervaring_likes+1 where ervaring_id = $this->Ervaring_id;

					update tbl_users set user_ptn = user_ptn+$this->User_up_v where user_id = $this->User_id_m;";
		}
		else if ($this->m_sErvaring_st == "down")
		{
			$sql = "insert into tbl_ervaringen_vt(fk_user_id, fk_ervaring_id) 
					values ('$this->User_id', '$this->Ervaring_id');

					update tbl_ervaringen set ervaring_likes = ervaring_likes-1 where ervaring_id = $this->Ervaring_id;

					update tbl_users set user_ptn = user_ptn-$this->User_down_v where user_id = $this->User_id_m;";
		}

		$db->multi_query($sql);
	}
	
}

?>