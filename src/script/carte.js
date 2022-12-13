  
    
    document.getElementById('addQuestion').addEventListener('submit', function(_event){
        //Le bouton ajouter 
        _event.preventDefault();
        sendall(this);
        this.submit();
    });

    document.getElementById('formsendall').addEventListener('submit', function(_event){
        _event.preventDefault();
        sendall(this);
        this.submit();
        });
    
    function sendall(form){
        var inputs = document.getElementsByTagName("input")
        for(var i = 0; i < inputs.length; i++){
            if(['text','color','number','file'].includes(inputs[i].type)){
                inputs[i].setAttribute("form",form.id);
            }
        }
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
        else if (typereponse=="checkbox"){
            var inputs = prop.querySelectorAll(".editRep");
            var boutons = carte.querySelectorAll("label");
            for (let i = 0; i < inputs.length; i++) {
                boutons[i].innerText = inputs[i].value;
            }
            prop.querySelector(".editNbRepMax").max = inputs.length;
        }

    }
    function loadimg(input,carte){
        //Action lors du changement de l'image
        var file = input.files[0];
        //Si une image était déjà sélectionnée on la supprime du localstorage
        // if (localStorage.getItem(input.id)){ 
        //     localStorage.removeItem(input.id);
        // }
        //Ensuite on ajoute l'image sélectionnée dans le localstorage et on l'affiche
        if (file){
            var url = URL.createObjectURL(file);
            carte.querySelector("img").src = url;
        }
    }



    function addRep(prop,carte){
        typereponse=prop.querySelectorAll('label')[1].textContent;
        var nbBoutons = carte.querySelectorAll("input").length;
        element=prop.querySelector(".reponses");
        section=document.createElement("section");
        section.className="btnsettings";
        console.log(typereponse);
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

