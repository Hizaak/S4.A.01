Questionnaire :
	- Un texte (pour la question)
	- Une liste de cases à cocher (avec un texte associé) (par défaut 2) (minimum 2)
	- Un nombre maximum de cases à cocher (par défaut 1) (minimum 1)

	Exemple :
		Texte : Êtes vous intéressés a l'idée d'avoir un parrain ?
		Liste des cases : Oui, Non, Indifférent
		Nombre maximum : 1

	Affichage : 
		Si un choix max :
			Forme : boutons
			Afficher côte à côte si deux choix seulement, et si on a la place. En colonne sinon.
		Sinon : cases à cocher et afficher en colonne

Question libre :
	- Un texte (pour la question)
	- Un nombre de caractères maximum (par défaut 100)

	Exemple :
		Texte : Quels sont vos loisirs ?
		Maximum : 400

Slider :
	- Un texte (pour la question)
	- Une valeur minimum (par défaut 0)
	- Une valeur maximum (par défaut 100)

	Exemple :
		Texte : résistance à l'alcool
		Minimum : 0
		Maximim : 100

	Affichage : ON PENSE à un affichage dynamique, qui change en fonction d'à quel point on pousse le slider
	Ce que "ON PENSE" signifie :
		 - si on a pas le temps, on fait pas
		 - si on a le temps, on fait
		 - si on a trop de temps, on fait plus