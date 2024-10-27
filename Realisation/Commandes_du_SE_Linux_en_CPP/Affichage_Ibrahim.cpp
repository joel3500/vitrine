/*TP1 SYSTEME D EXPLOITATION
  REALISE PAR : IBRAHIM DIAKITE , JOEL SANDE , MARIAME NDOUR SAGNE
*/
#include <iostream>
#include <vector>
#include <string>
#include <unistd.h> // Pour utiliser fork() et execvp()
#include <sys/wait.h> // Pour gérer les processus
#include <fstream> // Pour gérer les fichiers
#include <cstdlib>
#include <ctime> // Pour générer des nombres aléatoires et mesurer le temps d'execution


using namespace std;

// Création d'une fonction pour nous aider enregistrer les commandes dans un fichier spécifique
void sauvegarderFichier(const string& nomFichier,const vector<string>& conteneur) {
    ofstream mon_fichier(nomFichier);
    for (const string& cmd : conteneur) {
        mon_fichier << cmd <<'\n';
    }
    mon_fichier.close();
}

// Fonction pour générer une commande aléatoire avec ses options
string genererCommandeAleatoire() {
    // On declare un tableau contenant des commandes et leurs options possibles.
    // Par exemple on a "ls -l" pour lister les fichiers avec détails, "pwd" pour afficher le répertoire courant, etc.
    string commandes[] = {
        "ls -l", 
        "pwd", 
        "ls -a",  
        "ps",
        "ls -l &", 
        "pwd &", 
        "ls -a &"
    };
    
    //on genere un index aléatoire pour choisir une commande du tableau.
    int index = rand() % (sizeof(commandes) / sizeof(commandes[0]));
    return commandes[index]; // On retourne la commande choisie.
}

