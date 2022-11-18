matScores = [[266, 366, 183, 283, 366, 283, 366], 
             [150, 350, 200, 300, 350, 300, 350], 
             [300, 100, 300, 200, 100, 200, 100], 
             [300, 166, 233, 133, 166, 133, 166], 
             [100, 200, 300, 200, 200, 200, 200], 
             [250, 50, 400, 300, 50, 300, 50], 
             [300, 150, 275, 175, 150, 175, 150]]

valMax = 400

def afficherMatrice(matrice):
    for i in matrice:
        print(i)
        
def initMatMarque(taille):
    matMarque = []
    for i in range(taille):
        matMarque.append([])
        for j in range(taille):
            matMarque[i].append(None)
    return matMarque

def initTabCache(taille):
    tabCache=[]
    for i in range(taille):
        tabCache.append(0)
    return tabCache

def metHongroise(matScores, valMax):
    
    taille = len(matScores)
    nbSelec = 0
    matMarque = initMatMarque(taille)       # 0 si sélectionné, 1 si marqué d'un prime, sinon None   
    tabCacheL = initTabCache(taille)        # 0 si découvert, 1 si caché
    tabCacheC = initTabCache(taille)        # Idem
        
    # Soustraire la valeur minimale à chaque ligne
    for i in range(taille):
        valMin = matScores[i][0]
        for j in range(taille):
            if matScores[i][j] < valMin:
                valMin = matScores[i][j]
        for j in range(taille):
            matScores[i][j]-=valMin
            
    # Idem à chaque colonne
    for i in range(taille):
        valMin = matScores[0][i] 
        for j in range(taille):
            if matScores[j][i] < valMin:
                valMin = matScores[j][i]
        for j in range(taille):
            matScores[j][i]-=valMin
            
    # Tant que tout les étudiants ne sont pas sélectionnés
    while True:
        
        # Sélection des 0
        i=0
        newZeroSelec = False
        while i < taille:
            
            # On vérifie s'il y a déjà un 0 sélectionné dans la ligne
            j=0
            aUnSelecL = False
            while j < taille:
                if matMarque[i][j] == 0:
                    aUnSelecL = True
                    break
                j+=1
            if aUnSelecL == False:
                
                # On tente de sélectionner un 0 dans la ligne
                j=0
                while j < taille:
                    if matScores[i][j] == 0:
                        
                        # On vérifie s'il y a un 0 sélectionné dans la colonne
                        k=0
                        aUnSelecC = False
                        while k < taille:
                            if matMarque[k][j] == 0:
                                aUnSelecC = True
                                break
                            k+=1
                            
                        # On sélectionne le 0
                        if aUnSelecC == False:
                            matMarque[i][j]=0
                            newZeroSelec = True
                            break
                    j+=1
            i+=1
            
        # On découvre les lignes et colonnes et retire les primes
        if newZeroSelec:
            tabCacheL = initTabCache(taille)
            tabCacheC = initTabCache(taille)
            for k in range(taille):
                for l in range(taille):
                    if matMarque[k][l]==1:
                        matMarque[k][l]=None
        
        # Condition de Sortie
        # On compte le nombre de 0 sélectionnés
        nbSelec = 0
        for i in range(taille):
            for j in range(taille):
                if matMarque[i][j] == 0:
                    nbSelec+=1
        if nbSelec>=taille:
            break
        
        # On couvre les colonnes dont un 0 est sélectionné
        for i in range(taille):
            for j in range(taille):
                if matMarque[i][j] == 0:
                    tabCacheC[j] = 1
                     
        # Marquage des primes
        nbMaxPasSelec = False
        i=0
        while i < taille:
            j=0
            while j < taille:
                if matScores[i][j]==0 and matMarque[i][j]!=0 and tabCacheC[j]==0 and tabCacheL[i]==0:
                    matMarque[i][j]=1
                    
                    # Vérifier s'il y a un 0 sélectionné dans la ligne
                    k=0
                    aUnSelecL = False
                    while k < taille:
                        if matMarque[i][k]==0:
                            aUnSelecL = True
                            break
                        k+=1
                        
                    # Cacher la ligne et découvrir la colonne du 0 sélectionné
                    if aUnSelecL:
                        tabCacheL[i]=1
                        tabCacheC[k]=0
                        break
                    
                    # On a pas sélectionné le nombre maximum de 0
                    else:
                        nbMaxPasSelec = True
                        break 
                j+=1
            if nbMaxPasSelec:
                break
            i+=1
            
        # On sélectionne le nombre maximal de 0
        if nbMaxPasSelec:
            z = []
            z.append([i,j])
            i=1
            while True:
                
                finSuite=False
                # On ajoute à la suite z le 0 sélectionné dans la colonne de z[i-1]
                j=0
                while True:
                    if matMarque[j][z[i-1][1]]==0:
                        z.append([j,z[i-1][1]])
                        break
                    j+=1
                    if j==taille:
                        finSuite=True
                        break
                
                # On ajoute à la suite z le 0 marqué d'un prime dans la ligne de z[i-1]
                j=0
                while True:
                    if matMarque[z[i][0]][j]==1:
                        z.append([z[i][0],j])
                        break
                    j+=1
                    if j==taille:
                        finSuite=True
                        break
                    
                # On a trouvé la suite
                if finSuite:
                    break
                
                i+=1
                
            # On retire les primes et on sélectionne les 0
            for i in range(len(z)):
                if i%2==0:
                    matMarque[z[i][0]][z[i][1]]=0
                else:
                    matMarque[z[i][0]][z[i][1]]=None
            
            # On découvre les lignes et colonnes et retire les primes
            tabCacheL = initTabCache(taille)
            tabCacheC = initTabCache(taille)
            for k in range(taille):
                for l in range(taille):
                    if matMarque[k][l]==1:
                        matMarque[k][l]=None
        
        # Opérations avec l'élément libre le plus petit
        else:
            
            # On trouve l'élément libre le plus petit
            valMin=valMax
            for i in range(taille):
                for j in range(taille):
                    if tabCacheL[i]==0 and tabCacheC[j]==0 and matScores[i][j]<valMin:
                        valMin = matScores[i][j]
                        
            # On ajoute la valeur minimale découverte à toutes les lignes couvertes
            for i in range(taille):
                if tabCacheL[i]==1:
                    for j in range(taille):
                        matScores[i][j]+=valMin
                        
            # On soustrait la valeur minimale découverte à toutes les colonnes découvertes
            for i in range(taille):
                if tabCacheC[i]==0:
                    for j in range(taille):
                        matScores[j][i]-=valMin          
        
    # Affichage
    print(nbSelec)
    print(tabCacheC)
    print(tabCacheL)
    afficherMatrice(matScores)
    afficherMatrice(matMarque)
    return matScores

metHongroise(matScores, valMax)
