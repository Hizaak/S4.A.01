def initMatriceMarquage(taille):
    matriceMarquage = []
    for i in range(taille):
        matriceMarquage.append([])
        for j in range(taille):
            matriceMarquage[i].append(None)
    return matriceMarquage

def initTabCache(taille):
    tabCache=[]
    for i in range(taille):
        tabCache.append(False)
    return tabCache

def appliquerMethodeHongroise(matScores, valMax):

    taille = len(matScores)
    nbSelec = 0                                         # le nombre de 0 selectionnés
    matriceMarquage = initMatriceMarquage(taille)       # 0 si sélectionné, 1 si marqué d'un prime, sinon None   
    tabCacheL = initTabCache(taille)                    # 0 si découvert, 1 si caché
    tabCacheC = initTabCache(taille)                    # Idem
        
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
        for i in range(taille):
            
            # On vérifie s'il y a déjà un 0 sélectionné dans la ligne
            j=0
            aUnSelecL = False
            while j < taille:
                if matriceMarquage[i][j] == 0:
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
                            if matriceMarquage[k][j] == 0:
                                aUnSelecC = True
                                break
                            k+=1
                            
                        # On sélectionne le 0
                        if aUnSelecC == False:
                            matriceMarquage[i][j]=0
                            newZeroSelec = True
                            break
                    j+=1
            
        # On découvre les lignes et colonnes et retire les primes
        if newZeroSelec:
            tabCacheL = initTabCache(taille)
            tabCacheC = initTabCache(taille)
            for k in range(taille):
                for l in range(taille):
                    if matriceMarquage[k][l]==1:
                        matriceMarquage[k][l]=None
        
        # On compte le nombre de 0 sélectionnés
        nbSelec = 0
        for i in range(taille):
            for j in range(taille):
                if matriceMarquage[i][j] == 0:
                    nbSelec+=1
        
        # Condition de Sortie
        if nbSelec>=taille:
            break
        
        # On couvre les colonnes dont un 0 est sélectionné
        for i in range(taille):
            for j in range(taille):
                if matriceMarquage[i][j] == 0:
                    tabCacheC[j] = True
                     
        # Marquage des primes
        nbMaxPasSelec = False
        i=0
        while i < taille:
            j=0
            while j < taille:
                if matScores[i][j]==0 and matriceMarquage[i][j]!=0 and tabCacheC[j]==False and tabCacheL[i]==False:
                    matriceMarquage[i][j]=1
                    
                    # Vérifier s'il y a un 0 sélectionné dans la ligne
                    k=0
                    aUnSelecL = False
                    while k < taille:
                        if matriceMarquage[i][k]==0:
                            aUnSelecL = True
                            break
                        k+=1
                        
                    # Cacher la ligne et découvrir la colonne du 0 sélectionné
                    if aUnSelecL:
                        tabCacheL[i]=True
                        tabCacheC[k]=False
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
            finSuite=False
            while True:
                
                # On ajoute à la suite z le 0 sélectionné dans la colonne de z[i-1]
                j=0
                while True:
                    if matriceMarquage[j][z[i-1][1]]==0:
                        z.append([j,z[i-1][1]])
                        break
                    j+=1
                    if j==taille:
                        finSuite=True
                        break
                
                # On ajoute à la suite z le 0 marqué d'un prime dans la ligne de z[i-1]
                j=0
                while True:
                    if matriceMarquage[z[i][0]][j]==1:
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
                    matriceMarquage[z[i][0]][z[i][1]]=0
                else:
                    matriceMarquage[z[i][0]][z[i][1]]=None
            
            # On découvre les lignes et colonnes et retire les primes
            tabCacheL = initTabCache(taille)
            tabCacheC = initTabCache(taille)
            for k in range(taille):
                for l in range(taille):
                    if matriceMarquage[k][l]==1:
                        matriceMarquage[k][l]=None
        
        # Opérations avec l'élément libre le plus petit
        else:
            
            # On trouve l'élément libre le plus petit
            valMin=valMax
            for i in range(taille):
                for j in range(taille):
                    if tabCacheL[i]==False and tabCacheC[j]==False and matScores[i][j]<valMin:
                        valMin = matScores[i][j]
                        
            for i in range(taille):
                for j in range(taille):
                    # On ajoute la valeur minimale découverte à toutes les lignes couvertes
                    if tabCacheL[i]:
                        matScores[i][j]+=valMin
                    # On soustrait la valeur minimale découverte à toutes les colonnes découvertes
                    if tabCacheC[i]==False:
                            matScores[j][i]-=valMin          
                        
    return matriceMarquage
