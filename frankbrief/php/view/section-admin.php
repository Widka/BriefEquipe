<?php
 
session_start();
include '../includes/database.php';
 
if (isset($_POST['submit'])) {
 
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['password'];
    $confirmNewPassword = $_POST['confirm_password'];
 
    if ($_SESSION['userPassword'] == $oldPassword) {
        if ($newPassword == $confirmNewPassword) {
           
            $database = getPDO();
            $request = $database->prepare("UPDATE `login` SET user_Password = ? WHERE user_Email = ?");
            $request->execute([
                $newPassword,
                $_SESSION['userEmail']
            ]);
            $succesMessage = 'Le mot de passe est maintenant modifié !';
            header('refresh:3;url=section-index.php');
 
        } else {
            $errorMessage = 'Les mots de passes ne sont pas identiques!';
        }
    } else {
        $errorMessage = 'Le mot de passe est incorrect..';
    }
}
?>
<div class="form-div text-center">
                <h3>Information</h3>
                <?php if (isset($_SESSION['userEmail'])) { ?>
                        <p>Bonjour, <?= $_SESSION['userPseudo'] ?> !</p>
                        <p>Email : <?= $_SESSION['userEmail'] ?></p>
                        <p>Inscrit le <?= $_SESSION['userRegisterDate'] ?></p>
                        <a href="section-logout.php"> Se Déconnecter</a>
                        <br>
                        <h3>Changer de mot de passe</h3>
                        <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
                        <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
                        <form method="post" action="">
 
                            <span>Ancien Mot de passe :</span><br>
                            <input type="password" name="old_password" placeholder="Ancien Mot de passe"><br>
 
                            <span>Nouveau Mot de passe :</span><br>
                            <input type="password" name="password" placeholder="Nouveau Mot de passe"><br><br>
 
                            <span>Confirmation du Nouveau Mot de passe :</span><br>
                            <input type="password" name="confirm_password" placeholder="Confirmation Mot de passe"><br><br>
 
                            <input type="submit" name="submit" value="Valider">
                        </form>
                       
                    <?php } else { ?>
                    <p>Vous n'êtes pas connecté !</p>
                <?php } ?>

<section class="container">
    <h2>Ajouter une compétence</h2>
    <form id="create" class="admin" action="" method="POST">
        <input type="text" name="username" required placeholder="Entrer votre Username">
        <br><textarea name="skills" cols="60" rows="8" required placeholder="Entrer le contenu de la compétence"></textarea><br>
        
        <input type="radio" id="level" name="level" value="level1">
            <label for="level1">Niveau 1</label><br>
        <input type="radio" id="level" name="level" value="level2">
            <label for="level2">Niveau 2</label><br>
        <input type="radio" id="level" name="level" value="level3">
            <label for="level3">Niveau 3</label><br>
        <input type="hidden" name="identifiantFormulaire" value="create">

        <button type="submit">Ajouter Compétence</button>
        <div class="confirmation">
            <?php 
$identifiantFormulaire = $_REQUEST["identifiantFormulaire"] ?? "";
if ($identifiantFormulaire == "create")
{
    require "../controller/crud.php"; 
}        
            ?>
        </div>
    </form>
</section>

<br>

<section class="updateSection cache">
    <button class="closePopup">Fermer la popup</button>
    <h2>Modifier un article (Update)</h2>
    <form id="update" class="admin" action="" method="POST">
        <div class="infosUpdate">
        <input type="text" name="username" required placeholder="Entrer votre Username">
        <br><textarea name="skills" cols="60" rows="8" required placeholder="Entrer le contenu de la compétence"></textarea><br>
        
        <input type="radio" id="level" name="level" value="level1">
            <label for="level1">Niveau 1</label><br>
        <input type="radio" id="level" name="level" value="level2">
            <label for="level2">Niveau 2</label><br>
        <input type="radio" id="level" name="level" value="level3">
            <label for="level3">Niveau 3</label><br>
            <input type="text" name="id" required placeholder="Entrez id ligne">
        </div>

        <input type="hidden" name="identifiantFormulaire" value="update">
        <button type="submit">Modifier la compétence</button>
        <div class="confirmation">
        <?php 
