//on ecoute un clique sur tout les boutons de classe ValideeditSubmit et on log l'element




var boutons = document.querySelectorAll(".ValideeditSubmit");
for (let i = 0; i < boutons.length; i++) {  
    boutons[i].addEventListener("click", function(){
        //On recupere tout les inputs de la partie propriété
        idcarte=this.parentNode.parentNode.querySelector(".carte").id;
        ititule=this.parentNode.querySelector(".editName").value;

        //On recupere le type de la question
        if (this.parentNode.parentNode.querySelector(".carte").querySelector("section").className.includes("QCM")){type="QCM";}
        else{type="LIBRE";}

        //On note limit la contraite de la question (nombre de reponse pour un QCM ou nombre de caractere pour une question libre)
        if(type=="QCM"){
            limit=this.parentNode.querySelector(".editNbRepMax").value;
        }
        else{
            limit=this.parentNode.querySelector(".editNbCaractereMax").value;
        }

        //on recupère le base64 de l'image
        image = this.parentNode.parentNode.querySelector(".carte").querySelector("img").src;
        if (image.includes("/sources/images/imgplaceholder.jpg")){
            image=null;
        }

        //On creer un dictionnaire
        
        proposition={};
        //On parcours les reponses d'un QCM
        if (type=="QCM"){
            sectionReponse=this.parentNode.querySelectorAll(".btnsettings");
            sectionReponse.forEach(reponse =>{
                attributs={};
                text=reponse.querySelector("input[type=text]");
                color=reponse.querySelector("input[type=color]"); //null si pas de couleur
                attributs['text']=text.value;
                
                //condition sur une ligne, si color est null alors on met null sinon on met la valeur de color
                attributs['color']=color==null?null:color.value;

                //on ajoute l'array au dictionnaire avec comme clé l'id de la reponse en enlevant l'id de la carte et le mot edit
                proposition[text.id.replace(idcarte+"edit","")]=attributs;
            });
        }
        
        //On envois le json au serveur par avec ajax
        $.ajax({
            url:"questionUpload.php",
            type:"POST",
            data:{id:idcarte,type,ititule:ititule,image:image,proposition:proposition,limit:limit},
            success:function(data){
                console.log(data);
                //Ne pas oublier l'input de visibilité 
            }

        });

    });

}
        
    
    
    
    
    //On fait une fonction qui attend un évènement de changemet de valeur d'un des inputs
    function maj(prop,carte){
        typereponse=prop.querySelectorAll('label')[1].textContent;
        carte.querySelector("h2").innerText = prop.querySelector(".editName").value;
        if (typereponse=="button"){
            //On recupère les input de la partie propriété
            var inputs = prop.querySelectorAll(".editbtn");
            //On récupère les boutons de la carte
            var boutons = carte.querySelectorAll("input[type=button]");
            //on parcours le tableau input
            for (let i = 0; i < inputs.length; i++) {
                //Il y a 2 changement pour un bouton donc on divise par 2 pour avoir le bon bouton
                //si l'input est de type text
                //on arrondi à l'entier inférieur
                
                if(inputs[i].type == "text"){
                    boutons[Math.floor(i/2)].value = inputs[i].value;
                }
                //si l'input est de type color
                else if(inputs[i].type == "color"){
                    boutons[Math.floor(i/2)].style.backgroundColor = inputs[i].value;
                }
            }
        }
        if (typereponse=="checkbox"){
            var inputs = prop.querySelectorAll(".editRep");
            var boutons = carte.querySelectorAll("label");
            for (let i = 0; i < inputs.length; i++) {
                boutons[i].innerText = inputs[i].value;
            }
            prop.querySelector(".editNbRepMax").max = inputs.length;
        }
        if (typereponse=="libre"){
            var input = prop.querySelectorAll(".editNbCaractereMax");
            //Si la valeur n'est pas entre 1 et 500 on la met à 500
            if (input[0].value>500){
                input[0].value=500;
            }
            //Si ca commence par - on le met a 1
            if (input[0].value<=-1 || input[0].value=='0'){
                input[0].value=1;
            }


            carte.querySelector("textarea").setAttribute("maxlength",input[0].value);
            carte.querySelector("textarea").setAttribute("placeholder","Vous pouvez écrire jusqu'à "+input[0].value+" caractères");
        }

    }
    function loadimg(input){
        //On recupère la carte de la propriété
        var img = input.parentNode.parentNode.parentNode.querySelector(".carte").querySelector("img");

        var file = input.files[0];
        var reader = new FileReader();
        reader.onloadend = function(){
            //si c'est une image on l'affiche
            if (file.type.match('image.*')){
                img.src = reader.result;
            }
            //sinon on affiche une alerte
            else{
                input.value="";
                alert("Ce n'est pas une image");

            }

        }
        if(file){
            reader.readAsDataURL(file);
        }
        else{
            img.src ="";
        };
    }




    function addRep(prop,carte){
        typereponse=prop.querySelectorAll('label')[1].textContent;
        var nbBoutons = carte.querySelectorAll("input").length;
        element=prop.querySelector(".reponses");
        section=document.createElement("section");
        section.className="btnsettings";
        if (typereponse=="button"){
            //On créer les nouveaux inputs avec les commandes JS car le HTML ne permet pas de créer des inputs dynamiquement (On sais pas pourquoi)
                label=document.createElement("label");
                label.setAttribute("for",carte.id+"editRep"+(nbBoutons));
                label.innerText="Réponse "+(nbBoutons+1);
            section.appendChild(label);
            section.appendChild(document.createTextNode( '\u00A0' ) );
                text=document.createElement("input");
                text.setAttribute("type","text");
                text.setAttribute("name",carte.id+"editRep"+(nbBoutons));
                text.setAttribute("class","editbtn");
                text.setAttribute("id",carte.id+"editRep"+(nbBoutons));
                text.setAttribute("value","Texte");
                text.setAttribute("oninput","maj("+prop.id+","+carte.id+")");
            section.appendChild(text);
            section.appendChild(document.createTextNode( '\u00A0' ) );
                color=document.createElement("input");
                color.setAttribute("type","color");
                color.setAttribute("name",carte.id+"editColor"+(nbBoutons));
                color.setAttribute("class","editbtn");
                color.setAttribute("id",carte.id+"editColor"+(nbBoutons));
                color.setAttribute("value","#f08026");
                color.setAttribute("oninput","maj("+prop.id+","+carte.id+")");
            section.appendChild(color); 
            element.appendChild(section);         
            //On recupere l'élement input text qu'on vient de créer
            //On ajoute un bouton à la carte

            //On recupère le premier bouton de la carte pour récuperer sa classe (dans le cas ou on change le nom un jour)
            var boutonTemoin = carte.querySelector("input");

            //Là par contre ca marche marche tres bien en l'ajoutant par HTML
                section=carte.querySelector(".reponses");
                    bouton=document.createElement("input");
                    bouton.setAttribute("type","button");
                    bouton.setAttribute("class",boutonTemoin.className);
                    bouton.setAttribute("value",text.value);
                    bouton.setAttribute("style","background-color:"+document.getElementById(carte.id+"editColor"+(nbBoutons)).value);
                section.appendChild(bouton);    
        } 
        else if(typereponse=="checkbox"){
                label=document.createElement("label");
                label.setAttribute("for",carte.id+"editRep"+(nbBoutons));
                label.innerText="Réponse "+(nbBoutons+1);
            section.appendChild(label);
            section.appendChild(document.createTextNode( '\u00A0' ) );
                text=document.createElement("input");
                text.setAttribute("type","text");
                text.setAttribute("name",carte.id+"editRep"+(nbBoutons));
                text.setAttribute("class","editRep");
                text.setAttribute("id",carte.id+"editRep"+(nbBoutons));
                text.setAttribute("value","Texte");
                text.setAttribute("oninput","maj("+prop.id+","+carte.id+")");
            section.appendChild(text);
            element.appendChild(section);

            //On recupere l'élement input text qu'on vient de créer
            var input = document.getElementById(carte.id+"editRep"+(nbBoutons));
    
            //On ajoute une case à cocher à la carte
            var cacTemoin = carte.querySelector("input");
            zonereponse=carte.querySelector(".reponses");
                secBoxLabel=document.createElement("section");
                secBoxLabel.setAttribute("class","checkboxRep");
                    cac=document.createElement("input");
                    cac.setAttribute("type","checkbox");
                    cac.setAttribute("class",cacTemoin.className);
                    cac.setAttribute("value","true");
                secBoxLabel.appendChild(cac);
                secBoxLabel.appendChild(document.createTextNode( '\u00A0' ) );

                label=document.createElement("label");
                label.setAttribute("for",carte.id+"editRep"+(nbBoutons));
                label.innerText=input.value;
                secBoxLabel.appendChild(label);
            zonereponse.appendChild(secBoxLabel);
        }
     maj(prop,carte);
}






    function suppRep(prop,carte){
        typereponse=prop.querySelectorAll('label')[1].textContent;

        if (typereponse=="button"){
            var inputs = carte.querySelectorAll("input[type=button]").length;
            if (inputs>2){
                prop.querySelectorAll(".btnsettings")[inputs-1].remove();
                carte.querySelectorAll("input[type=button]")[inputs-1].remove();
            }
            else{
                alert("Il faut au moins 2 réponses");
            }
        }
        else if (typereponse=="checkbox"){
            var inputs = carte.querySelectorAll("input[type=checkbox]").length;
            if (inputs>2){
                prop.querySelectorAll(".btnsettings")[inputs-1].remove();
                carte.querySelectorAll(".checkboxRep")[inputs-1].remove();
            }
            else{
                alert("Il faut au moins 2 réponses");
            }
        }
        maj(prop,carte);

    }
