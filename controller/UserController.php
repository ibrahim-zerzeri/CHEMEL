<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/User.php');

class UserController
{
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Assuming you are fetching as an associative array
    }
    public function listUsers()
    {
        $sql = "SELECT * FROM users";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteUser($id)
    {
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

    function addUser($user)
    {
        var_dump($user);
        $sql = "INSERT INTO users (username, password, birthday, establishment)  
        VALUES (:username, :password, :birthday, :establishment)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'birthday' => $user->getBirthday(),
                'establishment' => $user->getEstablishment()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updateUser($user, $id)
    {
        var_dump($user);
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE users SET 
                    username = :username,
                    password = :password,
                    birthday = :birthday,
                    establishment = :establishment
                WHERE id = :id'
            );

            $query->execute([
                'id' => $id,
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

    function showUser($id)
    {
        $sql = "SELECT * from users where id = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $user = $query->fetch();
            return $user;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
