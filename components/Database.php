<?php

class DB
{

    private $host;
    private $user;
    private $password;
    private $db;

    private $con;

    function __construct()
    {
        $this->host = $_ENV['HOST'];
        $this->user = $_ENV['USER'];
        $this->password = $_ENV['PASSWORD'];
        $this->db = $_ENV['DB_NAME'];
        try {
            $this->con = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->password);
        } catch (PDOException $e) {
            echo 'Failed to connect database ' . $e;
        }
    }

    public function Register($name, $username, $password, $descript, $question, $answer)
    {
        if (empty($name) || empty($username) || empty($password) || empty($descript) || empty($question) || empty($answer)) return 100;

        $query = $this->con->prepare('SELECT * FROM user WHERE name = :name OR username = :username ');
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() < 1) {
            $insertQuery = $this->con->prepare(
                'INSERT INTO `user`(`name`, `username`, `password`, `descript`, `question`, `answer`, `date`, `follow`) 
                VALUES ( :name , :username , :password ,:descript , :question, :answer, :date , 0)'
            );
            if (
                preg_match('/[^a-z0-9]+/', $name) ||
                preg_match('/[^a-z0-9]+/', $username) ||
                str_contains($descript, '<') ||
                strlen($name) > 50 ||
                strlen($username) > 50 ||
                strlen($question) > 50 ||
                strlen($answer) > 50 ||
                strlen($descript) > 300
            ) {
                return 300;
            }
            $username = strtolower($username);
            $password = md5($password);
            $answer = md5($answer);
            $date = date('Y/m/d H:i:s');

            $insertQuery->bindParam(':name', $name, PDO::PARAM_STR);
            $insertQuery->bindParam(':username', $username, PDO::PARAM_STR);
            $insertQuery->bindParam(':password', $password, PDO::PARAM_STR);
            $insertQuery->bindParam(':descript', $descript, PDO::PARAM_STR);
            $insertQuery->bindParam(':question', $question, PDO::PARAM_STR);
            $insertQuery->bindParam(':answer', $answer, PDO::PARAM_STR);
            $insertQuery->bindParam(':date', $date, PDO::PARAM_STR);

            $result = $insertQuery->execute();
            if ($result) return 400;
        } else {
            return 200;
        }
    }

    public function Login($username, $password)
    {
        $password = md5($password);
        $query = $this->con->prepare('SELECT * FROM user WHERE username = :username AND password = :password LIMIT 1');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() == 1) {
            $user = $query->fetchAll(PDO::FETCH_OBJ)[0];

            $token1 = sha1($username . time() + random_int(0, 100000));
            $token2 = sha1($username . random_int(0, 100000) . random_int(0, 100000));
            $id = $user->id;
            $date = date('Y/m/d H:i:s');

            $insertLogind = $this->con->prepare(
                'INSERT INTO `logined`(`token1`, `token2`, `user_id`, `date`) 
                VALUES ( :token1 , :token2 , :id, :date)'
            );
            $insertLogind->bindParam(':token1', $token1, PDO::PARAM_STR);
            $insertLogind->bindParam(':token2', $token2, PDO::PARAM_STR);
            $insertLogind->bindParam(':date', $date, PDO::PARAM_STR);
            $insertLogind->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $insertLogind->execute();
            if ($result) {
                setcookie('token1', $token1, time() + (86400 * 30), "/");
                setcookie('token2', $token2, time() + (86400 * 30), "/");
                return true;
            } else {
                return false;
            }
        }
    }

    public function CheckLogin()
    {
        if (isset($_COOKIE['token1']) && isset($_COOKIE['token2'])) {

            $query = $this->con->prepare('SELECT * FROM logined WHERE token1 = :token1 AND token2 = :token2 LIMIT 1');
            $query->bindParam(':token1', $_COOKIE['token1'], PDO::PARAM_STR);
            $query->bindParam(':token2', $_COOKIE['token2'], PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $logined = $query->fetchAll(PDO::FETCH_OBJ)[0];

                $queryUser = $this->con->prepare('SELECT * FROM user WHERE id = :id LIMIT 1');
                $queryUser->bindParam(':id', $logined->user_id, PDO::PARAM_INT);
                $queryUser->execute();
                $user = $queryUser->fetchAll(PDO::FETCH_OBJ)[0];
                return ['id' => $user->id, 'name' => $user->name, 'username' => $user->username, 'descript' => $user->descript, 'date' => $user->date, 'follow' => $user->follow];
            } else {
                $this->Logout();
                exit;
            }
        } else {
            return false;
        }
    }
    public function SearchUser($name)
    {
        $query = $this->con->prepare('SELECT * FROM user WHERE name = :name LIMIT 1');
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $user = $query->fetchAll(PDO::FETCH_OBJ)[0];
            return ['name' => $user->name, 'username' => $user->username, 'descript' => $user->descript, 'date' => $user->date, 'follow' => $user->follow];
        } else {
            return false;
        }
    }
    public function AllUser()
    {
        $query = $this->con->prepare('SELECT `name`, `descript`, `date`, `follow` FROM `user` ORDER BY follow DESC LIMIT 100');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function FindUser($search)
    {
        $search = "%$search%";
        $query = $this->con->prepare('SELECT name, follow, date, descript FROM user WHERE name LIKE :search');
        $query->bindParam(':search', $search, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Logout()
    {
        if (isset($_COOKIE['token1']) && isset($_COOKIE['token2'])) {

            $query = $this->con->prepare('DELETE FROM `logined` WHERE token1 = :token1 AND token2 = :token2');
            $query->bindParam(':token1', $_COOKIE['token1'], PDO::PARAM_STR);
            $query->bindParam(':token2', $_COOKIE['token2'], PDO::PARAM_STR);
            $result = $query->execute();
            unset($_COOKIE['token1']);
            unset($_COOKIE['token2']);
            setcookie('token1', null, -1, "/");
            setcookie('token2', null, -1, "/");
        }
        header('Location: /login');
    }

    public function CheckFollow($atk, $def)
    {
        if ($atk == $def) return false;
        $query = $this->con->prepare('SELECT * FROM follow WHERE atk = :atk AND def = :def LIMIT 1');
        $query->bindParam(':atk', $atk, PDO::PARAM_STR);
        $query->bindParam(':def', $def, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function MyFollow()
    {
        $user = $this->CheckLogin();
        if (!$user) return false;
        $query = $this->con->prepare('SELECT * FROM follow WHERE atk = :name ORDER BY date DESC');
        $query->bindParam(':name', $user['name']);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    // update follower
    public function FetchFollow($name)
    {
        $query = $this->con->prepare('SELECT * FROM follow WHERE def = :name');
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();

        $updateFollow = $this->con->prepare('UPDATE user SET follow = :count WHERE name = :name');
        $updateFollow->bindParam(':count', $count, PDO::PARAM_INT);
        $updateFollow->bindParam(':name', $name, PDO::PARAM_STR);
        $updateFollow->execute();
    }
    public function Follow($atk, $def)
    {
        if ($atk == $def) return false;

        $check = $this->CheckFollow($atk, $def);
        // เช็คว่า ได้ติดตามหรือเปล่า
        if ($check) {
            // ถ้า ติดตาม ให้ เลิกติดตาม
            $query = $this->con->prepare('DELETE FROM follow WHERE atk = :atk AND def = :def');
            $query->bindParam(':atk', $atk, PDO::PARAM_STR);
            $result = $query->bindParam(':def', $def, PDO::PARAM_STR);
            $query->execute();
            $this->FetchFollow($def);
            return $result;
        } else {
            // ถ้า ไม่ได้ติดตาม ให้ ติดตาม
            $date = date('Y/m/d H:i:s');

            $query = $this->con->prepare(
                'INSERT INTO `follow` (`atk`, `def`, `date`) 
                VALUES ( :atk , :def , :date )'
            );

            $query->bindParam(':atk', $atk, PDO::PARAM_STR);
            $query->bindParam(':def', $def, PDO::PARAM_STR);
            $query->bindParam(':date', $date, PDO::PARAM_STR);
            $result = $query->execute();
            $this->FetchFollow($def);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function EditDescript($descript)
    {
        $user = $this->CheckLogin();
        $query = $this->con->prepare('UPDATE user SET descript = :descript WHERE username = :username');
        $query->bindParam(':descript', $descript, PDO::PARAM_STR);
        $query->bindParam(':username', $user['username'], PDO::PARAM_STR);
        $result = $query->execute();
        return $result;
    }
    public function ChangePassword($old, $new)
    {
        $user = $this->CheckLogin();
        $old = md5($old);
        $new = md5($new);

        $query = $this->con->prepare('SELECT * FROM user WHERE username = :username AND password = :password LIMIT 1');
        $query->bindParam(':username', $user['username'], PDO::PARAM_STR);
        $query->bindParam(':password', $old, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $queryChange = $this->con->prepare('UPDATE user SET password = :password WHERE username = :username');
            $queryChange->bindParam(':password', $new, PDO::PARAM_STR);
            $queryChange->bindParam(':username', $user['username'], PDO::PARAM_STR);
            $result = $queryChange->execute();
            if ($result) return 200;
        } else {
            return 400;
        }
    }
    public function ShowLog()
    {
        $user = $this->CheckLogin();
        $query = $this->con->prepare('SELECT * FROM logined WHERE user_id = :id ORDER BY date DESC');
        $query->bindParam(':id', $user['id'], PDO::PARAM_INT);
        $query->execute();
        if ($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } else {
            return false;
        }
    }
    public function DeleteLog($id)
    {
        $user = $this->CheckLogin();
        $query = $this->con->prepare('DELETE FROM logined WHERE id = :id AND user_id = :user');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':user', $user['id'], PDO::PARAM_INT);
        $query->execute();
    }

    public function CreatePackage($name, $descript, $github, $installer, $type)
    {
        if (
            preg_match('/[^a-z0-9,-]+/', $name) ||
            str_contains($descript, '<') ||
            str_contains($github, '<') ||
            str_contains($installer, '<') ||
            str_contains($type, '<') ||
            !str_contains($installer, 'https://github.com/') ||
            !str_contains($installer, '/tree/') ||
            strlen($name) > 50 ||
            strlen($descript) > 300 ||
            strlen($github) > 120 ||
            strlen($installer) > 120
        ) {
            return 300;
        }

        $user = $this->CheckLogin();
        $findCheck = $this->con->prepare('SELECT * FROM package WHERE name = :name');
        $findCheck->bindParam(':name', $name, PDO::PARAM_STR);
        $findCheck->execute();
        if ($findCheck->rowCount() == 0) {
            $date = date('Y/m/d H:i:s');
            $download = 0;

            $query = $this->con->prepare(
                'INSERT INTO `package`(`name`, `descript`, `github`, `installer`, `dev`, `date`, `modif`, `type`, `download`) 
                VALUES ( :name , :descript , :github , :installer , :dev , :date , :modif , :type , :download )'
            );
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':descript', $descript, PDO::PARAM_STR);
            $query->bindParam(':github', $github, PDO::PARAM_STR);
            $query->bindParam(':installer', $installer, PDO::PARAM_STR);
            $query->bindParam(':dev', $user['name'], PDO::PARAM_STR);
            $query->bindParam(':date', $date, PDO::PARAM_STR);
            $query->bindParam(':modif', $date, PDO::PARAM_STR);
            $query->bindParam(':type', $type, PDO::PARAM_INT);
            $query->bindParam(':download', $download, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return 400;
            }
        } else {
            return 200;
        }
    }
    public  function CheckPackage($package_name, $type = 0)
    {
        if ($type > 0) {
            $query = $this->con->prepare('SELECT * FROM package WHERE name = :name AND type = ' . $type . ' LIMIT 1');
        } else {
            $query = $this->con->prepare('SELECT * FROM package WHERE name = :name LIMIT 1');
        }
        $query->bindParam(':name', $package_name, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC)[0];
        } else {
            return false;
        }
    }
    public function MyPackage()
    {
        $user = $this->CheckLogin();
        $query = $this->con->prepare('SELECT * FROM package WHERE dev = :name');
        $query->bindParam(':name', $user['name'], PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function YourPackage($name, $limit = 0)
    {
        if ($limit > 0) {
            $query = $this->con->prepare('SELECT * FROM package WHERE dev = :name LIMIT ' . $limit);
        } else {
            $query = $this->con->prepare('SELECT * FROM package WHERE dev = :name');
        }
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function AllPackage()
    {
        $query = $this->con->prepare('SELECT * FROM package ORDER BY download DESC limit 100');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function SearchPackage($search, $mode = 'all')
    {
        $search = "%$search%";
        if ($mode == 'library') {
            $query = $this->con->prepare('SELECT * FROM package WHERE name LIKE :name AND type = 1 ORDER BY download DESC LIMIT 100');
        } else if ($mode == 'template') {
            $query = $this->con->prepare('SELECT * FROM package WHERE name LIKE :name AND type = 2 ORDER BY download DESC LIMIT 100');
        } else {
            $query = $this->con->prepare('SELECT * FROM package WHERE name LIKE :name ORDER BY download DESC LIMIT 100');
        }
        $query->bindParam(':name', $search, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function EditPackage($name, $descript, $installer)
    {
        $user = $this->CheckLogin();
        $package = $this->CheckPackage($name);
        if ($user['name'] == $package['dev']) {
            if (
                str_contains($descript, '<') ||
                str_contains($installer, '<') ||
                !str_contains($installer, 'https://github.com/') ||
                !str_contains($installer, '/tree/') ||
                strlen($descript) > 300 ||
                strlen($installer) > 120
            ) {
                return false;
            } else {
                $modif = date('Y/m/d H:i:s');

                $query = $this->con->prepare('UPDATE package SET descript = :descript, installer = :installer, modif = :modif WHERE name = :name');
                $query->bindParam(':descript', $descript, PDO::PARAM_STR);
                $query->bindParam(':installer', $installer, PDO::PARAM_STR);
                $query->bindParam(':modif', $modif, PDO::PARAM_STR);
                $query->bindParam(':name', $name, PDO::PARAM_STR);
                return $query->execute();
            }
        } else {
            return false;
        }
    }
    public function DeletePackage($name, $password)
    {
        $user = $this->CheckLogin();
        $package = $this->CheckPackage($name);
        if ($user['name'] == $package['dev']) {
            $password = md5($password);
            $queryCheckPassword = $this->con->prepare('SELECT * FROM user WHERE username = :username AND password = :password LIMIT 1');
            $queryCheckPassword->bindParam(':username', $user['username'], PDO::PARAM_STR);
            $queryCheckPassword->bindParam(':password', $password, PDO::PARAM_STR);
            $queryCheckPassword->execute();
            if ($queryCheckPassword->rowCount() > 0) {
                $queryDelete = $this->con->prepare('DELETE FROM `package` WHERE name = :name');
                $queryDelete->bindParam(':name', $package['name'], PDO::PARAM_STR);
                return $queryDelete->execute();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function CreateVersion($pk_name, $v, $descript, $github, $installer)
    {
        if (
            preg_match('/[^a-z0-9,-,.]+/', $v) ||
            str_contains($descript, '<') ||
            str_contains($github, '<') ||
            str_contains($installer, '<') ||
            !str_contains($installer, 'https://github.com/') ||
            !str_contains($installer, '/tree/') ||
            strlen($v) > 50 ||
            strlen($descript) > 300 ||
            strlen($github) > 120 ||
            strlen($installer) > 120
        ) {
            return 300;
        }

        $user = $this->CheckLogin();
        $package = $this->CheckPackage($pk_name);
        if ($user['name'] != $package['dev']) return 300;
        // เช็ค ซ้ำ
        $queryCheck = $this->con->prepare('SELECT * FROM vertion WHERE package_name = :pk_name AND version = :version');
        $queryCheck->bindParam(':pk_name', $pk_name, PDO::PARAM_STR);
        $queryCheck->bindParam(':version', $v, PDO::PARAM_STR);
        $queryCheck->execute();
        if ($queryCheck->rowCount() > 0) {
            return 200;
        }

        $queryInsert = $this->con->prepare(
            'INSERT INTO `vertion`(`package_name`, `version`, `descript`, `github`, `installer`, `date`, `modif`, `type`) 
            VALUES ( :pk_name , :version , :descript , :github , :installer , :date , :modif , :type )'
        );
        $date = date('Y/m/d H:m:s');

        $queryInsert->bindParam(':pk_name', $pk_name, PDO::PARAM_STR);
        $queryInsert->bindParam(':version', $v, PDO::PARAM_STR);
        $queryInsert->bindParam(':descript', $descript, PDO::PARAM_STR);
        $queryInsert->bindParam(':github', $github, PDO::PARAM_STR);
        $queryInsert->bindParam(':installer', $installer, PDO::PARAM_STR);
        $queryInsert->bindParam(':date', $date, PDO::PARAM_STR);
        $queryInsert->bindParam(':modif', $date, PDO::PARAM_STR);
        $queryInsert->bindParam(':type', $package['type'], PDO::PARAM_STR);
        $result = $queryInsert->execute();
        if ($result) {
            return 400;
        }
    }

    public function MyVersion($package)
    {
        $query = $this->con->prepare('SELECT * FROM vertion WHERE package_name = :pk_name ORDER BY modif DESC');
        $query->bindParam(':pk_name', $package, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function CheckVersion($package, $version, $type = 0)
    {
        if ($type > 0) {
            $query = $this->con->prepare('SELECT * FROM vertion WHERE package_name = :pk_name AND version = :version AND type = ' . $type . ' LIMIT 1');
        } else {
            $query = $this->con->prepare('SELECT * FROM vertion WHERE package_name = :pk_name AND version = :version LIMIT 1');
        }
        $query->bindParam(':pk_name', $package, PDO::PARAM_STR);
        $query->bindParam(':version', $version, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC)[0];
        } else {
            return false;
        }
    }
    public function EditVersion($package_name, $version, $descript, $installer)
    {
        if (
            str_contains($descript, '<') ||
            str_contains($installer, '<') ||
            !str_contains($installer, 'https://github.com/') ||
            !str_contains($installer, '/tree/') ||
            strlen($descript) > 300 ||
            strlen($installer) > 120
        ) {
            return false;
        }

        $user = $this->CheckLogin();
        $package = $this->CheckPackage($package_name);
        $version = $this->CheckVersion($package['name'], $version);
        if ($user['name'] != $package['dev'] || $package['name'] != $version['package_name']) return false;

        $modif = date('Y/m/d H:i:s');

        $query = $this->con->prepare(
            'UPDATE `vertion` SET `descript`= :descript ,`installer`= :installer ,`modif`= :modif 
            WHERE package_name = :pk_name AND version = :version'
        );
        $query->bindParam(':descript', $descript, PDO::PARAM_STR);
        $query->bindParam(':installer', $installer, PDO::PARAM_STR);
        $query->bindParam(':modif', $modif, PDO::PARAM_STR);
        $query->bindParam(':pk_name', $package['name'], PDO::PARAM_STR);
        $query->bindParam(':version', $version['version'], PDO::PARAM_STR);
        $result = $query->execute();
        if ($result) return true;
    }
    public function DeleteVersion($pk_name, $version, $password)
    {
        $package = $this->CheckPackage($pk_name);
        if (!$package) return false;
        $version = $this->CheckVersion($package['name'], $version);
        if (!$version) return false;
        $user = $this->CheckLogin();
        if ($user['name'] != $package['dev'] || $package['name'] != $version['package_name']) return false;

        $password = md5($password);

        $queryCheckPassword = $this->con->prepare('SELECT * FROM user WHERE username = :username AND password = :password LIMIT 1');
        $queryCheckPassword->bindParam(':username', $user['username'], PDO::PARAM_STR);
        $queryCheckPassword->bindParam(':password', $password, PDO::PARAM_STR);
        $queryCheckPassword->execute();
        if ($queryCheckPassword->rowCount() > 0) {
            $queryDelete = $this->con->prepare('DELETE FROM `vertion` WHERE package_name = :pk_name AND version = :version');
            $queryDelete->bindParam(':pk_name', $package['name'], PDO::PARAM_STR);
            $queryDelete->bindParam(':version', $version['version'], PDO::PARAM_STR);
            return $queryDelete->execute();
        } else {
            return false;
        }
    }
    public function Feed()
    {
        $post = [];
        $user = $this->CheckLogin();
        $follow = $this->MyFollow();
        // print_r($follow);
        foreach ($follow as $fol) {
            $yr_package = $this->YourPackage($fol['def'], 10);
            foreach ($yr_package as $yp) {
                array_push($post, $yp);
            }
        }
        array_multisort(array_column($post, 'modif'), SORT_DESC, $post);
        return $post;
    }
    public function DownloadCount($pk_name)
    {
        $query = $this->con->prepare('UPDATE `package` SET `download` = `download`+1 WHERE name = :pk_name');
        $query->bindParam(':pk_name', $pk_name, PDO::PARAM_STR);
        $query->execute();
    }
};

$export = null;
