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
        
#je pense que c'est clair
        
def supprNoFilleuls(data2, lstASuppr):
    for i in lstASuppr:
        data2.pop(i)
    return data2

#idem

def calculScore(data1, data2, asso): 
    
    #suppression des deuxièmes années ne voulant pas de filleul
    lstASuppr = []
    for i in data2:
        if data2[i][-1]=="0":
            lstASuppr.append(i)
    data2 = supprNoFilleuls(data2, lstASuppr)
    
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
                                #incrémenter leur score d'association
                                asso[lst1.index(i)][lst2.index(j)] += 1  
                #si la réponse est similaire
                if data1[i][k]==data2[j][k]:  
                    #incrémenter leur score d'association
                    asso[lst1.index(i)][lst2.index(j)] += 1
                    
    #Remplissage de la matrice avec les deuxièmes années voulant plusieurs filleuls
    nbADupliquer=len(lstASuppr)
    #liste des index des secondes années à dupliquer
    lstADupliquer = []
    while len(lstADupliquer) < nbADupliquer:
        for i in data2:
            if data2[i][-1]=="pls":
                lstADupliquer.append(lst2.index(i))
    #Si la liste de deuxièmes années à dupliquer est plus grande que le nombre de filleuls restant
    if len(lstADupliquer) > nbADupliquer:
        while len(lstADupliquer) > nbADupliquer:
            lstADupliquer.pop(-1)
    asso = DupliquerPlsFilleuls(data2, asso, nbADupliquer, lstADupliquer)
    return asso

def DupliquerPlsFilleuls(data2, asso, nbADupliquer, lstADupliquer):
    for i in lstADupliquer:
        #colonne dans laquelle il faut dupliquer le seconde année
        posDuplication=len(asso)-nbADupliquer
        for j in range(len(asso)):
            asso[j][posDuplication] = asso[j][i]
        lstADupliquer.pop(0)
    return asso
            
