import json

#ouverture du json contenant les réponses

with open('RepTest.json') as reponses:
    data = json.load(reponses)          
    
#séparation des dictionnaires de réponse

data1 = data['1annee']  
data2 = data['2annee']  

#indexage des étudiants pour l'utilisation de la matrice

lst1 = []
lst2 = []   

for i in data1:
    lst1.append(i)
    
for i in data2:
    lst2.append(i)
    
#initialisation de la matrice des scores d'association

asso=[]
for i in range(len(data1.keys())):
    asso.append([])
    for j in range(len(data2.keys())):
        asso[i].append(0)

def calculScore(data1, data2):      #je pense que c'est clair
    #parcours des premières années
    for i in data1:    
        #parcours des deuxièmes années           
        for j in data2:     
            #parcours des réponses aux questions en commun
            for k in range(len(data1[i])):   
                #si la réponse est de type list
                if type(data1[i][k])==list:   
                    #parcours de la liste du première année ou un while qui sort des qu'un jeu en commun a été trouvé
                    for indiceListe1 in range(len(data1[i][k])):  
                        #parcours de la liste du deuxième année
                        for indiceListe2 in range(len(data2[j][k])): 
                            #si un jeu en commun a été trouvé
                            if data1[i][k][indiceListe1]==data2[j][k][indiceListe2]: 
                                # incrémenter leur score d'association
                                asso[lst1.index(i)][lst2.index(j)] += 1  
                #si la réponse est similaire
                if data1[i][k]==data2[j][k]:  
                    # incrémenter leur score d'association
                    asso[lst1.index(i)][lst2.index(j)] += 1     
    return asso
    