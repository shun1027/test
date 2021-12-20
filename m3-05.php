<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charaset="UTF-8">
        <title>mission_3-5</title>
    </head>
    <body>
        <form action="" method="post">
        <?php
        #ファイル作成
        $filename="mission_3-5.txt";
        #新規投稿
        if(!empty($_POST["str"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && empty($_POST["edit_num"])){
            $str=$_POST["str"];
            $comment=$_POST["comment"];
            $date=date("Y年m月d日h時i分s秒");
            $pass=$_POST["password"];
            $fp=fopen($filename,"a");
            if(file_exists($filename)){
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                if(empty($lines)){
                    fwrite($fp,(count(file($filename))+1)."<>".$str."<>".$comment."<>".$pass."<>".$date.PHP_EOL);
                }elseif(!empty($lines)){
                    $cnt=count(file($filename));
                    $last=$lines[$cnt-1];
                    $counter=0;
                    foreach($lines as $line){
                        $items=explode("<>",$line);
                        if($last==$lines[$counter]){
                            fwrite($fp,($items[0]+1)."<>".$str."<>".$comment."<>".$pass."<>".$date.PHP_EOL);
                        }
                    $counter ++;
                    }
                }
            }
            fclose($fp);
        }
        
        #削除
        if(file_exists($filename)){
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $items=explode("<>",$line);
                if(!empty($_POST["delete"]) && !empty($_POST["delpass"])){
                    $del=$_POST["delete"];
                    $delpass=$_POST["delpass"];
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    $counter=0;
                    foreach($lines as $line){
                        $items=explode("<>",$line);
                        if($items[0]==$del && $items[3]==$delpass){
                        unset($lines[$counter]);
                        }
                        $counter ++;
                    }
                    $fp=fopen($filename,"w");
                    foreach($lines as $line){
                        fwrite($fp,$line.PHP_EOL);
                    }
                    fclose($fp);
                }
            }
        }
        
        #編集
        #変数に代入
        if(file_exists($filename)){
            if(!empty($_POST["edit"])){
                $edit=$_POST["edit"];
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                foreach($lines as $line){
                    $items=explode("<>",$line);
                    if($items[0]==$edit){
                        $editname=$items[1];
                        $editcomment=$items[2];
                        $editpass=$items[3];
                    }
                }
            }
            
        }
        if(file_exists($filename)){
            if(!empty($_POST["str"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && !empty($_POST["edit_num"])){
                $edit_num=$_POST["edit_num"];
                $str=$_POST["str"];
                $comment=$_POST["comment"];
                $pass=$_POST["password"];
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                $flag=true;
                $counter=0;
                foreach($lines as $line){
                    $items=explode("<>",$line);
                    if($items[0]==$edit_num){
                        $lines[$counter]=$items[0]."<>".$str."<>".$comment."<>".$pass."<>".$items[4];
                        $flag=false;
                    }
                    if($flag){
                        if($edit_num!=$items[0] && !empty($_POST["password"])){
                            $pass=$_POST["password"];
                            $date=date("Y年m月d日h時i分s秒");
                            $cnt=count(file($filename));
                            $last=$lines[$cnt-1];
                            $fp=fopen($filename,"a");
                            foreach($lines as $line){
                                $items=explode("<>",$line);
                                if($last==$lines[$counter]){
                                    fwrite($fp,($items[0]+1)."<>".$str."<>".$comment."<>".$pass."<>".$date.PHP_EOL);
                                }
                            }
                            fclose($fp);
                        }
                    }
                    $counter ++;
                }
                $fp=fopen($filename,"w");
                foreach($lines as $line){
                    fwrite($fp,$line.PHP_EOL);
                }
                fclose($fp);
            }
        }
        ?>
            <p>新規投稿フォーム</p>
            <!--名前-->
            <p>名前</p>
            <input type="text" name="str" placeholder="名前" autocomplete="off"
            value=<?php
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    if(!empty($_POST["ed_pass"])){
                        $ed_pass=$_POST["ed_pass"];
                        foreach($lines as $line){
                            $items=explode("<>",$line);
                            if(!empty($editname) && $items[0]==$edit && $ed_pass==$items[3]){
                                echo $editname;
                            }
                        }
                    }
                }
            ?>
            >
            <!--コメント-->
            <p>コメント</p>
            <input type="text" name="comment" placeholder="コメント" autocomplete="off"
            value=<?php
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    if(!empty($_POST["ed_pass"])){
                        $ed_pass=$_POST["ed_pass"];
                        foreach($lines as $line){
                            $items=explode("<>",$line);
                            if(!empty($editcomment) && $items[0]==$edit && $ed_pass==$items[3]){
                                echo $editcomment;
                            }
                        }
                    }
                }
            ?>
            >
            <!--編集対象番号（隠し）-->
            <input type="hidden" name="edit_num" autcomplete="off"
            value=<?php
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $items=explode("<>",$line);
                        if(!empty($edit) && $items[0]==$edit){
                            echo $edit;
                        }   
                    }
                }
            ?>
            ><br>
            <!--パスワード-->
            <input type="password" name="password" placeholder="パスワード" autocomplete="off"
            value=<?php
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $items=explode("<>",$line);
                        if(!empty($editpass) && $items[0]==$edit && $_POST["ed_pass"]==$items[3]){
                            echo $editpass;
                        }
                    }
                }
            ?>
            >
            <input type="submit" name="sub">
            <!--削除-->
            <p>削除フォーム</p>
            <input type="number" name="delete" placeholder="削除対象番号" autocomplete="off"><br>
            <input type="password" name="delpass" placeholder="パスワード" autocomplete="off">
            <input type="submit" name="sub">
            <!--編集-->
            <p>編集フォーム</p>
            <input type="number" name="edit" autocomplete="off"
            placeholder=<?php
                if(empty($edit)){
                    echo "編集対象番号";
                }
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $items=explode("<>",$line);
                        if(!empty($edit) && $items[0]==$edit && $_POST["ed_pass"]==$items[3]){
                            echo"編集可";
                        }
                    }
                }   
            ?>
            ><br>
            <input type="password" name="ed_pass" placeholder="パスワード" autocomplete="off">
            <input type="submit" name="sub">
        </form>
        
        <?php
        #表示
        if(file_exists($filename)){
            $liens=file($filename,FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $items=explode("<>",$line);
                echo $items[0].$items[1].$items[2].$items[4]."<br>";
            }
        }
        ?>
    </body>
</html>