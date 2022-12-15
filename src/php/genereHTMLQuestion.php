<?php
require "Question.php";

abstract class ReprQuestion{
    protected Question $question ;

    /**
     * @brief Constructeur de la classe ReprQuestionQCM
     * @details Constructeur de la classe ReprQuestionQCM
     * @param Question $question question à représenter
     * @throws Exception si la question n'est pas de type QCM
     * @return void
     * @see Question
     */
    public function __construct($question){
        //Si le type de la question n'est pas QCM, on lève une exception
        $this->question = $question;
        
    }

    /**
     * @brief Fonction qui génère le début du code html de la carte de la question
     * @details Fonction qui génère le début du code html de la carte de la question
     * @return string code html du début de la carte de la question
     */

    public function get_html($parametre=false){
        $html='<section class="container" id="'.$this->question->get_id().'container">
            <section class="carte" id='.$this->question->get_id().'>
                <h2>'.$this->question->get_name().'</h2>
                <img src="'.$this->question->get_image().'" alt="icone">';

        $html.=$this->get_html_reponses();
        $html.='</section></section>';
        if ($parametre==true) {
            $html.=$this->get_html_propriete();
        }
        $html.='</section></section></section></section>';
        return $html;
    
    }
}



/** 
 * @brief Classe représentant une question QCM en html
 * @details Classe représentant une question QCM générant du code html
 * @author ndargazan001
 * @version 1.0
 * @date 2022-12-14 
*/
class ReprQuestionQCM extends ReprQuestion{

    /**
     * @brief Constructeur de la classe ReprQuestionQCM
     * @details Constructeur de la classe ReprQuestionQCM
     * @param Question $question question à représenter
     * @return void
     * @see Question
     */
    public function __construct($question){
        parent::__construct($question);
    }


    /**
     * @brief Fonction qui génère le code html de la carte en entier
     * @details Fonction qui génère le code html de la carte en entier
     * @return string code html de la carte
     */
    






    /**
     * @brief Fonction qui génère le code html de la section de réponse de la carte
     * @details Fonction qui génère le code html de la section de réponse de la carte
     * @return string code html de la section de réponse de la carte
     * @see Question_QCM
     * @
     */
    function get_html_reponses(){
        //On recupere le type de question (QCM ou Binaire)
        $buttontype=($this->question->get_nbReponseMax()>=2)?"checkbox":"button";       //Si le nombre de reponse max est superieur a 2 alors on met un checkbox sinon on met un button
        $typeQuestion=(count($this->question->get_listReponse())<2)?"Binaire":"QCM"; 
        $html='<section class="'.$typeQuestion.' reponses" id="'.$this->question->get_id().'reponses">';

        if ($buttontype=="button"){
            
            for ($i=0;$i<count($this->question->get_listReponse());$i++){
                $html.='<input id="'.$this->question->get_id().'rep'.$i.'"
                                class="BoutonReponse'.$typeQuestion.'" 
                                type="'.$buttontype.'" 
                                name="'.$this->question->get_id().'rep'.$i.'" 
                                value="'.$this->question->get_listReponse()[$i][0].'" 
                                style="background-color:'.$this->question->get_listReponse()[$i][1].'">
                        </input>';
            }
        }
        else if ($buttontype=="checkbox"){
            for ($i=0;$i<count($this->question->get_listReponse());$i++){
                $html.= 
                '<section class=checkboxRep>
                        <input id="'.$this->question->get_id().'rep'.$i.'" 
                               class="BoutonReponse'.$typeQuestion.'" 
                               type="'.$buttontype.'" 
                               name="'.$this->question->get_id().'rep'.$i.'"
                               value="true">
                        </input>      
                        <label for="'.$this->question->get_id().'rep'.$i.'">'.$this->question->get_listReponse()[$i][0].'</label>
                </section>';
            }
        }
        return $html;
    }

