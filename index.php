<?php
    // 外部ファイルの読み込み
    require_once 'util/message_util.php';
    
    // セッションスタート
    session_start();

    // 変数の初期化
    $messages = array();
    $flash_message = "";

    // 例外処理
    try {
        
        // データベースを扱う便利なインスタンス生成
        $message_util = new message_util();
        // データを全件取得
        $messages = $message_util->get_all_messages();
        
        // 便利なインスタンス削除
        $message_util = null;
        
        // フラッシュメッセージの取得とセッションからの削除
        if(isset($_SESSION['flash_message']) === true){
            $flash_message = $_SESSION['flash_message'];
            $_SESSION['flash_message'] = null;
        }
        
    } catch (PDOException $e) {
        echo 'PDO exception: ' . $e->getMessage();
        exit;
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
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico">
        <title>簡易掲示板</title>
    </head>
    <body>
        <div class="container">
            <div class="row mt-2">
                <h1 class="col-sm-12 text-center mt-2">投稿一覧</h1>
            </div>
            <div class="row mt-2">
                <h2 class="text-center col-sm-12"><?php print $flash_message; ?></h2>
            </div>
            <div class="row mt-2">
            <!--データが1件でもあれば-->
            <?php if(count($messages) !== 0){ ?> 
            
                <p><?php print count($messages); ?>件</p>
                <table class="col-sm-12 table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>ユーザ名</th>
                        <th>タイトル</th>
                        <th>内容</th>
                        <th>投稿時間</th>
                    </tr>
                    </tr>
                <?php foreach($messages as $message){ ?>
                    <tr>
                        <td><a href="show.php?id=<?php print $message->id; ?>"><?php print $message->id; ?></a></td>
                        <td><?php print $message->name; ?></td>
                        <td><?php print $message->title; ?></td>
                        <td><?php print $message->body; ?></td>
                        <td><?php print $message->created_at; ?></td>
                    </tr>
                <?php } ?>
                </table>
            <?php }else{ ?>
                    <p>データは、1件もありません。</p>
            <?php } ?>
            </div>
            <div class="row mt-5">
                <a href="new.php" class="btn btn-primary">新規投稿</a>
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
