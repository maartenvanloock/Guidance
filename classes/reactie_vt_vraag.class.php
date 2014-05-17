<?php  

Class Reactie_vt_vraag {

	private $m_iUser_id;
	private $m_iReactie_id;
	private $m_sReactie_st;
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

			case "Reactie_id":
			$this->m_iReactie_id = $p_vValue;
			break;

			case "Reactie_st":
			$this->m_sReactie_st = $p_vValue;
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

			case "Reactie_id": 
			return $this->m_iReactie_id;
			break;

			case "Reactie_st": 
			return $this->m_sReactie_st;
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

		if ($this->Reactie_st == "up")
		{
			$sql = "insert into tbl_reacties_vt (fk_user_id, fk_reactie_id) 
					values ('$this->User_id', '$this->Reactie_id');

					update tbl_reacties set reactie_likes = reactie_likes+1 where reactie_id = $this->Reactie_id;

					update tbl_users set user_ptn = user_ptn+$this->User_up_v where user_id = $this->User_id_m;";
		}
		else if ($this->Reactie_st == "down")
		{
			$sql = "insert into tbl_reacties_vt (fk_user_id, fk_reactie_id) 
					values ('$this->User_id', '$this->Reactie_id');

					update tbl_reacties set reactie_likes = reactie_likes-1 where reactie_id = $this->Reactie_id;

					update tbl_users set user_ptn = user_ptn-$this->User_down_v where user_id = $this->User_id_m;";
		}

		$db->multi_query($sql);
	}
	
}

?>