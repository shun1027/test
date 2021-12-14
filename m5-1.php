<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charaset="UTF-8">
        <title>mission5-1</title>
    </head>
    <body>
        <form action="" method="post">
    
    <?php
    #データベース接続
    $dsn="データベース名";
    $user="ユーザー名";
    $password="パスワード";
    $pdo= new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
    $sql="CREATE TABLE IF NOT EXISTS tbtest"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."password varchar(50),"
    ."date DATETIME"
    .");";
    $stmt=$pdo->query($sql);
    
    #新規投稿
    if(!empty($_POST["str"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && empty($_POST["edit_num"])){
        $str=$_POST["str"];
        $cmt=$_POST["comment"];
        $pass=$_POST["password"];
        $day=date("Y-m-d H:i:s");
    #データ入力
        $sql=$pdo->prepare("INSERT INTO tbtest(name,comment,password,date)VALUE(:name,:comment,:password,:date)");
        $sql->bindParam(":name",$name,PDO::PARAM_STR);
        $sql->bindParam(":comment",$comment,PDO::PARAM_STR);
        $sql->bindParam(":password",$password,PDO::PARAM_STR);
         $sql->bindParam(":date",$date,PDO::PARAM_STR);
        $name=$str;
        $comment=$cmt;
        $password=$pass;
        $date=$day;
        $sql->execute();
    }
    #データ削除
    if(!empty($_POST["delete"]) && !empty($_POST["del_password"])){
        $del=$_POST["delete"];
        $del_pass=$_POST["del_password"];
        $password=$del_pass;
        $id=$del;
        $sql="delete from tbtest where id=:id AND password=:password";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->bindParam(":password",$password,PDO::PARAM_STR);
        $stmt->execute();
    }
    
    #データ編集
    if(!empty($_POST["str"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && !empty($_POST["edit_num"])){
        $str=$_POST["str"];
        $cmt=$_POST["comment"];
        $pass=$_POST["password"];
        $edit_num=$_POST["edit_num"];
        $id=$edit_num;
        $name=$str;
        $comment=$cmt;
        $password=$pass;
        $sql="UPDATE tbtest SET name=:name,comment=:comment,password=:password WHERE id=:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(":name",$name,PDO::PARAM_STR);
        $stmt->bindParam(":comment",$comment,PDO::PARAM_STR);
        $stmt->bindParam(":password",$password,PDO::PARAM_STR);
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
    }
    ?>
            <p>名前</p>
            <input type="text" name="str" placeholder="名前" autocomplete="off"
            value=<?php
            if(!empty($_POST["edit"]) && !empty($_POST["edit_password"])){
                $edit=$_POST["edit"];
                $edit_pass=$_POST["edit_password"];
                $id=$edit;
                $password=$edit_pass;
                $sql="SELECT*FROM tbtest WHERE id=:id AND password=:password";
                $stmt=$pdo->prepare($sql);
                $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt->bindParam(":password",$password,PDO::PARAM_STR);
                $stmt->execute();
                $results=$stmt->fetchAll();
                    foreach($results as $row){
                        echo $row["name"];
                    }
            }
            ?>
            >
            <P>コメント</P>
            <input type="text" name="comment" placeholder="コメント" autocomplete="off"
            value=<?php
                if(!empty($_POST["edit"]) && !empty($_POST["edit_password"])){
                $edit=$_POST["edit"];
                $edit_pass=$_POST["edit_password"];
                $id=$edit;
                $sql="SELECT*FROM tbtest WHERE id=:id AND password=:password";
                $stmt=$pdo->prepare($sql);
                $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt->bindParam(":password",$password,PDO::PARAM_STR);
                $stmt->execute();
                $results=$stmt->fetchAll();
                    foreach($results as $row){
                        echo $row["comment"];
                    }
            }
            ?>
            >
            <input type="hidden" name="edit_num" autocomplete="off"
            value=<?php
                if(!empty($_POST["edit"]) && !empty($_POST["edit_password"])){
                $edit=$_POST["edit"];
                $edit_pass=$_POST["edit_password"];
                $id=$edit;
                $sql="SELECT*FROM tbtest WHERE id=:id AND password=:password";
                $stmt=$pdo->prepare($sql);
                $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt->bindParam(":password",$password,PDO::PARAM_STR);
                $stmt->execute();
                $results=$stmt->fetchAll();
                    foreach($results as $row){
                        echo $row["id"];
                    }
            }
            ?>
            >
            <p>パスワード</p>
            <input type="password" name="password" placeholder="パスワード" autocomplete="off"
            value=<?php
                if(!empty($_POST["edit"]) && !empty($_POST["edit_password"])){
                $edit=$_POST["edit"];
                $edit_pass=$_POST["edit_password"];
                $id=$edit;
                $sql="SELECT*FROM tbtest WHERE id=:id AND password=:password";
                $stmt=$pdo->prepare($sql);
                $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt->bindParam(":password",$password,PDO::PARAM_STR);
                $stmt->execute();
                $results=$stmt->fetchAll();
                    foreach($results as $row){
                        echo $row["password"];
                    }
            }
            ?>
            >
            <input type="submit" name="sub">
            <p>削除</p>
            <input type="number" name="delete" placeholder="削除対象番号" autocomplete="off"><br>
            <!--パスワード-->
            <input type="password" name="del_password" placeholder="パスワード" autocomplete="off">
            <input type="submit" value="削除">
            <p>編集</p>
            <input type="number" name="edit" placeholder="編集対象番号" autocomplete="off"><br>
            <!--パスワード-->
            <input type="password" name="edit_password" placeholder="パスワード" autocomplete="off">
            <input type="submit" value="編集">
        </form>
    </body>
    
    <?php
    #データ表示
    $sql="SELECT*FROM tbtest";
    $stmt=$pdo->query($sql);
    $results=$stmt->fetchAll();
    foreach($results as $row){
        echo $row["id"].",";
        echo $row["name"].",";
        echo $row["comment"]."<br>";
    echo "<hr>";
    }
    ?>
</html>