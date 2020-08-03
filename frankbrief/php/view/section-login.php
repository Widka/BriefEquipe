<?php
 
session_start();
include '../includes/database.php';

 
if (isset($_SESSION['userEmail'])) {
    header('Location:section-index.php');
}
 
if (isset($_POST['submit'])) {
 
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    
        
            
        if ((!empty($email)) && (!empty($password))) {

            

                $database = getPDO();
                $requestUser = $database->prepare("SELECT * FROM login WHERE user_Email = ?");
                $requestUser->execute([$email]);
                $userCount = $requestUser->rowCount();
                if ($userCount == 1) {
                
                    $userInfo = $requestUser->fetch();
                    if ($userInfo && password_verify($password, $userInfo['user_Password']))
                    {
                    $_SESSION['userID'] = $userInfo['user_Id'];
                    $_SESSION['userPseudo'] = $userInfo['user_Pseudo'];
                    $_SESSION['userEmail'] = $userInfo['user_Email'];
                    $_SESSION['userPassword'] = $userInfo['user_Password'];
                    $_SESSION['userRegisterDate'] = $userInfo['registerdate'];
                    $succesMessage = 'Bravo, vous êtes maintenant connecté !';
                    header('refresh:3;url=section-admin.php');
                    } else {
                        $errorMessage = 'Mauvais mot de passe';
                    }
                } else {
                    $errorMessage = 'Email incorrect!';
                }
             
        } else {
                $errorMessage = 'Veuillez remplir tous les champs..';
        }
        
} 
?>
 

        <div class="text-center">
            <h3>Connexion</h3>
            <a href="section-index.php">Accueil</a>
            <a href="section-register.php">S'inscrire</a>
        </div>
        <div class="form-div text-center">
            <h3>Connexion</h3>
            <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
            <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
            <form method="post" action="">
 
                <span>Adresse Email :</span><br>
                <input type="email" name="email" placeholder="Email"><br>
 
                <span>Mot de passe :</span><br>
                <input type="password" name="password" placeholder="Mot de passe"><br><br>
 
                <input type="submit" name="submit" value="Se connecter">
            </form>
        </div>
    </body>
