<?php
    require_once("db_connect.php");
    session_start();

    $sql = $db->prepare("SELECT * FROM review ORDER BY no DESC");
    $sql->execute();

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

  <style>
    .reviewTitle{
      height: 35px;
      text-align: left;
      font-size: 30px;
      margin-left: 0px;
      border-bottom: none; /* 밑줄 없애기 */
    }
    
    .reviewTable {
      width: 100%;
      border-collapse: collapse;
    }

    .reviewTable th,
    .reviewTable td {
      border: 1px solid #dddddd;
      text-align: center;
      padding: 8px;
    }

    .reviewTable th {
      background-color: #f2f2f2;
    }

    .reviewTd2 a {
      display: inline-block;
      text-align: center;
      width: 100%;
    }

    .writeReview{
      width: 60%;
      margin: auto;
      margin-top: 30px;
      font-size: 20px;
      margin-right: 0px;
    }

  </style>
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
              <div class="ml-auto"> <!-- ml-auto 클래스를 사용하여 오른쪽 정렬 -->
              <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <!-- 로그인한 사용자에게 보이는 내용 -->
                <span class="navbar-text">
                  <?php 
                  // 강아지 이름이 설정되어 있을 경우 환영 메시지에 포함
                  if(isset($_SESSION['dog_name'])) {
                      echo htmlspecialchars($_SESSION['dog_name']) . "님 환영합니다.";
                  } else {
                      // 강아지 이름이 설정되지 않았을 경우 기본 메시지
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
            <div class="reviewTitle">리뷰 목록</div>
            <table class="reviewTable">
                <thead>
                    <tr>
                        <td class="reviewTd1">no</td>
                        <td class="reviewTd2">제목</td>
                        <td class="reviewTd3">글쓴이</td>
                        <td class="reviewTd4">작성시간</td>
                        <td class="reviewTd5">별점</td>
                    </tr>
                </thead>
                <?php
                    while ($review = $sql->fetch()){
                        $time = DateTime::createFromFormat('Y-m-d H:i:s', $review['redate']);
                        $time = date_format($time, 'Y-m-d');
                ?>
                    <tbody>
                    <tr>
                        <td class="reviewTd1"><?= $review['no']?></td>
                        <td class="reviewTd2"><a href="viewReview1.php?no=<?=$review['no']?>"><?= $review['title']?></a></td>
                        <td class="reviewTd3"><?= $review['dog_name']?></td>
                        <td class="reviewTd4"><?= $time?></td>
                        <td class="reviewTd5">
                        <?php
                            // 별점 표시
                            if ($review['rating']) {
                                // 리뷰에 별점이 있는 경우
                                for ($i = 0; $i < $review['rating']; $i++) {
                                    echo '★';
                                }
                            } else {
                                // 리뷰에 별점이 없는 경우
                                echo '평가 없음';
                            }
                        ?>
                      </td>
                    </tr>
                    </tbody>
                <?php } ?>
                    <tfoot>
                    <tr>
                            <td class="reviewTd1"></td>
                            <td class="reviewTd2"></td>
                            <td class="reviewTd3"></td>
                            <td class="reviewTd4"></td>
                            <td class="reviewTd5"></td>
                        </tr>
                    </tfoot>
            </table>
            <div class="writeReview"><a href="writeReview1.php">글쓰기</a></div>
        </div>
    </section>
    <footer></footer>
</body>
</html>
