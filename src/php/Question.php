<?php 
//On creer l'object Question
class Question{
    //On creer les attributs
    private $id;
    private $name;
    private $image;

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

    public function get_upperhtml(){
        $id=$this->id;
        $html='<section class="container" id="'.$id.'container">
        <section class="carte" id='.$id.'>
            <h2>'.$this->name.'</h2>
            <img src="'.$this->image.'" alt="icone">';
        return $html; }

    public function get_lowerhtml(){
            $html='</section></section>';
            return $html;
        }
    

}
    


//On creer L'objet Question_QCM qui herite de Question
class Question_QCM extends Question{
    //On creer les attributs
    private $listReponse; //Liste des reponses avec leurs couleurs associées [reponse,couleur] 
    private $nbReponseMax; //Nombre de reponse max pour la question

    //On creer le constructeur
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

    }


    //On creer les getters et setters


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

    /**
     * Genere la section html de toute les réponses de la questions en fonction de la liste des réponses
     * et du nombre de réponses max
     */

    function get_html_reponses(){
        //On recupere le type de question 
        //On fait une condition sur une ligne
        $buttontype=($this->get_nbReponseMax()>=2)?"checkbox":"button";       //Si le nombre de reponse max est superieur a 2 alors on met un checkbox sinon on met un button
        $typeQuestion=(count($this->get_listReponse())<2)?"Binaire":"QCM"; 
        $html='<section class="'.$typeQuestion.' reponses" id="'.$this->get_id().'reponses">';

        if ($buttontype=="button"){
            
            for ($i=0;$i<count($this->get_listReponse());$i++){
                $html.='<input id="'.$this->get_id().'rep'.$i.'"
                                class="BoutonReponse'.$typeQuestion.'" 
                                type="'.$buttontype.'" 
                                name="'.$this->get_id().'rep'.$i.'" 
                                value="'.$this->get_listReponse()[$i][0].'" 
                                style="background-color:'.$this->get_listReponse()[$i][1].'">
                        </input>';
            }
        }
        else if ($buttontype=="checkbox"){
            for ($i=0;$i<count($this->get_listReponse());$i++){
                $html.= 
                '<section class=checkboxRep>
                        <input id="'.$this->get_id().'rep'.$i.'" 
                               class="BoutonReponse'.$typeQuestion.'" 
                               type="'.$buttontype.'" 
                               name="'.$this->get_id().'rep'.$i.'"
                               value="true">
                        </input>      
                        <label for="'.$this->get_id().'rep'.$i.'">'.$this->get_listReponse()[$i][0].'</label>
                </section>';
            }
        }
        return $html;
    }

    /**
     * Genere la section html de la partie configuration de la question en fonction de la liste des réponses et du type de question
     */
    function get_html_propriete(){
        $buttontype=($this->get_nbReponseMax()>=2)?"checkbox":"button";
        $html='
        <section class="propriete" id="'.$this->get_id().'propriete">
         <form action="questionUpload.php" method="POST" enctype="multipart/form-data" target="postkeeper">
            <section>
                <label for="intituleCarte">Intitulé de la carte</label>
                <input  type="text" name="'.$this->get_id().'editName" class="editName" id="'.$this->get_id().'editName" value="'.$this->get_name().'" oninput="maj('.$this->get_id().'propriete,'.$this->get_id().')">
                <label for="type" style="display:none">'.$buttontype.'</label>
            </section>
            <section>
                <label for="iconeCarte">Icone de la carte</label>
                <input  type="file" accept="image/*" name="'.$this->get_id().'editIcon" class="editIcon" id="'.$this->get_id().'editIcon" onchange=loadimg('.$this->get_id().'editIcon,'.$this->get_id().')>
            </section>';
    

        if ($buttontype=="button"){
            $html.='<section class="reponses">';
            for ($i=0;$i<count($this->get_listReponse());$i++){
                $html.='
                <section class="btnsettings">
                    <label for="'.$this->get_id().'editRep'.$i.'">Réponse '.($i+1).'</label>
                    <input  type="text" name="'.$this->get_id().'editRep'.$i.'" class="editbtn" id="'.$this->get_id().'editRep'.$i.'" value="'.$this->get_listReponse()[$i][0].'" oninput="maj('.$this->get_id().'propriete,'.$this->get_id().')" >
                    <input  type="color" name="'.$this->get_id().'editColor'.$i.'" class="editbtn" id="'.$this->get_id().'editColor'.$i.'" value="'.$this->get_listReponse()[$i][1].'" oninput="maj('.$this->get_id().'propriete,'.$this->get_id().')">
                </section>';
            }
            $html.='</section>';
        }
        else if ($buttontype=="checkbox"){
            $html.='
            <section>
                <label for="nbReponseMax">Nombre de réponses max</label>
                <input  type="number" name="'.$this->get_id().'editNbRepMax" class="editNbRepMax" id="'.$this->get_id().'editNbRepMax" value="'.$this->get_nbReponseMax().'"  min="1" oninput="maj('.$this->get_id().'propriete,'.$this->get_id().')">
            </section>
            <section class="reponses">';
            for ($i=0;$i<count($this->get_listReponse());$i++){
                $html.='<section class=btnsettings>
                            <label for="'.$this->get_id().'editRep'.$i.'">Réponse '.($i+1).'</label>
                            <input  type="text" name="'.$this->get_id().'editRep'.$i.'" class="editRep" id="'.$this->get_id().'editRep'.$i.'" value="'.$this->get_listReponse()[$i][0].'" oninput="maj('.$this->get_id().'propriete,'.$this->get_id().')">
                        </section>';
            }
            $html.='</section>';
        }
        $html.='
            <section class="addsuppbtn">
                <button type="button" name="'.$this->get_id().'supp" class="suppRep" id="'.$this->get_id().'edit" onClick=suppRep('.$this->get_id().'propriete'.','.$this->get_id().')>Enlever</button>
                <button type="button" name="'.$this->get_id().'add" class="addRep" id="'.$this->get_id().'edit" onClick=addRep('.$this->get_id().'propriete'.','.$this->get_id().') >Ajouter</button>
            </section>';
        $html.='<input type="submit" name="'.$this->get_id().'editSubmit" class="editSubmit" id="'.$this->get_id().'editSubmit" value="Valider">
            </form>';
        

        return $html;


    }






    public function afficher($parametre=false){
        $html=parent::get_upperhtml();
        $html.=$this->get_html_reponses();
        $html.='</section></section>';
        if ($parametre==true) {
            $html.=$this->get_html_propriete();
        }
        $html.='</section></section>';
        return $html;

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


    function afficherQuestion(){
        //a faire

        
    }



}

?>

