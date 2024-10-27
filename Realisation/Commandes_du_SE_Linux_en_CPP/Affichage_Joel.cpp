#include <iostream>
#include <vector>
#include <string>
#include <unistd.h> //pour fork() et execvp()
#include <string.h>
#include <sys/wait.h>
#include <fstream>
 
using namespace std;

void creation_Fichier_Commandes(vector<string> commandes_entieres, int iterations);
void creation_Fichier_Historique(vector<string> commandes_entieres, int instance, int iteration);

int main()
{
    // cout << "Veuillez entrer une commande : " << endl ;
    //s tring noms="Diakite_Sagne";//on utilise cette variable pour l'afficher dans l'invite de commande avant chaque entrée
    
    string argument[3];//déclaration du tableau qui contiendra les commande et les options
    string commande_entiere;
    int instance;
    int iterations = 1000;
    
    int min = 0;
    string tab[5] = {"ls -l","man -ls","pwd","ls -a","ps"};
    int max = sizeof(tab)/sizeof(tab[0]) -1;
    
    // position aleatoire permettra de recuperer une commande aleatoire de tab.
    int pos;
    
    // validation de l instance choisie par l utilisateur
    do{   
        cout << "Quelle instance voulez-vous exécuter ? la (1) ou la (2) : " << endl;
        cin >> instance;
        if (instance != 1 && instance != 2)
           cout << "il n y a que 2 options. Choisissez 1 ou 2 et rien d autre " << endl;
    }while(instance != 1 && instance != 2); 

    // Exemple de stockage des commandes dans le vecteur pour 1000 valeurs 
    vector<string> commandes_entieres(iterations); // Alloue de la mémoire pour 'iterations' éléments
    for(int i=0; i<iterations; i++){
        pos = rand() % (max - min + 1) + min;  // varie entre 0 et 4
        commandes_entieres[i] = tab[pos];
        cout << (i+1) << " " << commandes_entieres[i] << endl;
    }

    // La Creation des Fichiers de commande depend de l'instance
    if(instance == 1){
        // Appel des creation de Fichier de commandes 50 et 100
        creation_Fichier_Commandes(commandes_entieres, 50);
        creation_Fichier_Commandes(commandes_entieres, 100);
    }
    else { // si ce n'est pas 1 c'est forcement 2
        // Appel des creation de Fichier de commandes 500 et 1000
        creation_Fichier_Commandes(commandes_entieres, 500);
        creation_Fichier_Commandes(commandes_entieres, 1000);
    }
    
    // Appel de La creation d un fichier historique sur la base de l'instance et l'iteration
    if(instance == 1){
        // Appel des creation de Fichier de historique1_50
        creation_Fichier_Historique(commandes_entieres, instance, 50);
        // Appel des creation de Fichier de historique1_100
        creation_Fichier_Historique(commandes_entieres, instance, 100);
    }
    else { // si ce n'est pas 1 c'est forcement 2
        // Appel des creation de Fichier de historique2_100
        creation_Fichier_Historique(commandes_entieres, instance, 100);
        // Appel des creation de Fichier de historique2_200
        creation_Fichier_Historique(commandes_entieres, instance, 200);
        // Appel des creation de Fichier de historique2_300
        creation_Fichier_Historique(commandes_entieres, instance, 300);
        // Appel des creation de Fichier de historique2_400
        creation_Fichier_Historique(commandes_entieres, instance, 400);
        // Appel des creation de Fichier de historique2_500
        creation_Fichier_Historique(commandes_entieres, instance, 500);
    }
   
    return 0;     
}

void creation_Fichier_Commandes(vector<string> commandes_entieres, int iterations)
{
    cout << "commande_" + to_string(iterations)+ ".txt" << endl;
    string filename = ("commande_" + to_string(iterations)+ ".txt");   // Voici ce qui pourrait etre la cration generale d'un fichier
    ofstream myfile;
    myfile.open(filename, ios_base::out); 

    for(int i=0; i<iterations; i++)  
    { 
        myfile << commandes_entieres[i] << endl;    // ecrire dans un fichier
          cout << commandes_entieres[i] << endl;   // afficher à l'ecran
    }
    // fermeture du fichier
    myfile.close();
}

void creation_Fichier_Historique(vector<string> commandes_entieres, int instance, int iterations)
{
    cout << "historique" + to_string(instance) + "_" + to_string(iterations)+ ".txt" << endl;
    string filename = ("historique" + to_string(instance) + "_" + to_string(iterations)+ ".txt");   // Voici ce qui pourrait etre la cration generale d'un fichier
    ofstream file_out;
    
    bool quitter = true;      // Création d'une variable pour quitter le programme.
    string commande_entiere;
    // Déclaration d'un vecteur qu'on utilisera pour stocker les commandes entrées
    vector<string> conteneur;

    // ouverture du fichier contenant l'historique
    file_out.open(filename, ios_base::out);
    
    for(int i=0; i<iterations; i++)
    {
        //Découpage de la commande
        //On prend d'abord la commande
        //Pour cela on déclare une variable qui va délimiter le mot de la commande 
        string limite=" ";
        string commande=commandes_entieres[i].substr(0,commandes_entieres[i].find(limite));
        //ensuite on prend l'option après l'espace c'est à dire qui se trouve juste après la position de la variable limite
        string option=commandes_entieres[i].substr(commandes_entieres[i].find(limite)+1);

        //conversion des string en char pour pouvoir utiliser la commande execvp
        char *args[3] = { nullptr, nullptr, nullptr };
        args[0]=const_cast<char*>(commande.c_str());
        args[1]=const_cast<char*>(option.c_str());
        args[2]=NULL;

        //Création du processus enfant
        pid_t pid=fork();

        if(pid<0)
        {
            cout << "Echec du fork" << endl;
        }
        
        else if(pid==0)
        {    
            // Code exécuté par le processus enfant
            execvp(args[0], args);
            // Si execvp échoue
            cerr << "Échec de execvp()" << endl;
        }

        else
        {
            // Code exécuté par le processus parent
            // La commande rentrée par l'utilisateur est lue
            commande_entiere = commandes_entieres[i];
            int status;
        
            waitpid(pid, &status, 0);
            // si on a deux fois le meme mot on affiche le mot une seule fois
            //on a rajoute cela car avec la maniere dont on extrait les mots , 
            //s il n y a pas d espace , le mot sera extrait dans args1 et dans args0
            //ce qui est le cas pour par exemple pwd il sera a la fois dans args0 et dans args1 
            // car il n y a pas de mot qui suit pwd donc pas d espace
            if(*args[0] == *args[1])
            {
                cout << (i+1) << '\t' << args[0] << '\t' << pid << endl;
            }
            //sinon
            else{
                cout << (i+1) << '\t'<< args[0] << '\t' << args[1] << '\t' << pid << endl;
            }  
            
            cout << "Commande exécutée avec succès :) ! " << endl;

            // Concaténation des valeurs affichées en une seule chaine de caractères pour les stocker dans notre conteneur
            string resultat = to_string((i+1)) + '\t' + args[0] + "   " + args[1] + "   " + to_string(pid);    
        
            // On met le contenu affiché dans un vecteur que l'on utilisera pour la fonction historique
            //conteneur.push_back(resultat);
            file_out << resultat << endl;
                cout << resultat << endl;
        }  
    }
    //fermeture du fichier
    file_out.close();
}