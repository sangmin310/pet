<?php
    require_once("db_connect.php");
    session_start();

    $no = $_GET['no'];
    $sql = $db->prepare("SELECT * FROM review WHERE no=:no");
    $sql->bindParam("no", $no);
    $sql->execute();
    $review = $sql->fetch();

    $time = DateTime::createFromFormat('Y-m-d H:i:s', $review['redate']);
    $time = date_format($time, 'Y-m-d');
?>
<!DOCTYPE html>
<html>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Petology</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Dosis:400,500|Poppins:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

  <script>
    function confirmDel(text) {
        const selValue = confirm(text);
        if(selValue == true){
            location.href="board_process1.php?mode=delete&no=<?= $review['no']?>";
        } else if(selValue == false){
            history.back(1);
        }
    }
  </script>

</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="">
            <span>
              WITH PET
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cafe-region.php">CAFE </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="hospital-region.php">HOSPITAL</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="restaurant-region.php">SHOP</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="salon-region.php">SERVICE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="culture-region.php">CULTURE</a>
                </li>
              </ul>
              <div class="ml-auto">
                <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <span class="navbar-text">
                  <?php 
                  if(isset($_SESSION['dog_name'])) {
                      echo htmlspecialchars($_SESSION['dog_name']) . "님 환영합니다.";
                  } else {
                      echo "환영합니다.";
                  }
                  ?>
                </span>
                <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0 ml-2" type="button">로그아웃</a>
                <a href="user_info_edit.php" class="btn btn-outline-secondary btn-custom my-2 my-sm-0 ml-2">회원정보수정</a>
                <?php else: ?>
                <a href="login.html" class="btn btn-outline-success my-2 my-sm-0" type="button">로그인</a>
                <?php endif; ?>
              </div>
              <form class="form-inline my-2 my-lg-0 ml-0 ml-lg-4 mb-3 mb-lg-0">
                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
              </form>
            </div>
            <div class="quote_btn-container  d-flex justify-content-center">
            </div>
          </div>
        </nav>
      </div>
    </header>
    <section>
        <div class="mainCon">
            <div class="viewTitle"><?= $review['title'] ?></div>
            <div class="viewInfo">
                <div class="viewName"><?= $review['dog_name']?></div>
                <div class="viewTime"><?= $time?></div>
                <div class="viewRating">별점: 
                  <?php 
                    $starRating = intval($review['rating']);
                    for($i = 0; $i < $starRating; $i++) {
                      echo "★";
                    }
                  ?>
                </div>
            </div>
            <div class="viewStory">
                <?= $review['story']?>
                <?php 
                    if(!$review['image']){
                    } else{
                        echo "<br><img src='image/$review[image]'></img>";
                    }
                ?>
            </div>
            <div class="viewBtn">
                <div><a href="review1.php">목록으로</a></div>
                <?php if($review['username'] != $_SESSION['username']): ?>
                <?php else: ?>
                <div>
                  <a href="reviewUpdate1.php?no=<?= $review['no']?>">수정</a>
                  <a href="#" onclick="confirmDel('정말로 삭제하시겠습니까?')">삭제</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <footer></footer>
</body>
</html>
