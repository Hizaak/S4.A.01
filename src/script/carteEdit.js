//on ecoute un clique sur tout les boutons de classe ValideeditSubmit et on log l'element



function syncValid(){
    var boutons = document.querySelectorAll(".ValideeditSubmit");
    for (let i = 0; i < boutons.length; i++) {
        boutons[i].addEventListener("click", function () {
            //On recupere tout les inputs de la partie propriété
            idcarte = this.parentNode.parentNode.querySelector(".carte").id;
            intitule = this.parentNode.querySelector(".editName").value;
            visibilite= this.parentNode.querySelector(".editVisibilite").value;
            

            //On recupere le type de la question
            if (this.parentNode.parentNode.querySelector(".carte").querySelector("section").className.includes("QCM")) { type = "QCM"; }
            else { type = "LIBRE"; }

            //On note limit la contraite de la question (nombre de reponse pour un QCM ou nombre de caractere pour une question libre)
            if (type == "QCM") {
                limit = this.parentNode.querySelector(".editNbRepMax").value;
            }
            else {
                limit = this.parentNode.querySelector(".editNbCaractereMax").value;
            }

            //on recupère le base64 de l'image
            image = this.parentNode.parentNode.querySelector(".carte").querySelector("img").src;

            //Si l'input file est vide on met l'image a null
            if (this.parentNode.querySelector(".editIcon").files.length == 0) {
                image = null;
            }

            //On creer un dictionnaire

            proposition = {};
            //On parcours les reponses d'un QCM
            if (type == "QCM") {
                sectionReponse = this.parentNode.querySelectorAll(".btnsettings");
                sectionReponse.forEach(reponse => {
                    attributs = {};
                    text = reponse.querySelector("input[type=text]");
                    color = reponse.querySelector("input[type=color]"); //null si pas de couleur
                    attributs['text'] = text.value;

                    //condition sur une ligne, si color est null alors on met null sinon on met la valeur de color
                    attributs['color'] = color == null ? null : color.value;

                    //on ajoute l'array au dictionnaire avec comme clé l'id de la reponse en enlevant l'id de la carte et le mot edit
                    proposition[text.id.replace(idcarte + "edit", "")] = attributs;
                });
            }

            //On envois le json au serveur par avec ajax
            $.ajax({
                url: "questionUpload.php",
                type: "POST",
                data: { id: idcarte, type, intitule: intitule,visibilite:visibilite,image: image, proposition: proposition, limit: limit },
                success: function (data) {
                    console.log(data); 
                }

            });

        });

    }
}




//On fait une fonction qui attend un évènement de changemet de valeur d'un des inputs
function maj(prop, carte) {
    typereponse = prop.querySelectorAll('label')[1].textContent;
    carte.querySelectorAll("h2")[0].innerText = prop.querySelectorAll(".editName")[0].value;
    if (typereponse == "button") {
        if (prop.querySelector(".editNbRepMax").value > 1) {
            //On transforme les boutons en checkbox si il y a plus d'une réponse possible
            buttonToCheckBox(prop, carte);
            return;
        }

        //On recupère les inputs de la partie propriété des classes editbtn et editRep
        var inputs = prop.querySelectorAll(".editbtn");
        //On récupère les boutons de la carte
        var boutons = carte.querySelectorAll("input[type=button]");
        //on parcours le tableau input
        for (let i = 0; i < inputs.length; i++) {
            //Il y a 2 changements pour un bouton donc on divise par 2 pour avoir le bon bouton
            //on arrondi à l'entier inférieur

            //si l'input est de type text
            if (inputs[i].type == "text") {
                boutons[Math.floor(i / 2)].value = inputs[i].value;
            }
            //si l'input est de type color
            else if (inputs[i].type == "color") {
                boutons[Math.floor(i / 2)].style.backgroundColor = inputs[i].value;
            }
        }
    }
    if (typereponse == "checkbox") {
        if (prop.querySelector(".editNbRepMax").value == 1) {
            //On transforme les checkbox en boutons si il n'y a qu'une réponse possible
            checkBoxToButton(prop, carte);
            return;
        }
        var inputs = prop.querySelector(".reponses").querySelectorAll("input[type=text]");
        var boutons = carte.querySelectorAll("label");
        for (let i = 0; i < inputs.length; i++) {
            boutons[i].innerText = inputs[i].value;
        }
        prop.querySelector(".editNbRepMax").max = inputs.length;
    }
    if (typereponse == "libre") {
        var input = prop.querySelectorAll(".editNbCaractereMax");
        //Si la valeur n'est pas entre 1 et 500 on la met à 500
        if (input[0].value > 500) {
            input[0].value = 500;
        }
        //Si ca commence par - on le met a 1
        if (input[0].value <= -1 || input[0].value == '0') {
            input[0].value = 1;
        }


        carte.querySelector("textarea").setAttribute("maxlength", input[0].value);
        carte.querySelector("textarea").setAttribute("placeholder", "Vous pouvez écrire jusqu'à " + input[0].value + " caractères");
    }

}
function loadimg(input) {
    // On récupère la carte de la propriété
    var img = input.parentNode.parentNode.parentNode.querySelector(".carte").querySelector("img");

    var file = input.files[0];
    var reader = new FileReader();
    reader.onloadend = function() {
        // Si c'est une image PNG, on l'affiche
        if (file.type.match('image/png')) {
            img.src = reader.result;
        }
        // Sinon on affiche une alerte
        else {
            input.value = "";
            alert("Ce n'est pas une image PNG");
        }
    };
    if (file) {
        reader.readAsDataURL(file);
    } else {
        img.src = "";
    }
}






