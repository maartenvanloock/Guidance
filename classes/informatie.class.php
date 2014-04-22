<?php  

Class Informatie {

	private $m_sTitle;
	private $m_sDescription;
	private $m_sUser;
	private $m_iUser_id;
	private $m_sCategorie_name;

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

			case "User":
			$this->m_sUser = $p_vValue;
			break;

			case "User_id":
			$this->m_iUser_id = $p_vValue;
			break;

			case "Categorie_name":
			$this->m_sCategorie_name = $p_vValue;
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

			case "User": 
			return $this->m_sUser;
			break;

			case "User_id": 
			return $this->m_iUser_id;
			break;

			case "Categorie_name": 
			return $this->m_sCategorie_name;
			break;
        }
	}

	public function Save()
	{	
		require ("connection.class.php");

		$sql = "insert into tbl_informatieblok(informatieblok_title, informatieblok_description, fk_categorie_name, fk_user_id, fk_user_name) 
				values ('$this->Title', '$this->Description', '$this->Categorie_name', '$this->User_id', '$this->User')";
		$db->query($sql);
	}
}

?>