// Fonction pour lancer l'instance 1
void lancerInstance1() {
    std::ofstream mon_fichier; //Déclaration du  fichier où on va sauvegarder l'historique

    std::vector<string> conteneur; // Création d'un vecteur pour stocker les commandes
    int count = 0; // Déclaration d'un compteur pour savoir combien de commandes ont été exécutées
    vector<string> conteneurSimple;  // ce conteneur nous servira à sauvegarder seulement les commandes lancées

    bool quitter = true; // Cette variable nous permet de contrôler la boucle et quitter le programme
    time_t startTime; //Déclaration d'une variable pour stocker le temps de début

    // On affiche un message pour que l'utilisateur sache quoi faire
    std::cout << "Veuillez entrer une commande ou 'stop' pour quitter :\n";

    time(&startTime); // On récupère le temps de départ
    while (quitter) { //on rentre dans une boucle qui va se repeter tant que quitter est vrai 

        std::string commande_entiere = genererCommandeAleatoire(); // On génère une commande aléatoire grâce à la fonction implémentée tantot
        std::cout << commande_entiere << std::endl; // Affichage de la commande générée pour que l'utilisateur puisse la voir
        
        // On vérifie si le compteur a atteint 100 pour savoir si on va quitter la boucle
        if(count == 100) {
            commande_entiere = "stop";//la commande stop permet de quitter la boucle
        }

        // On découpe la commande en deux parties  à savoirla commande et l'option
        std::string commande = commande_entiere.substr(0, commande_entiere.find(" ")); // on prend la première partie
        std::string option = commande_entiere.substr(commande_entiere.find(" ") + 1); // on prend la partie après l'espace

        // On prepare les arguments pour execvp 

        char *args[3] = {nullptr, nullptr, nullptr}; // Déclaration d'un tableau pour les arguments
        args[0] = const_cast<char*>(commande.c_str()); // La commande
        args[1] = const_cast<char*>(option.c_str()); // L'option
        args[2] = NULL; 

        // Si l'utilisateur a demandé à arreter, on met à jour la variable quitter
        if (commande_entiere == "stop") {
            quitter = false; //pour pouvoir quitter la boucle
            std::cout<<"Commande STOP executée, arret du programme... \n ";
            continue; // On passe au début de la boucle pour éviter d'ajouter une commande
            
        }

        pid_t pid = fork(); // Création du Processus enfant

        if (pid < 0) { // Si on a un problème avec le fork
            perror("Echec du fork\n");
            return; // On quitte le programme
            
        } 
        
        else if (pid == 0) { //  processus enfant
            execvp(args[0], args); // execution de la commande
            cerr << "Échec de execvp()" << endl; // si ça echoue on affiche une erreur
            exit(1); // On quitte le processus enfant
        } 
        
        else { // On est dans le processus parent
            int status; 
            count++; // On incrémente le compteur de commandes

            waitpid(pid, &status, 0); // On attend que le processus enfant finisse

           
            // si on a deux fois le meme mot on affiche le mot une seule fois
        //on a rajoute cela car avec la maniere dont on extrait les mots , 
        //s il n y a pas d espace , le mot sera extrait dans args1 et dans args0
        //ce qui est le cas pour par exemple pwd il sera a la fois dans args0 et dans args1 
        // car il n y a pas de mot qui suit pwd donc pas d espace
            if (*args[0] == *args[1]) {
                std::cout << count << '\t' << args[0] << '\t' << pid << std::endl; // Affiche le numéro de commande, commande et  le PID
            } else {
                std::cout << count << '\t' << args[0] << '\t' << args[1] << '\t' << pid << std::endl; // Affiche tout
            }

            // On prépare une chaine de caractères pour stocker les résultats dans notre conteneur
            std::string resultat = std::to_string(count) + '\t' + args[0] + "   " + args[1] + "   " + std::to_string(pid) ;
            conteneur.push_back(resultat); // Ajout du resultat au conteneur

            conteneurSimple.push_back(commande_entiere);//ajout de la commande entrée au conteneursimple ,on s'en servira pour remplir le fichier commande entrées.txt

            // On vérifie si on a atteint 50 ou 100 commandes pour écrire dans le fichier
             // Sauvegarder dans les fichiers appropriés
            if (count == 50 || count == 100) {
                sauvegarderFichier("historique1_" + to_string(count) + ".txt", conteneur);
            }
            
        }
        
    }
    time_t endTime; // Variable pour stocker le temps de fin
    time(&endTime); // On recupere le temps de fin
    //on fait la différence pour avoir le temps d'execution
    std::cout << "Temps d'execution obtenu pour l'instance 1 : " << difftime(endTime, startTime) << " secondes" << std::endl; // Affiche le temps écoulé
    // Sauvegarder le fichier final pour toutes les commandes exécutées
    
    sauvegarderFichier("instance1_100_commandes.txt", conteneurSimple);

    ///// POUR LE FICHIER DE 500 COMMANDES ET CELUI DE 1000 COMMANDES
     // Génération de 400 autres  commandes supplémentaires
    for (int i = 0; i < 400; i++) {
        std::string commande_aleatoire = genererCommandeAleatoire();
        conteneurSimple.push_back(commande_aleatoire); // Ajout des commandes supplémentaires au conteneur
    }
    sauvegarderFichier("instance1_500_commandes.txt", conteneurSimple); // Sauvegarde des 400 commandes supplémentaires

   
     // Generation de 500 autres commandes supplémentaires pour avoir 1000 commandes
    for (int i = 0; i < 500; i++) {
        std::string commande_aleatoire = genererCommandeAleatoire();
        conteneurSimple.push_back(commande_aleatoire); // Ajout des commandes supplémentaires au conteneur
    }
    sauvegarderFichier("instance1_1000_commandes.txt", conteneurSimple); // Sauvegarde des 400 commandes supplémentaires


}

