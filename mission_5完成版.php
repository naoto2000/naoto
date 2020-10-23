<?php
    //■■■データベースに接
    $dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo =new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //■■■day2テーブルを作成
    $sql = "CREATE TABLE IF NOT EXISTS day5"
    ."("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	."name char(32),"
	."comment TEXT,"
	."dt DATETIME,"
	."password char(32)"
	.");";
	$stmt = $pdo->query($sql);
	
    //■■■テーブル名を表示
    /*
    $sql ='SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[0];
		echo '<br>';
	}
	echo "<hr>";
	
	//■■■テーブルの詳細(中身）を表示
	
	$sql ='SHOW CREATE TABLE day3';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[1];
	}
	echo "<hr>";
	*/
	
	$edi_number = '';
    $edi_name = '' ;
    $edi_comment = '';
	$password1 ='';
	$password2 ='';
	$name = $_POST["NAME"];
	$comment = $_POST["str"];
	
    ///■■■編集フォーム///
	$spy =$_POST["spy"];
    if(!empty($spy && $name&& $comment)){ 
        if(!empty($_POST["pass"])){
            $pass=$_POST["pass"];
            //変更する投稿番号、名前、コメント
           
	        $id = $spy;
	        $name2 = $_POST["NAME"];
	        $comment2 = $_POST["str"];
	        $dt2 = date("Y/m/d/H:i:s");
	        $password2 = $_POST["pass"];
	        
	        $sql = 'UPDATE day5 SET name=:name2,comment=:comment2,dt=:dt2,password=:password2 WHERE id=:id';
        	$stmt = $pdo->prepare($sql);
        	//差し替えるパラメータのデータを入力
        	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->bindParam(':name2', $name2, PDO::PARAM_STR);
	        $stmt->bindParam(':comment2', $comment2, PDO::PARAM_STR);
	        $stmt->bindParam(':dt2', $dt2, PDO::PARAM_STR);
	        $stmt->bindParam(':password2', $password2, PDO::PARAM_STR);
	        
	        
	        
	        $stmt->execute();
            
           
           
        }
       
       }
	///■■■投稿フォーム///
	//■■■if文で名前とコメントが入っている場合
	elseif(!empty($name&&$comment)){
	    if(!empty($_POST["pass"])){
           
    	    //■■■insert文で,、テーブルにデータを追加
    	    $sql = $pdo -> prepare("INSERT INTO day5 (name, comment,dt,password) VALUES (:name, :comment,:dt,:password)");
            
	        $sql -> bindParam(':name', $name1, PDO::PARAM_STR);
	        $sql -> bindParam(':comment', $comment1, PDO::PARAM_STR);
	        $sql -> bindParam(':dt', $dt1, PDO::PARAM_STR);
	        $sql -> bindParam(':password', $password1, PDO::PARAM_STR);
	        $name1 = $_POST["NAME"];
	        $comment1 = $_POST["str"];
	        //■■■日時を代入
	        $dt1 = date("Y/m/d/H:i:s");
	        //パスワード
	        $password1 = $_POST["pass"];
        	$sql -> execute();
        	
	     }
    }
    
   
    ///■■■削除フォーム///
     ///■■■削除フォームが入力された時
	 if(!empty($_POST["submit2"])){
	     ///■■■パスワードが入っている時
        if(!empty($_POST["pass2"])){
      
              ///■■■whereでidを特定
            $id = $_POST["del"];
            $sql = 'SELECT password from day5 where id=:id';
            $ppp = $pdo->prepare($sql);
            $ppp->bindParam(':id', $id, PDO::PARAM_INT);
            $ppp->execute();
             ///■■■foreach文で配列変数を変数に置き換える
            $results = $ppp->fetchAll();
           	foreach ($results as $row){
           	    //$rowの中にはテーブルのカラム名が入る
	        	 
                if($row['password'] == $_POST["pass2"]){
            
        	        $sql = 'delete from day5 where id=:id';
        	
        	        $stmt = $pdo->prepare($sql);
	                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                $stmt->execute();
                }
           	}
        }
    } 
	
	///■■■編集フォーム///
    if(!empty($_POST["submit3"]&&$_POST["edi"])){
        if(!empty($_POST["pass3"])){
            $pass3=$_POST["pass3"];
            $id = $_POST["edi"];
            $sql = 'SELECT *from day5 WHERE id=:id';
            $ppp = $pdo->prepare($sql);
            $ppp->bindParam(':id', $id, PDO::PARAM_INT);
            $ppp->execute();
             ///■■■foreach文で配列変数を変数に置き換える
            $results = $ppp->fetchAll();
           	foreach ($results as $row){
           	   
           	
           	    
                if($row['password'] == $_POST["pass3"]){
            
        	        $sql = 'SELECT from day5 WHERE id=:id';
        	//失敗！
        	        $stmt = $pdo->prepare($sql);
	                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                $stmt->execute();
	                foreach ($results as $row){
		                //$rowの中にはテーブルのカラム名が入る
		                	$edi_number =  $row['id'];
                            $edi_name = $row['name'];
                            $edi_comment = $row['comment'];
                    }
                } 
           	}
     }
    }
	
    ?>
