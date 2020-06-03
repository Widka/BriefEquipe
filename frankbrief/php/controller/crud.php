<?php

function filtrer($user="id")
{
    $resultat = $_REQUEST[$user] ?? "";
    return $resultat;
}

$identifiantFormulaire = filtrer("identifiantFormulaire");

if ($identifiantFormulaire == "create")
{
    $tabAssoColonneValeur = [
        "user"            => filtrer("user"),
        "skills"          => filtrer("skills"),
        "level"           => filtrer("level"),
        
    ];
    extract($tabAssoColonneValeur);

    if ($id != ""
        && $user != ""
        && $skills != ""
        && $level != "")
    {
    $requeteSQL =
<<<CODESQL

INSERT INTO skill
( user, skills, level)
VALUES
( :user, :skills, :level)

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
        "user"            => filtrer("user"),
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
    user           = :user,
    skills         = :skills,
    level           = :level
WHERE 
    id = :id;


CODESQL;


    
        require_once "php/model/envoyer-sql.php";

        
        echo "Votre article à bien été modifié ($requeteSQL)";

    }

}