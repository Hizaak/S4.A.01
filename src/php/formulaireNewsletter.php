<html>
    <head> 
        <title>Formulaire d'inscription à la newsletter</title>
        <link rel="stylesheet" href="../style/styleNewsletter.css" type="text/css" media="screen" />
    </head>

    <body>
        <main>
            <!-- Croix pour fermer -->
            <h1>Inscrivez-vous à notre <rouge>newsletter</rouge> !</h1>
            <p id="sous-titre">Vous recevrez au maximum un email par semaine vous mettant au courant de nos dernières publications.</p>
            <form action="traitementNewsletter.php" method="post">
                <input id="saisieMail" type="text" name="email" id="email" placeholder="exemple@email.fr"/>
                <input id="boutonSAbonner" type="submit" value="Je m'inscris !" />
            </form>
            <div id="mentions">
                <!-- checkbox -->
                <div id="validationPolitique">
                    <input id="checkbox" type="checkbox" name="mentions" id="mentions" /> 
                    <p id="politique">J'ai pris connaissance de la <a href="">Politique de confidentialité</a>.</p><br>
                </div>
                <p>Les données recueillies sont uniquement destinées à l'envoi de la newsletter.
                    <br> Vous pouvez vous désabonner à tout moment en cliquant sur le lien de désabonnement présent dans chaque email.</p>
            </div>
        </main>
        <a href="../index.php"><img id="croix" src="../sources/icons/croixFermer.png" alt="Croix pour fermer"></a>
    </body>

</html>