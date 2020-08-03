<?php
// session_start();

require("src/pageconnection.php");

if (isset($_POST['submit'])){
// on vérifie que les champs ne sont pas vides
    if (!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) &&
        !empty($_POST['password_confirm']))
        {
        //on récupère les infos du form
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $pass_confirm = $_POST['password_confirm'];
            if (strlen($pseudo) <= 16) 
            {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
                {
                    //test si le mdp est different de confirm le mdp
                    if ($password == $pass_confirm) 
                    {
                        // si les mdp sont ok, on hash le mdp
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $req = $db->prepare("SELECT * FROM login WHERE pseudo LIKE ? OR email LIKE ?");
                        $req->execute(array($pseudo, $email));
                        $email_verification = $req->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($email_verification as $tableau) {
   
                        if ($tableau["pseudo"] === $pseudo) 
                        {
                            echo "le nom existe deja";
                        }
                        if ($tableau["email"] === $email) 
                        {
                            echo "l'email' existe deja";
                        }
                    }
                    $req = $db->prepare("INSERT INTO login(pseudo,email,password) VALUES(?,?,?)");
                    $req->execute([
                        $pseudo,
                        $email,
                        $hash
                        ]);
                }
            }
    }               $succesMessage = "Votre compte à bien été créé !"; 
                    header("location:connection.php?success=1");
}
}





//on test si email est utilise
// envoi de la requete


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certif</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <header>
        <h1>Inscription</h1>
    </header>
    <p id="info">Bienvenue sur mon site, pour en voir plus, inscrivez-vous. Sinon, <a href="connection.php">connectez-vous</a></p>
    <?php


    if (isset($_GET['password'])) {
        echo '<p id="error">Les mots de passe ne correspondent pas.</p>';
    } else if (isset($_GET['email'])) {
        echo '<p id="error">Cette adresse email est déjà utilisée.</p>';
    }

    //	else if(isset($_GET['success'])){
    //		echo '<p id="success">Inscription prise correctement en compte.</p>';
    //	}

    ?>
    <div id="form">
        <form method="post" action="inscription.php">
            <input type="text" name="pseudo" placeholder="pseudo" required></br>
            <input type="email" name="email" placeholder="email" required></br>
            <input type="password" name="password" placeholder="mot de passe" required></br>
            <input type="password" name="password_confirm" placeholder="confirme le mot de passe" required></br>
            <button type="submit" class="btn btn-dark" name="submit">Inscription</button>
        </form>
    </div>





</body>
</html>