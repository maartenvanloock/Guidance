<?php  

Class Ervaring {

	private $m_sTitle;
	private $m_sDescription;
	private $m_sUser;
	private $m_iUser_id;
	private $m_sCategorie_name;
	private $m_sCategorie_color;
	private $m_sDate;
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

			case "User":
			$this->m_sUser = $p_vValue;
			break;

			case "User_id":
			$this->m_iUser_id = $p_vValue;
			break;

			case "Categorie_name":
			$this->m_sCategorie_name = $p_vValue;
			break;

			case "Categorie_color":
			$this->m_sCategorie_color = $p_vValue;
			break;

			case "Date":
			$this->m_sDate = $p_vValue;
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

			case "User": 
			return $this->m_sUser;
			break;

			case "User_id": 
			return $this->m_iUser_id;
			break;

			case "Categorie_name": 
			return $this->m_sCategorie_name;
			break;

			case "Categorie_color": 
			return $this->m_sCategorie_color;
			break;

			case "Date": 
			return $this->m_sDate;
			break;

			case "Tags": 
			return $this->m_sTags;
			break;
        }
	}

	public function Save()
	{	
		require ("connection.class.php");

		$sql = "insert into tbl_ervaringen(ervaring_title, ervaring_description, ervaring_likes, ervaring_reacties, ervaring_solved, ervaring_date, fk_user_id, fk_user_name, fk_categorie_name, fk_categorie_color) 
				values ('$this->Title', '$this->Description', 0, 0, 0, '$this->Date', '$this->User_id', '$this->User', '$this->Categorie_name', '$this->Categorie_color')";
		$db->query($sql);

		$reactie_id_tags = mysqli_insert_id($db);
    	return $reactie_id_tags;
	}
}

?>