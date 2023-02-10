<?php 

//On creer l'object Question
abstract class Question{
    //On creer les attributs
    private $id;
    private $name;
    private $image;
    private $type;
    private $visibilite='all';

    //On creer le constructeur
    /**
     * Question constructor.
     * @param $name
     * @param $image
     */

    public function __construct($id,$name,$image,$visibilite){
        $this->id=$id;
        $this->name=$name;
        $this->image=$image;
        $this->visibilite=$visibilite;
    }


    static public function db_get_all($database){
        $req=$database->prepare("SELECT ID,TYPEQUESTION FROM question");
        $req->execute();
        $listQuestions=array();
        while($resultat=$req->fetch()){
            $id=$resultat['ID'];
            $type=$resultat['TYPEQUESTION'];
            if($type=="QCM"){
                $carte=Question_QCM::db_get($database,$id);
                $listQuestions[]=$carte;
            }
            if($type=="LIBRE"){
                $carte=Question_Libre::db_get($database,$id);
                $listQuestions[]=$carte;
            }
        }
        return $listQuestions;
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
     * Get the value of id for html
     */
    public function get_id_html(){
        return "carte".$this->id."sep";;
    }

    /**
     * Get the value of id in the database
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
     * Get the value of visibilite
     */
    public function get_visibilite(){
        return $this->visibilite;
    }

    /**
     * Set the value of visibilite
     */
    public function set_visibilite($visibilite){
        $this->visibilite=$visibilite;
    }




    
    

}
    


//On creer L'objet Question_QCM qui herite de Question
class Question_QCM extends Question{
//-----------------attributs--------------------------------
    private $listPropositions; //Liste des reponses avec leurs couleurs associées [reponse,couleur] 
    private $nbReponseMax; //Nombre de reponse max pour la question

//----------------constructeur------------------------------
    /**
    * Question_QCM constructor.
    * @param string $name 
    * @param string $image
    * @param array $listPropositions
    * @param int $nbReponseMax
    */
    public function __construct($id,$name,$image,$visibilite,$listPropositions,$nbReponseMax){
        parent::__construct($id,$name,$image,$visibilite);
        $this->listPropositions=$listPropositions;
        $this->set_nbReponseMax($nbReponseMax);
        $this->type="QCM";

    }

    static public function db_get($database,$id){
        $req=$database->prepare("SELECT * FROM question WHERE ID=:id");
        $req->execute(array("id"=>$id));
        $resultat=$req->fetch();
        if($resultat){
            $req=$database->prepare("SELECT * FROM proposition WHERE ID_QUESTION=:id_question");
            $req->execute(array("id_question"=>$id));
            $resultat2=$req->fetchAll();
            $listPropositions=array();
            foreach($resultat2 as $proposition){
                $listPropositions[]=array($proposition['TEXTE'],$proposition['COULEUR']);
            }
            return new Question_QCM($id,$resultat['INTITULE'],$resultat['IMAGE'],$resultat['VISIBILITE'],$listPropositions,$resultat['NBREPONSE']);
        }
        else{
            return null;
        }
    }

//---------------getters et setters--------------------------


    /**
     * Get the value of listPropositions
     */
    function get_listPropositions(){
        return $this->listPropositions;

    }

    /**
     * Set the value of listPropositions
     */
    function set_listPropositions($listPropositions){
        $this->listPropositions=$listPropositions;
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
        if($nbReponseMax<1){
            $nbReponseMax=1;
        }
        $this->nbReponseMax=$nbReponseMax;
    }

    public function get_type(){
        return $this->type;
    }  
    


    public function db_save($database){
        //On regarde si une carte du meme id existe deja dans la base de donnee
        $req=$database->prepare("SELECT * FROM question WHERE id=:id");
        $req->execute(array("id"=>$this->get_id()));
        $resultat=$req->fetch();
        if(!$resultat){
            //Si elle n'existe pas on la cree
            $req=$database->prepare("INSERT INTO question (id,intitule,id_formulaire,image,visibilite,typequestion,nbreponse)
                                    VALUES (:id,:intitule,:id_formulaire,:image,:visibilite,:typequestion,:nbreponse)");}
        else{
            //Si elle existe on la modifie
            $req=$database->prepare("UPDATE question SET intitule=:intitule,id_formulaire=:id_formulaire,image=:image,visibilite=:visibilite,typequestion=:typequestion,nbreponse=:nbreponse WHERE id=:id");
        }
        $req->execute(array(
            "id"=>$this->get_id(),
            "intitule"=>$this->get_name(),
            "id_formulaire"=>1,
            "image"=>$this->get_image(),
            "visibilite"=>1,
            "typequestion"=>$this->get_type(),
            "nbreponse"=>$this->get_nbReponseMax()));

        
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
    public function __construct($id,$name,$image,$visibilite,$nbCaractereMax){
        parent::__construct($id,$name,$image,$visibilite);
        $this->set_nbCaractereMax($nbCaractereMax);
        $this->type="LIBRE";
    }

    static public function db_get($database,$id){
        $req=$database->prepare("SELECT * FROM question WHERE ID=:id");
        $req->execute(array("id"=>$id));
        $resultat=$req->fetch();
        if($resultat){
            return new Question_Libre($id,$resultat['INTITULE'],$resultat['IMAGE'],$resultat['VISIBILITE'],$resultat['NBCARACTEREMAX']);
        }
        else{
            return null;
        }
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
        if ($nbCaractereMax<0){
            $nbCaractereMax=1;
        }
        if ($nbCaractereMax>500){
            $nbCaractereMax=500;
        }

        $this->nbCaractereMax=$nbCaractereMax;
    }

    public function get_type(){
        return $this->type;
    }

    public function db_save($database){
        //On regarde si une carte du meme id existe deja dans la base de donnee
        $req=$database->prepare("SELECT * FROM question WHERE id=:id");
        $req->execute(array("id"=>$this->get_id()));
        $resultat=$req->fetch();
        if(!$resultat){
            //Si elle n'existe pas on la cree
            $req=$database->prepare("INSERT INTO question (id,intitule,id_formulaire,image,visibilite,typequestion,nbCaractereMax)
                                    VALUES (:id,:intitule,:id_formulaire,:image,:visibilite,:typequestion,:nbCaractereMax)");}

        else{
            //Si elle existe on la modifie
            $req=$database->prepare("UPDATE question SET intitule=:intitule,id_formulaire=:id_formulaire,image=:image,visibilite=:visibilite,typequestion=:typequestion,nbCaractereMax=:nbCaractereMax WHERE id=:id");
        }
        $req->execute(array(
            "id"=>$this->get_id(),
            "intitule"=>$this->get_name(),
            "id_formulaire"=>1,
            "image"=>$this->get_image(),
            "visibilite"=>1,
            "typequestion"=>$this->get_type(),
            "nbCaractereMax"=>$this->get_nbCaractereMax()));
    }


}
