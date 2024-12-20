<?php

include(__DIR__ . '/../Model/User.php');

class UserController {
    public function listUsers() {
        $sql = "SELECT * FROM users";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    

    public function addUser($user) {
        $sql = "INSERT INTO users (email,username, password, birthday, establishment, ban,activation_token_hash) VALUES (:email, :username, :password, :birthday, :establishment,FALSE,:activation_token_hash)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'birthday' => $user->getBirthday(),
                'establishment' => $user->getEstablishment(),
                'activation_token_hash' => $user->getToken()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updateUser($user, $id) {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE users SET 
                    email = : email,
                    username = :username,
                    password = :password,
                    birthday = :birthday,
                    establishment = :establishment
                WHERE id = :id'
            );

            $query->execute([
                'id' => $id,
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'birthday' => $user->getBirthday(),
                'establishment' => $user->getEstablishment()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    public function banUser($id) {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE users SET 
                    ban= NOT ban
                WHERE id = :id'
            );

            $query->execute([
                'id' => $id,
                
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    public function showUser($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);

            $user = $query->fetch();
            return $user;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
