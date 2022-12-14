<?php 
//On creer l'object Question
abstract class Question{
    //On creer les attributs
    private $id;
    private $name;
    private $image;
    private $type;

    //On creer le constructeur
    /**
     * Question constructor.
     * @param $name
     * @param $image
     */

    public function __construct($id,$name,$image){
        $this->id="carte".$id."$";;
        $this->name=$name;
        $this->image=$image;
    }


    //On creer les getters et setters

    /**
     * Set the path of the image
     */
    public function set_image($image){
        $this->image=$image;
    }

    /**
     * get the path to the image
     */
    public function get_image(){
        return $this->image;
    }
    /**
     * Set the value of name
     */
    public function set_name($name){
        $this->name=$name;
    }


    /**
     * Get the value of name
     */
    public function get_name(){
        return $this->name;
    }

    /**
     * Get the value of id
     */
    public function get_id(){
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function set_id($id){
        $this->id="carte".$id."$";;
    }

    /**
     * Get the value of type
     */




    
    

}
    


//On creer L'objet Question_QCM qui herite de Question
class Question_QCM extends Question{
//-----------------attributs--------------------------------
    private $listReponse; //Liste des reponses avec leurs couleurs associées [reponse,couleur] 
    private $nbReponseMax; //Nombre de reponse max pour la question

//----------------constructeur------------------------------
    /**
    * Question_QCM constructor.
    * @param string $name 
    * @param string $image
    * @param array $listReponse
    * @param int $nbReponseMax
    */
    public function __construct($id,$name,$image,$listReponse,$nbReponseMax){
        parent::__construct($id,$name,$image);
        $this->listReponse=$listReponse;
        $this->nbReponseMax=$nbReponseMax;
        $this->type="QCM";

    }


//---------------getters et setters--------------------------


    /**
     * Get the value of listReponse
     */
    function get_listReponse(){
        return $this->listReponse;

    }

    /**
     * Set the value of listReponse
     */
    function set_listReponse($listReponse){
        $this->listReponse=$listReponse;
    }

    /**
     * Get the value of nbReponseMax
     */
    function get_nbReponseMax(){
        return $this->nbReponseMax;
    }

    /**
     * Set the value of nbReponseMax
     */
    function set_nbReponseMax($nbReponseMax){
        $this->nbReponseMax=$nbReponseMax;
    }

    public function get_type(){
        return $this->type;
    }    
}


//On creer L'objet Question_Libre qui herite de Question
class Question_Libre extends Question{
    //On creer les attributs
    private $nbCaractereMax; //Nombre de caractere max pour la question

    //On creer le constructeur
    /**
    * Question_Libre constructor.
    * @param string $name 
    * @param filepath $image
    * @param int $nbCaractereMax
    */
    public function __construct($id,$name,$image,$nbCaractereMax){
        parent::__construct($id,$name,$image);
        $this->nbCaractereMax=$nbCaractereMax;
        $this->type="LIBRE";
    }
    //On creer les getters et setters

    /**
     * Get the value of nbCaractereMax
     */
    function get_nbCaractereMax(){
        return $this->nbCaractereMax;
    }

    /**
     * Set the value of nbCaractereMax
     */
    function set_nbCaractereMax($nbCaractereMax){
        $this->nbCaractereMax=$nbCaractereMax;
    }

    public function get_type(){
        return $this->type;
    }
}

?>

