<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $message_id = $_GET['id'];
        $dsn = 'mysql:host=localhost;dbname=bbs';
        $username = 'root';
        $password = '';
        $message = "";
    
        try {
            $message_id = $_GET['id'];
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
            ); 
            
            $pdo = new PDO($dsn, $username, $password, $options);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            // PDO::fetch()でカレント1件を取得
            $stmt = $pdo->prepare('SELECT * FROM messages where id = :id');
            $stmt->bindValue(':id', $message_id, PDO::PARAM_INT);
            $stmt->execute();
            $message = $stmt->fetch();
        } catch (PDOException $e) {
            echo 'PDO exception: ' . $e->getMessage();
            exit;
        }
    }else{
        
        $message_id = $_POST['id'];
        // print $message_id;
        $dsn = 'mysql:host=localhost;dbname=bbs';
        $username = 'root';
        $password = '';
        $flash_message = null;
    
        try {
        
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
            ); 
            
            $pdo = new PDO($dsn, $username, $password, $options);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            if($_POST['kind_method'] === 'update'){
                // print 'update!'; 
                $name = $_POST['name'];
                $title = $_POST['title'];
                $body = $_POST['body'];
                // print $name;
                // PDO::fetch()でカレント1件を取得
                $stmt = $pdo->prepare('UPDATE messages set name=:name, title=:title, body=:body where id = :id');
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':body', $body, PDO::PARAM_STR);
                $stmt->bindValue(':id', $message_id, PDO::PARAM_INT);
                $stmt->execute();
                $flash_message = "投稿が更新されました。";
                
            }else if($_POST['kind_method'] === 'delete'){
                
                // print 'delete!';
                // PDO::fetch()でカレント1件を取得
                $stmt = $pdo->prepare('DELETE FROM messages where id = :id');
                $stmt->bindValue(':id', $message_id, PDO::PARAM_INT);
                $stmt->execute();
                $flash_message = "投稿が削除されました。";
            }    
            
        } catch (PDOException $e) {
            echo 'PDO exception: ' . $e->getMessage();
            exit;
        }
        
    }
        
    
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        <title>投稿詳細</title>
        <style>
            h2{
                color: red;
                background-color: pink;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row mt-2">
                <h1 class="text-center col-sm-12">id: <?php print $message_id; ?> の投稿詳細</h1>
            </div>
            <div class="row mt-2">
                <form class="col-sm-12" action="show.php" method="POST">
                    <div class="row mt-2">
                        <h2 class="text-center col-sm-12"><?php print $flash_message; ?></h1>
                    </div>
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">名前</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="name" required value="<?php print $message['name']; ?>">
                        </div>
                    </div>
                
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">タイトル</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="title" required value="<?php print $message['title']; ?>";>
                        </div>
                    </div>
                    
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">内容</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="body" required value="<?php print $message['body']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="id" value="<?php print $message['id']; ?>">
                    </div>
                
                    <!-- 1行 -->
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-1">
                            <button type="submit" name="kind_method" value="update" class="btn btn-primary">更新</button>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" name="kind_method" value="delete" class="btn btn-danger">削除</button>
                        </div>
                    </div>
                </form>
             <div class="row mt-5">
                <a href="index.php" class="btn btn-primary">投稿一覧</a>
            </div>
        </div>
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS, then Font Awesome -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    </body>
</html>