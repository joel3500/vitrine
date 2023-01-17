

function Soumettre()                                          // celui-ci Envoie mes donnees sur le TCHAT
{
    //var Bouton = document.getElementById("Soumettre")                  // J'associe mes envoie des messages input à un Boutton
                                       
    if(document.getElementById("messageWeb").value == "")
    {
        document.getElementById("messageErreur").innerHTML = "Vous ne pouvez PAS envoyer un message VIDE ! Il faut ABSOLUMENT écrire quelque chose... ";
        document.getElementById("messageErreur").style.visibility = "visible";
        document.getElementById("OK").style.visibility = "visible";
        document.getElementById("messageWeb").innerHTML = "";
    }
    else if(document.getElementById("messageWeb").value !== "maitrejoel")
    {
        document.getElementById("messageErreur").innerHTML = "Le mot de passe est Invalide ! veuillez reesayer de nouveau... ";
        document.getElementById("messageErreur").style.visibility = "visible";
        document.getElementById("OK").style.visibility = "visible";
        document.getElementById("messageWeb").innerHTML = "";
    }
    else
    {
        window.open("page_principale.html");
    }
    //document.getElementById("messageWeb").innerHTML = "";            // je vide ainsi le contenu de mon input pour pouvoir le remplir à nouveau
}

function FaireDisparaitre()    // bout de code recuperé de mon TP2 pour faire apparaoitre et disparaitre un message d'avertissement lorsque je tente d'envoyer du texte VIDE
{
  document.getElementById("messageErreur").style.visibility = "hidden";
  document.getElementById("OK").style.visibility = "hidden";
  document.getElementById("messageWeb").innerHTML = "";
}