// implémentation de la fonction pour lancer l'instance 2
void lancerInstance2() {
    std::ofstream mon_fichier; // On déclare le fichier ou l'on va sauvegarder l'historique

    std::vector<string> conteneur; // création de notre conteneur comme pour instance &
    vector<string> conteneurSimple;  // ce conteneur nous servira à sauvegarder seulement les commandes lancées

    int count = 0; // Compteur pour savoir combien de commandes ont été exécutees

    bool quitter = true; // Déclaration d'une variable pour controler la boucle et quitter le programme

    time_t startTime; //Déclaration d'une variable pour stocker le temps de début

    
    std::cout << "Veuillez entrer une commande ou 'stop' pour quitter :\n";
    time(&startTime); // On récupère le temps de départ

    while (quitter) { // On entre dans une boucle qui va se répéter tant que quitter est vrai

        std::string commande_entiere = genererCommandeAleatoire(); // On fait appel a notre fonction qui permet de generer une commande aleatoire

        std::cout << commande_entiere << std::endl; // On affiche la commande generee pour que l'utilisateur puisse la voir
        
        // On vérifie si le compteur a atteint 500 et si c'est le cas on se prepare pour quitter la boucle
        if(count == 500) {
            commande_entiere = "stop"; // On prepare la commande "stop" pour sortir de la boucle
        }

        // Decoupage de la commande en deux parties : la commande et l'option
        std::string commande = commande_entiere.substr(0, commande_entiere.find(" ")); // On prend la première partie
        std::string option = commande_entiere.substr(commande_entiere.find(" ") + 1); // On prend la partie après l'espace

        // On prépare les arguments pour execvp
        char *args[3] = {nullptr, nullptr, nullptr}; // On déclare un tableau pour les arguments
        args[0] = const_cast<char*>(commande.c_str()); // La commande
        args[1] = const_cast<char*>(option.c_str()); // L'option
        args[2] = NULL; 

        // Si l'utilisateur a demandé à arrêter, on met à jour la variable quitter
        if (commande_entiere == "stop") {
            quitter = false; // On quitte la boucle
             std::cout<<"Commande STOP executée, arret du programme...";
            continue; // On passe au début de la boucle pour éviter d'ajouter une commande
        }

        pid_t pid = fork(); // création du processus enfant

        if (pid < 0) { // Si on a un problème avec le fork
            perror("Echec du fork\n");
            return; // On quitte le programme
        } 
        else if (pid == 0) { // On est dans le processus enfant
            execvp(args[0], args); //execution de la commande
            cerr << "Échec de execvp()" << endl; //  on affiche une erreur en cas d'echec
    
            exit(1); // On quitte le processus enfant
        } 
        else { // On est dans le processus parent
            int status; 

            count++; // On incrémente le compteur de commandes
            waitpid(pid, &status, 0); // On attend que le processus enfant finisse

            // on affiche le resultat en fonction de ce qui a été exécuté comme nous l'avions expliqué au niveau d'instance 1 
            if (*args[0] == *args[1]) {
                std::cout << count << '\t' << args[0] << '\t' << pid << std::endl; // Affiche le numéro de commande, commande et PID
            } else {
                std::cout << count << '\t' << args[0] << '\t' << args[1] << '\t' << pid << std::endl; // Affiche tout
            }

            // préparation d'une chaine de caracteres pour stocker les resultats dans notre conteneur
            std::string resultat = std::to_string(count) + '\t' + args[0] + "   " + args[1] + "   " + std::to_string(pid) ;

            conteneur.push_back(resultat); //Ajout du resultat à notre conteneur
            conteneurSimple.push_back(commande_entiere);//ajout de la commande entrée au conteneursimple ,on s'en servira pour remplir le fichier commande entrées.txt


            // On vérifie si on a atteint un multiple de 100 pour ecrire dans le fichier
            if (count % 100 == 0) {   
                sauvegarderFichier("historique2_" + to_string(count) + ".txt", conteneur);
            
            }
        }
    }
    time_t endTime; // Variable pour stocker le temps de fin
    time(&endTime); // On recupere le temps de fin
    //on fait la différence pour avoir le temps d'execution
    std::cout << "Temps d'execution obtenu pour l'instance 2 : " << difftime(endTime, startTime) << " secondes" << std::endl; // Affiche le temps écoulé
   //sauvegarde du fichier final
   sauvegarderFichier("instance2_500_commandes.txt", conteneurSimple); 


   ///// POUR LE FICHIER DE 1000 COMMANDES ENTREES 
     // Génération de 500 autres  commandes supplémentaires
    for (int i = 0; i < 500; i++) {
        std::string commande_aleatoire = genererCommandeAleatoire();
        conteneurSimple.push_back(commande_aleatoire); // Ajout des commandes supplémentaires au conteneur
    }
    sauvegarderFichier("instance2_1000_commandes.txt", conteneurSimple); 

}

int main() {
    srand(time(0)); // On initialise le generateur de nombres aléatoires pour que chaque exécution soit différente
    
    std::string noms="Diakite_Sagne";//on utilisera cette variable pour l'afficher dans l'invite de commande avant chaque entrée
    // On demande à l'utilisateur quelle instance il souhaite lancer
    int choix;
    std::cout << "Choisissez une instance à lancer  dans l'invite de commande (1 ou 2) \n ";
    std::cout<<noms<<" < ";
    std::cin >> choix; // On récupère le choix de l'utilisateur

    // On exécute l'instance choisie
    if (choix == 1) {
        lancerInstance1(); // On lance l'instance 1
    } else if (choix == 2) {
        lancerInstance2(); // On lance l'instance 2
    } else {
        std::cout << "Choix invalide." << std::endl; // Si le choix n'est pas valide
    }

    return 0; 
}