function addRep(prop, carte) {
    typereponse = prop.querySelectorAll('label')[1].textContent;
    element = prop.querySelector(".reponses");
    var nbBoutons = element.childElementCount;
    section = document.createElement("section");
    section.className = "btnsettings";
    if (typereponse == "button") {
        //Création des propriétés du bouton
        label = document.createElement("label");
        label.setAttribute("for", carte.id + "editRep" + (nbBoutons));
        label.innerText = "Réponse " + (nbBoutons + 1);
        section.appendChild(label);
        section.appendChild(document.createTextNode('\u00A0'));
        text = document.createElement("input");
        text.setAttribute("type", "text");
        text.setAttribute("name", carte.id + "editRep" + (nbBoutons));
        text.setAttribute("class", "editbtn");
        text.setAttribute("id", carte.id + "editRep" + (nbBoutons));
        text.setAttribute("value", "Texte");
        text.setAttribute("oninput", "maj(" + prop.id + "," + carte.id + ")");
        section.appendChild(text);
        section.appendChild(document.createTextNode('\u00A0'));
        color = document.createElement("input");
        color.setAttribute("type", "color");
        color.setAttribute("name", carte.id + "editColor" + (nbBoutons));
        color.setAttribute("class", "editbtn");
        color.setAttribute("id", carte.id + "editColor" + (nbBoutons));
        color.setAttribute("value", "#f08026");
        color.setAttribute("oninput", "maj(" + prop.id + "," + carte.id + ")");
        section.appendChild(color);
        element.appendChild(section);


        //Création du bouton dans la carte
        section = carte.querySelector(".reponses");
        bouton = document.createElement("input");
        bouton.setAttribute("type", "button");
        bouton.setAttribute("id", carte.id + "editRep" + (nbBoutons));
        bouton.setAttribute("class", "buttonRep BoutonReponse BoutonReponseQCM");
        bouton.setAttribute("value", text.value);
        bouton.setAttribute("style", "background-color:" + document.getElementById(carte.id + "editColor" + (nbBoutons)).value);
        section.appendChild(bouton);
    }
    else if (typereponse == "checkbox") {
        //Création des propriétés de la checkbox
        label = document.createElement("label");
        label.setAttribute("for", carte.id + "editRep" + (nbBoutons));
        label.innerText = "Réponse " + (nbBoutons + 1);
        section.appendChild(label);
        section.appendChild(document.createTextNode('\u00A0'));
        text = document.createElement("input");
        text.setAttribute("type", "text");
        text.setAttribute("name", carte.id + "editRep" + (nbBoutons));
        text.setAttribute("class", "editbtn");
        text.setAttribute("id", carte.id + "editRep" + (nbBoutons));
        text.setAttribute("value", "Texte");
        text.setAttribute("oninput", "maj(" + prop.id + "," + carte.id + ")");
        section.appendChild(text);
        section.appendChild(document.createTextNode('\u00A0'));
        color = document.createElement("input");
        color.setAttribute("type", "color");
        color.setAttribute("name", carte.id + "editColor" + (nbBoutons));
        color.setAttribute("class", "editbtn");
        color.setAttribute("id", carte.id + "editColor" + (nbBoutons));
        color.setAttribute("value", "#f08026");
        color.setAttribute("oninput", "maj(" + prop.id + "," + carte.id + ")");
        color.setAttribute("style", "display:none")
        section.appendChild(color);
        element.appendChild(section);

        //On recupere l'élement input text qu'on vient de créer
        var input = document.getElementById(carte.id + "editRep" + (nbBoutons));

        //On ajoute une case à cocher à la carte
        zonereponse = carte.querySelector(".reponses");
        secBoxLabel = document.createElement("section");
        secBoxLabel.setAttribute("class", "checkboxRep");
        cac = document.createElement("input");
        cac.setAttribute("type", "checkbox");
        cac.setAttribute("id", carte.id + "editRep" + (nbBoutons));
        cac.setAttribute("class", "BoutonReponseQCM");
        cac.setAttribute("value", "true");
        secBoxLabel.appendChild(cac);
        secBoxLabel.appendChild(document.createTextNode('\u00A0'));

        label = document.createElement("label");
        label.setAttribute("for", carte.id + "editRep" + (nbBoutons));
        label.innerText = input.value;
        secBoxLabel.appendChild(label);
        zonereponse.appendChild(secBoxLabel);
    }
    prop.querySelector(".editNbRepMax").setAttribute("max", nbBoutons + 1);//On fait plus 1 car on a recupéré le nombre de boutons avant d'en ajouter un
}