$identifiantFormulaire = $_REQUEST["identifiantFormulaire"] ?? "";
if ($identifiantFormulaire == "update")
{
    require "../controller/crud.php"; 
}        
            ?>
        </div>

    </form>
</section>

<section class="cache">
    <h2>Supprimer compétence</h2>
    <form id="delete" action="" method="POST">
        <input type="text" name="id" required placeholder="Entrez id">
        <input type="hidden" name="identifiantFormulaire" value="delete">
        <button>Supprimer la compétence</button>
        <div class="confirmation">
        <?php 
$identifiantFormulaire = $_REQUEST["identifiantFormulaire"] ?? "";
if ($identifiantFormulaire == "delete")
{
    require "../controller/crud.php"; 
}        
            ?>
        </div>
    </form>    
</section>


<section class="container">
    <h2>Listes des Compétences</h2>

    <table>
        <thead>
            
            <tr>
                <td>Id</td><br>
                <td>Username</td><br>
                <td>Compétence</td><br>
                <td>Niveau</td><br>
                <td>Modifier</td><br>
                <td>Supprimer</td><br>
            </tr>
        </thead>
        <tbody>
            
            <?php

$requeteSQL =
<<<CODESQL

SELECT * FROM `skill`
ORDER BY id

CODESQL;


$tabAssoColonneValeur = [];


require "../model/envoyer-sql.php";

$tabLigne = $pdoStatement->fetchAll();

foreach($tabLigne as $tabAsso)
{
    extract($tabAsso); 

    echo
<<<CODEHTML

<tr>
    <td>$id</td>
    <td>$username</td>
    <td>$skills</td>
    <td>$level</td>
    <td>
        <button data-id="$id" class="update">Modifier</button>
        <!-- ON PEUT DONNER PLUSIEURS CLASSES A UNE BALISE -->
        <div class="infosUpdate cache">
            <input type="text" name="username" required placeholder="Entrer votre username" value="$username"><br>
            <textarea name="skills" cols="60" rows="8" required placeholder="Entrer le contenu de la compétence">$skills</textarea><br>
            <input type="radio" id="level" name="level" value="$level">
                <label for="level1">Niveau 1</label><br>
            <input type="radio" id="level" name="level" value="$level">
                <label for="level2">Niveau2</label><br>
            <input type="radio" id="level" name="level" value="$level">
                <label for="level3">Niveau3</label><br>
            <input type="text" name="id" required placeholder="entrez id ligne" value="$id">
        </div>

    </td>  
    <td><button data-id="$id" class="delete">Supprimer</button></td>  
</tr>

CODEHTML;
}


?>
        </tbody>
    </table>
</section>


<script>
var boutonClose = document.querySelector("button.closePopup");
boutonClose.addEventListener("click", function(){
    var baliseSectionUpdate = document.querySelector("section.updateSection");
    baliseSectionUpdate.classList.add("cache");
});

var listeBoutonUpdate = document.querySelectorAll("button.update");
listeBoutonUpdate.forEach(function(bouton){
    bouton.addEventListener("click", function(event){
        console.log("Clique sur Modifier");
        var baliseBouton = event.target;
        var baliseTd = baliseBouton.parentNode;
        var baliseUpdate = baliseTd.querySelector(".infosUpdate");

        console.log(baliseBouton);
        console.log(baliseTd);
        console.log(baliseUpdate);

        var baliseUpdateForm = document.querySelector("form#update div.infosUpdate");
        baliseUpdateForm.innerHTML = baliseUpdate.innerHTML;

        var baliseSection = document.querySelector(".updateSection");
        baliseSection.classList.remove("cache"); 
    });

});



var listeBoutonDelete = document.querySelectorAll("button.delete");
listeBoutonDelete.forEach(function(bouton){
    bouton.addEventListener("click", function(event){
        console.log("TU AS CLIQUE");
        var idBouton = event.target.getAttribute("data-id");
        console.log(idBouton);
        var champId = document.querySelector("form#delete input[name=id]");
        champId.value = idBouton;

        var confirmation = window.confirm("Es tu vraiment sur ?");
        if (confirmation)
        {
            var formDelete = document.querySelector("form#delete");
            formDelete.submit();
        }
        else
        {
        }
    });

});



</script>



