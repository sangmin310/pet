<?php
    require_once("db_connect.php");
    session_start();

    switch($_GET['mode']){
        case 'write':
            if(!$_SESSION['username']){
                errMsg("로그인 해주세요");
            }

            $id = $_POST['id'];
            $username = $_POST['username'];
            $dog_name = $_POST['dog_name'];
            $title = $_POST['title'];
            $story = $_POST['story'];
            $rating = getStarCount($_POST['rating']); // 별점 갯수에 따른 평점 구하기


             if($_FILES['image']['name']){
               $imageFullName = strtolower($_FILES['image']['name']);
               $imageNameSlice = explode(".",$imageFullName);
               $imageName = $imageNameSlice[0];
               $imageType = $imageNameSlice[1];
               $image_ext = array('jpg','jpeg','gif','png');
               if(array_search($imageType,$image_ext) === false){
                   errMsg('jpg, jpeg, gif, png 확장자만 가능합니다.');
               }
               $dates = date("mdhis",time());
               $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
               $dir = "image/";
               move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
               chmod($dir.$newImage,0777);
            }

            $sql = $db -> prepare("INSERT INTO review
            (id, username, dog_name, title, story, redate, image, rating)
            VALUE
            (:id, :username, :dog_name, :title, :story, now(),:image, :rating)");

            $sql -> bindParam("id", $id);
            $sql -> bindParam("username",$username);
            $sql -> bindParam("dog_name",$dog_name);
            $sql -> bindParam("title",$title);
            $sql -> bindParam("story",$story);
            $sql -> bindParam("image",$newImage);
            $sql -> bindParam("rating",$rating);

            $sql -> execute();
            header("location:review1.php");
            break;

            case 'update':
                $no = $_POST['no'];
                $newTitle = $_POST['title'];
                $newStory = $_POST['story'];
                $newRating = getStarCount($_POST['rating']); // 수정된 별점 받아오기
            
                $sql = $db->prepare("UPDATE review SET title=:title, story=:story, rating=:rating WHERE no=:no "); // 별점 업데이트 쿼리에 추가
                $sql->bindParam("title", $newTitle);
                $sql->bindParam("story", $newStory);
                $sql->bindParam("rating", $newRating); // 별점 바인딩 추가
                $sql->bindParam("no", $no);
                $sql->execute();
                header("location:review1.php");
                break;
            

            case 'delete':
            $no = $_GET['no'];

            $sql = $db -> prepare("DELETE FROM review WHERE no=:no");
            $sql -> bindParam("no",$no);
            $sql -> execute();

            header("location:review1.php");
            break;
            }

            // 별점 갯수에 따른 평점을 계산하는 함수
            function getStarCount($rating) {
                switch ($rating) {
                    case '5':
                        return 5;
                    case '4':
                        return 4;
                    case '3':
                        return 3;
                    case '2':
                        return 2;
                    case '1':
                        return 1;
                    default:
                        return 0;
                }
    }
?>