    function get_html_propriete(){
        $buttontype=($this->question->get_nbReponseMax()>=2)?"checkbox":"button";
        $html='
        <section class="propriete" id="'.$this->question->get_id().'propriete">
            <section>
                <label for="intituleCarte">Intitulé de la carte</label>
                <input  type="text" name="'.$this->question->get_id().'editName" class="editName" id="'.$this->question->get_id().'editName" value="'.$this->question->get_name().'" oninput="maj('.$this->question->get_id().'propriete,'.$this->question->get_id().')">
                <label for="type" style="display:none">'.$buttontype.'</label>
            </section>
            <section>
                <label for="iconeCarte">Icone de la carte</label>
                <input  type="file" accept="image/*" name="'.$this->question->get_id().'editIcon" class="editIcon" id="'.$this->question->get_id().'editIcon" onchange=loadimg('.$this->question->get_id().'editIcon,'.$this->question->get_id().')>
            </section>';
    

        if ($buttontype=="button"){
            $html.='<section class="reponses">';
            for ($i=0;$i<count($this->question->get_listReponse());$i++){
                $html.='
                <section class="btnsettings">
                    <label for="'.$this->question->get_id().'editRep'.$i.'">Réponse '.($i+1).'</label>
                    <input  type="text" name="'.$this->question->get_id().'editRep'.$i.'" class="editbtn" id="'.$this->question->get_id().'editRep'.$i.'" value="'.$this->question->get_listReponse()[$i][0].'" oninput="maj('.$this->question->get_id().'propriete,'.$this->question->get_id().')" >
                    <input  type="color" name="'.$this->question->get_id().'editColor'.$i.'" class="editbtn" id="'.$this->question->get_id().'editColor'.$i.'" value="'.$this->question->get_listReponse()[$i][1].'" oninput="maj('.$this->question->get_id().'propriete,'.$this->question->get_id().')">
                </section>';
            }
            $html.='</section>';
        }
        else if ($buttontype=="checkbox"){
            $html.='
            <section>
                <label for="nbReponseMax">Nombre de réponses max</label>
                <input  type="number" name="'.$this->question->get_id().'editNbRepMax" class="editNbRepMax" id="'.$this->question->get_id().'editNbRepMax" value="'.$this->question->get_nbReponseMax().'"  min="1" oninput="maj('.$this->question->get_id().'propriete,'.$this->question->get_id().')">
            </section>
            <section class="reponses">';
            for ($i=0;$i<count($this->question->get_listReponse());$i++){
                $html.='<section class=btnsettings>
                            <label for="'.$this->question->get_id().'editRep'.$i.'">Réponse '.($i+1).'</label>
                            <input  type="text" name="'.$this->question->get_id().'editRep'.$i.'" class="editRep" id="'.$this->question->get_id().'editRep'.$i.'" value="'.$this->question->get_listReponse()[$i][0].'" oninput="maj('.$this->question->get_id().'propriete,'.$this->question->get_id().')">
                        </section>';
            }
            $html.='</section>';
        }
        $html.='
            <section class="addsuppbtn">
                <button type="button" name="'.$this->question->get_id().'supp" class="suppRep" id="'.$this->question->get_id().'edit" onClick=suppRep('.$this->question->get_id().'propriete'.','.$this->question->get_id().')>Enlever</button>
                <button type="button" name="'.$this->question->get_id().'add" class="addRep" id="'.$this->question->get_id().'edit" onClick=addRep('.$this->question->get_id().'propriete'.','.$this->question->get_id().') >Ajouter</button>
            </section>';
        $html.='<input type="submit" name="'.$this->question->get_id().'editSubmit" class="editSubmit" id="'.$this->question->get_id().'editSubmit" value="Valider">';
        

        return $html;
    }
}


class ReprQuestionLIBRE extends ReprQuestion{
    function get_html_reponses(){
        $html='
            <section class="reponselibre">
                <textarea name="'.$this->question->get_id().'rep" class="inputReponseLibre" id="'.$this->question->get_id().'rep" placeholder="Vous pouvez écrire jusqu\'à '.$this->question->get_nbCaractereMax().' caractères" maxlength="'.$this->question->get_nbCaractereMax().'"></textarea>
            </section>
        <section class="suivant">
            <input type="button" name="'.$this->question->get_id().'next" class="next" id="'.$this->question->get_id().'next" value="Suivant" onClick=next('.$this->question->get_id().')>';

    
        return $html;
    }

    function get_html_propriete(){
        $html='
        <section class="propriete" id="'.$this->question->get_id().'propriete">
            <section>
                <label for="intituleCarte">Intitulé de la carte</label>
                <input  type="text" name="'.$this->question->get_id().'editName" class="editName" id="'.$this->question->get_id().'editName" value="'.$this->question->get_name().'" oninput="maj('.$this->question->get_id().'propriete,'.$this->question->get_id().')">
                <label for="type" style="display:none">libre</label>
            </section>
            <section>
                <label for="iconeCarte">Icone de la carte</label>
                <input  type="file" accept="image/*" name="'.$this->question->get_id().'editIcon" class="editIcon" id="'.$this->question->get_id().'editIcon" onchange=loadimg('.$this->question->get_id().'editIcon,'.$this->question->get_id().')>
            </section>
            <section>
                <label for="nbCaractereMax">Nombre de caractère max</label>
                <input  type="number" name="'.$this->question->get_id().'editNbCaractereMax" class="editNbCaractereMax" id="'.$this->question->get_id().'editNbCaractereMax" value="'.$this->question->get_nbCaractereMax().'"  min="1" max="500" oninput="maj('.$this->question->get_id().'propriete,'.$this->question->get_id().')">
            </section>
            <input type="submit" name="'.$this->question->get_id().'editSubmit" class="editSubmit" id="'.$this->question->get_id().'editSubmit" value="Valider">
        </section>';
        return $html;
    }

}