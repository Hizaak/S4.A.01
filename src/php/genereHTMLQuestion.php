<?php
include_once "Question.php";

abstract class ReprQuestion
{
    protected Question $question;

    /**
     * @brief Constructeur de la classe ReprQuestionQCM
     * @details Constructeur de la classe ReprQuestionQCM
     * @param Question $question question à représenter
     * @throws Exception si la question n'est pas de type QCM
     * @return void
     * @see Question
     */
    public function __construct($question)
    {
        //Si le type de la question n'est pas QCM, on lève une exception
        $this->question = $question;
    }

    static public function get_instance($question)
    {
        if ($question->get_type() == "QCM") {
            return new ReprQuestionQCM($question);
        } else if ($question->get_type() == "LIBRE") {
            return new ReprQuestionLibre($question);
        } else {
            throw new Exception("Le type de la question n'est pas reconnu");
        }
    }

    /**
     * @brief Fonction qui génère le début du code html de la carte de la question
     * @details Fonction qui génère le début du code html de la carte de la question
     * @return string code html du début de la carte de la question
     */

    public function get_html($parametre = false)
    {
        $html = '<section class="container" id="' . $this->question->get_id_html() . 'container">
            <section class="carte" id=' . $this->question->get_id_html() . '>
                <h2>' . $this->question->get_name() . '</h2>
                <img  id="' . $this->question->get_id_html() . 'Image" src="' . $this->question->get_image() . '" alt="icone">';

        $html .= $this->get_html_reponses();
        $html .= '</section></section>';
        if ($parametre == true) {
            $html .= $this->get_html_propriete();
        }
        $html .= '</section></section></section></section>';
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
class ReprQuestionQCM extends ReprQuestion
{

    /**
     * @brief Constructeur de la classe ReprQuestionQCM
     * @details Constructeur de la classe ReprQuestionQCM
     * @param Question $question question à représenter
     * @return void
     * @see Question
     */
    public function __construct($question)
    {
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
    function get_html_reponses()
    {
        //On recupere le type de question (QCM ou Binaire)
        $buttontype = ($this->question->get_nbReponseMax() >= 2) ? "checkbox" : "button";       //Si le nombre de reponse max est superieur a 2 alors on met un checkbox sinon on met un button
        $typeQuestion = (count($this->question->get_listPropositions()) < 2) ? "Binaire" : "QCM";
        $html = '<section class="' . $typeQuestion . ' reponses" id="' . $this->question->get_id_html() . 'reponses">';

        if ($buttontype == "button") {

            for ($i = 0; $i < count($this->question->get_listPropositions()); $i++) {
                $html .= '<input id="' . $this->question->get_id_html() . 'rep' . $i . '"
                                class="BoutonReponse BoutonReponse' . $typeQuestion . '" 
                                type="' . $buttontype . '" 
                                name="' . $this->question->get_id_html() . 'rep' . $i . '" 
                                value="' . $this->question->get_listPropositions()[$i][0] . '" 
                                style="background-color:' . $this->question->get_listPropositions()[$i][1] . '">
                        </input>';
            }
        } else if ($buttontype == "checkbox") {
            for ($i = 0; $i < count($this->question->get_listPropositions()); $i++) {
                $html .=
                    '<section class=checkboxRep>
                        <input id="' . $this->question->get_id_html() . 'rep' . $i . '" 
                               class="BoutonReponse BoutonReponse' . $typeQuestion . '" 
                               type="' . $buttontype . '" 
                               name="' . $this->question->get_id_html() . 'rep' . $i . '"
                               value="true">
                        </input>      
                        <label for="' . $this->question->get_id_html() . 'rep' . $i . '">' . $this->question->get_listPropositions()[$i][0] . '</label>
                </section>';
            }
            $html .= '</section>
            <section class="suivant">
                <input data-maxReponse="' . $this->question->get_nbReponseMax() . '" type="button" name="' . $this->question->get_id_html() . 'next" class="next" id="' . $this->question->get_id_html() . 'next" value="Suivant" disabled>';
        }
        return $html;
    }

    function get_html_propriete()
    {
        $buttontype = ($this->question->get_nbReponseMax() >= 2) ? "checkbox" : "button";
        $html = '
        <section class="propriete" id="' . $this->question->get_id_html() . 'propriete">
            <section class="supprimer">
            <span name="' . $this->question->get_id_html() . 'delete" class="delete" id="' . $this->question->get_id_html() .'">❌</span>
            </section>
            <section>
                <label for="intituleCarte">Intitulé de la carte</label>

                <input  type="text" name="' . $this->question->get_id_html() . 'editName" class="editName" id="' . $this->question->get_id_html() . 'editName" value="' . $this->question->get_name() . '" oninput="maj(' . $this->question->get_id_html() . 'propriete,' . $this->question->get_id_html() . ')">
                <label for="type" style="display:none">' . $buttontype . '</label>
            </section>
            <section>
                <label for="iconeCarte">Icone de la carte</label>
                <input  type="file" accept="image/png" name="' . $this->question->get_id_html() . 'editIcon" class="editIcon" id="' . $this->question->get_id_html() . 'editIcon" onchange=loadimg(' . $this->question->get_id_html() . 'editIcon)>
            </section>
            <section>
            <label for="visibilite">Visibilité de la carte</label>
                <select name="' . $this->question->get_id_html() . 'editVisibilite" class="editVisibilite" id="' . $this->question->get_id_html() . 'editVisibilite" onchange="maj(' . $this->question->get_id_html() . 'propriete,' . $this->question->get_id_html() . ')">
                    <option value="filleul" ' . (($this->question->get_visibilite() == "1") ? "selected" : "") . '>filleul</option>
                    <option value="parrain" ' . (($this->question->get_visibilite() == "2") ? "selected" : "") . '>parrain</option>
                    <option value="tous" ' . (($this->question->get_visibilite() == "all") ? "selected" : "") . '>tous</option>
                </select>
            </section>
            <section>   
                <label for="nbReponseMax">Nombre de réponses max</label>
                <input  type="number" name="' . $this->question->get_id_html() . 'editNbRepMax" class="editNbRepMax" id="' . $this->question->get_id_html() . 'editNbRepMax" value="' . $this->question->get_nbReponseMax() . '"  min="1" max="' . ($this->question->get_nbReponseMax() + 1) . '" oninput="maj(' . $this->question->get_id_html() . 'propriete,' . $this->question->get_id_html() . ')">
            </section>
        ';



        $html .= '
        <section class="reponses">';
        for ($i = 0; $i < count($this->question->get_listPropositions()); $i++) {
            $html .= '
            <section class="btnsettings">
                <label for="' . $this->question->get_id_html() . 'editRep' . $i . '">Réponse ' . ($i + 1) . '</label>
                <input  type="text" name="' . $this->question->get_id_html() . 'editRep' . $i . '" class="editbtn" id="' . $this->question->get_id_html() . 'editRep' . $i . '" value="' . $this->question->get_listPropositions()[$i][0] . '" oninput="maj(' . $this->question->get_id_html() . 'propriete,' . $this->question->get_id_html() . ')" >
                <input type="color" name="' . $this->question->get_id_html() . 'editColor' . $i . '" class="editbtn editRep" id="' . $this->question->get_id_html() . 'editColor' . $i . '" value="' . $this->question->get_listPropositions()[$i][1] . '" oninput="maj(' . $this->question->get_id_html() . 'propriete,' . $this->question->get_id_html() . ')"
                ';
            if ($buttontype == "checkbox") {
                $html .= 'style=display:none';
            }
            $html .= '>
            </section>';
        }
        $html .= '<br></section>
            <section class="addsuppbtn">
                <button type="button" name="' . $this->question->get_id_html() . 'supp" class="suppRep" id="' . $this->question->get_id_html() . 'edit" onClick=suppRep(' . $this->question->get_id_html() . 'propriete' . ',' . $this->question->get_id_html() . ')>Enlever</button>
                <button type="button" name="' . $this->question->get_id_html() . 'add" class="addRep" id="' . $this->question->get_id_html() . 'edit" onClick=addRep(' . $this->question->get_id_html() . 'propriete' . ',' . $this->question->get_id_html() . ') >Ajouter</button>
            </section>';
        $html .= '<input type="submit" name="' . $this->question->get_id_html() . 'editSubmit" class="ValideeditSubmit" id="' . $this->question->get_id_html() . 'editSubmit" value="Valider">';


        return $html;
    }
}


class ReprQuestionLIBRE extends ReprQuestion
{
    function get_html_reponses()
    {
        $html = '
            <section class="reponselibre">
                <textarea name="' . $this->question->get_id_html() . 'rep" class="inputReponseLibre" id="' . $this->question->get_id_html() . 'rep" placeholder="Vous pouvez écrire jusqu\'à ' . $this->question->get_nbCaractereMax() . ' caractères" maxlength="' . $this->question->get_nbCaractereMax() . '"></textarea>
            </section>
        <section class="suivant">
            <input data-maxCar ="'.$this->question->get_nbCaractereMax().'" type="button" name="' . $this->question->get_id_html() . 'next" class="next" id="' . $this->question->get_id_html() . 'next" value="Suivant" disabled>';


        return $html;
    }

    function get_html_propriete()
    {
        $html = '
        <section class="propriete" id="' . $this->question->get_id_html() . 'propriete">
            <section class="supprimer">
                <span name="' . $this->question->get_id_html() . 'delete" class="delete" id="' . $this->question->get_id_html() .'">❌</span>
            </section>
            <section>
                <label for="intituleCarte">Intitulé de la carte</label>
                <input  type="text" name="' . $this->question->get_id_html() . 'editName" class="editName" id="' . $this->question->get_id_html() . 'editName" value="' . $this->question->get_name() . '" oninput="maj(' . $this->question->get_id_html() . 'propriete,' . $this->question->get_id_html() . ')">
                <label for="type" style="display:none">libre</label>
            </section>
            <section>
                <label for="iconeCarte">Icone de la carte</label>
                <input  type="file" accept="image/png" name="' . $this->question->get_id_html() . 'editIcon" class="editIcon" id="' . $this->question->get_id_html() . 'editIcon" onchange=loadimg(' . $this->question->get_id_html() . 'editIcon,' . $this->question->get_id_html() . ')>
            </section>
            <section>
            <label for="visibilite">Visibilité de la carte</label>
                <select name="' . $this->question->get_id_html() . 'editVisibilite" class="editVisibilite" id="' . $this->question->get_id_html() . 'editVisibilite" onchange="maj(' . $this->question->get_id_html() . 'propriete,' . $this->question->get_id_html() . ')">
                    <option value="filleul" ' . (($this->question->get_visibilite() == "1") ? "selected" : "") . '>filleul</option>
                    <option value="parrain" ' . (($this->question->get_visibilite() == "2") ? "selected" : "") . '>parrain</option>
                    <option value="tous" ' . (($this->question->get_visibilite() == "all") ? "selected" : "") . '>tous</option>
                </select>
            </section>
            <section>
                <label for="nbCaractereMax">Nombre de caractère max</label>
                <input  type="number" name="' . $this->question->get_id_html() . 'editNbCaractereMax" class="editbtn editNbCaractereMax" id="' . $this->question->get_id_html() . 'editNbCaractereMax" value="' . $this->question->get_nbCaractereMax() . '"  min="1" max="500" oninput="maj(' . $this->question->get_id_html() . 'propriete,' . $this->question->get_id_html() . ')">
            </section>
            <br> 
            <input type="submit" name="' . $this->question->get_id_html() . 'editSubmit" class="ValideeditSubmit" id="' . $this->question->get_id_html() . 'editSubmit" value="Valider">
        </section>';
        return $html;
    }
}
