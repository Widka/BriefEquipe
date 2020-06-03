<?php

function filtrer($username="id")
{
    $resultat = $_REQUEST[$username] ?? "";
    return $resultat;
}

$identifiantFormulaire = filtrer("identifiantFormulaire");

if ($identifiantFormulaire == "create")
{
    $tabAssoColonneValeur = [
        "username"        => filtrer("username"),
        "skills"          => filtrer("skills"),
        "level"           => filtrer("level"),
        
    ];
    extract($tabAssoColonneValeur);

    if ($username != ""
        && $skills != ""
        && $level != "")
    {
    $requeteSQL =
<<<CODESQL

INSERT INTO skill
( username, skills, level)
VALUES
( :username, :skills, :level)

CODESQL;

    require_once "php/model/envoyer-sql.php";

    echo "Votre article à bien été publié !($requeteSQL)";
    }
    else
    {
        echo "Veuillez remplir tous les champs obligatoires";
    }
}
if ($identifiantFormulaire == "delete")
{
    
    $tabAssoColonneValeur = [
        "id"            => filtrer("id"),
    ];
    extract($tabAssoColonneValeur);
    
    $id = intval($id);

    if ($id > 0)
    {
        
        $requeteSQL   =
<<<CODESQL

DELETE FROM skill
WHERE id = :id

CODESQL;

        require_once "php/model/envoyer-sql.php";

       
        echo "Votre article a bien été supprimé ($requeteSQL)";

    }
    else
    {
        
        echo "Merci de ne pas sombrer du coté obscur";
    }

}
if ($identifiantFormulaire == "update")
{
    $tabAssoColonneValeur = [
        "username"            => filtrer("username"),
        "skills"          => filtrer("skills"),
        "level"           => filtrer("level"),
    ];
    
    extract($tabAssoColonneValeur);
    
    if ($id != ""
        && $user != ""
        && $skills != ""
        && $level != "")
    {
        $requeteSQL   =
<<<CODESQL

UPDATE skill 
SET 
    username           = :username,
    skills             = :skills,
    level              = :level
WHERE 
    id = :id;


CODESQL;


    
        require_once "php/model/envoyer-sql.php";

        
        echo "Votre article à bien été modifié ($requeteSQL)";

    }

}