function suppRep(prop, carte) {
    typereponse = prop.querySelectorAll('label')[1].textContent;
    var inputs = carte.querySelector(".reponses").childElementCount;
    if (inputs <= 2) {
        alert("Il faut au moins 2 réponses");
    }
    else {
        if (typereponse == "button") {
            prop.querySelectorAll(".btnsettings")[inputs - 1].remove();
            carte.querySelectorAll("input[type=button]")[inputs - 1].remove();
        }
        else if (typereponse == "checkbox") {
            prop.querySelectorAll(".btnsettings")[inputs - 1].remove();
            carte.querySelectorAll(".checkboxRep")[inputs - 1].remove();

            //On met à jour le nombre de réponses max si le nombre de réponses max est supérieur
            //au nombre de réponses genre si on a 3 réponses avec 3 réponses max et qu'on en supprime une on met le nombre de réponses max à 2
            if (prop.querySelector(".editNbRepMax").value > inputs - 1) {
                prop.querySelector(".editNbRepMax").value = inputs - 1;
            }
        }
    }
    nbBoutons = prop.querySelector(".reponses").childElementCount;
    prop.querySelector(".editNbRepMax").setAttribute("max", nbBoutons); //On ajoute pas 1 car on a recupéré le nombre de boutons apres sa suppression


}



function buttonToCheckBox(prop, carte) {
    //On display none les inputs color
    var inputs = prop.querySelectorAll("input[type=color]");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].style.display = "none";
    }
    var section = carte.querySelector(".reponses");
    var boutons = section.querySelectorAll("input[type=button]");
    for (var i = 0; i < boutons.length; i++) {
        //On recupère le text du bouton pour le mettre dans le label
        //on crée une nouvelle section de réponses avec un checkbox et un label
        var secBox = document.createElement("section");
        secBox.setAttribute("class", "checkboxRep");
        cac = document.createElement("input");
        cac.setAttribute("type", "checkbox");
        cac.setAttribute("class", "BoutonReponseQCM");
        secBox.appendChild(cac);
        secBox.appendChild(document.createTextNode('\u00A0'));

        label = document.createElement("label");
        label.setAttribute("for", carte.id + "editRep" + i);
        label.innerText = boutons[i].value;
        secBox.appendChild(label);
        section.appendChild(secBox);

        prop.querySelectorAll('label')[1].textContent = "checkbox";
        //On supprime le bouton
        boutons[i].remove();
    }
    //On ajoute un bouton suivant
    var bouton = document.createElement("input");
    bouton.setAttribute("type", "button");
    bouton.setAttribute("class", "next");
    bouton.setAttribute("value", "Suivant");
    bouton.setAttribute("name", carte.id + "next");
    bouton.disabled = true;
    carte.appendChild(bouton);


}


function checkBoxToButton(prop, carte) {
    //On display none les inputs color
    var inputs = prop.querySelectorAll("input[type=color]");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].style.display = "inline-block";
    }
    var section = carte.querySelector(".reponses");
    var cac = section.querySelectorAll("input[type=checkbox]");
    for (var i = 0; i < cac.length; i++) {
        //On recupère le text du bouton pour le mettre dans le label
        //on crée une nouvelle section de réponses avec un checkbox et un label
        var bouton = document.createElement("input");
        bouton.setAttribute("type", "button");
        bouton.setAttribute("class", "buttonRep BoutonReponse BoutonReponseQCM");
        bouton.setAttribute("value", cac[i].nextSibling.nextSibling.textContent);
        bouton.setAttribute("style", "background-color:" + document.getElementById(carte.id + "editColor" + i).value);
        section.appendChild(bouton);

        prop.querySelectorAll('label')[1].textContent = "button";
        //On supprime le bouton
        cac[i].parentNode.remove();
    }
    //On supprime le bouton suivant
    carte.querySelector(".next").remove();
}

//On fait un event listener sur le bouton d'ajoout d'une carte 
document.getElementById("ajoutCarteBouton").addEventListener("click", function () {
    //On recupère le type de la carte souhaité avec le select qui est frere du bouton
    var type = this.previousElementSibling.value;
    $.ajax({
        url: "creationFormulaire.php",
        type: "POST",
        data: {
            ajoutCarte: type
        },
        success: function (data) {
            //DATA est du on le met juste au dessus de la section de class fb-ajout
            document.querySelector(".fb-ajout").insertAdjacentHTML("beforebegin", data);
            syncValid();
            synDelete();
            if(type=="libre")
            {
                //On reload la page pour le moment
                location.reload();
            }

        }
    });

});

//On fait un event listener sur le bouton de suppression d'une carte sur les span de class delete
function synDelete(){
    var sup = document.querySelectorAll(".delete");
    for (var i = 0; i < sup.length; i++) {
        sup[i].addEventListener("click", supQuestion);
    }
}
function supQuestion(){
    var id = this.id;
    //On supprime la section d'id id+container
    $.ajax({
        url: "creationFormulaire.php",
        type: "POST",
        data: {
            supQuestion: id
        },
        success: function (data) {
            //DATA est du on le met juste au dessus de la section de class fb-ajout
            document.getElementById(id+"container").remove();
        }
    });
}
syncValid();
synDelete()