<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="UTF-8">
    <title>mission_3-6</title>
    </head>
    <body>
	    <form action="" method="POST">
        <!--投稿フォーム-->
            <input type="text" name="NAME" placeholder ="お名前"
            value="<?php echo "$edi_name"  ; ?>"><br>
            <input type="comment" name="str" placeholder ="コメント"
            value="<?php echo $edi_comment ; ?>">
            <input type="submit" name="submit"><br>
            <input type="hidden" name="spy"  value="<?php echo $edi_number ; ?>">
            <input type="password" name="pass" placeholder ="パスワード"><br><br>
        </form>
        
        <!--削除フォーム-->
        <form action="" method="POST"> 
            <input type="comment" name="del" placeholder ="削除番号">
            <input type="submit" name="submit2" value="削除"><br>
            <input type="password" name="pass2" placeholder ="パスワード">
            <br><br>
        </form>
        
        <!--編集フォーム-->
        <form action="" method="POST"> 
            <input type="comment" name="edi" placeholder ="編集対象番号">
            <input type="submit" name="submit3" value="編集"><br>
            <input type="password" name="pass3" placeholder ="パスワード"><br><br>
        </form> 
    </body>
</html>
    <?php
    if(!empty($_POST["submit"])){
            if(!empty($name)){
                if(!empty($comment)){
                    if(!empty($_POST["pass"])){
                    
                    }
                    else{
                        echo "パスワードを入力してください<br><br>";
                    }
                }
                else{
                    echo "コメントを入力してください<br><br>";
                }
            }
            else{
                 echo"名前を入力してください<br><br>";
            }
        }
        
    ///■■■削除フォームの条件分岐  
    if(!empty($_POST["submit2"])){
            if(!empty($_POST["del"])){
                if(!empty($_POST["pass2"])){
                    $pass2=$_POST["pass2"];
                    if($pass2!= $row['password']){
                        echo "パスワードが違います<br><br>";
                    }
                }
                else{
                    echo "パスワードを入力してください<br><br>";
                }
            }
            else{
                echo "削除番号を入力してください<br><br>";
            }    
    }
    ///■■■編集フォームの条件分岐  
    if(!empty($_POST["submit3"])){
             if(!empty($_POST["edi"])){
                if(!empty($_POST["pass3"])){
                    $pass3=$_POST["pass3"];
                    //$rowでいける理由は、上での条件分岐が外れてこっちにきたから
                    if($pass3!= $row['password']){
                        echo "パスワードが違います<br><br>";
                    }
                } 
                else{
                    echo "パスワードを入力してください<br><br>";
                }
             }
             else{
                 echo "編集番号を入力してください<br><br>";
             }
        }
    
   //テーブル内のデータを表示させている
    $sql = 'SELECT * FROM day5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
		echo $row['dt'].'<br>';
	echo "<hr>";
	}
	
	?>
	
