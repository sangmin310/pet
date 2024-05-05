<?php
    require_once("db_connect.php");
    session_start();
    
    if(!$_SESSION['username']){
        errMsg('로그인 후 작성할 수 있습니다.');
    }
    
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
    .star-rating {
      display: flex;
      flex-direction: row-reverse;
      font-size: 2.25rem;
      line-height: 2.5rem;
      justify-content: space-around;
      padding: 0 0.2em;
      text-align: center;
      width: 5em;
      }
            
    .star-rating input {
      display: none;
      }
            
    .star-rating label {
      -webkit-text-fill-color: transparent; /* Will override color (regardless of order) */
      -webkit-text-stroke-width: 2.3px;
      -webkit-text-stroke-color: #2b2a29;
      cursor: pointer;
      }
            
    .star-rating :checked ~ label {
      -webkit-text-fill-color: gold;
      }
            
    .star-rating label:hover,
    .star-rating label:hover ~ label {
      -webkit-text-fill-color: #fff58c;
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
            <div class="writeTitle">리뷰 쓰기</div>
            <form class="writeForm" action="board_process1.php?mode=write" method="post" enctype= "multipart/form-data" onsubmit="return validateForm()">
                <input type="hidden" name="id" value="review">
                <input type="hidden" name="username" value="<?= $_SESSION['username'] ?>">
                <input type="hidden" name="dog_name" value="<?= $_SESSION['dog_name'] ?>">
                <p><input class="writeTypeText" type="text" name="title" size="50" style="width: 100%;" placeholder="제목을 입력해주세요" required></p>
                <div class="star-rating space-x-4 mx-auto">
                  <input type="radio" id="5-stars" name="rating" value="5"/>
                  <label for="5-stars" class="star pr-4">★</label>
                  <input type="radio" id="4-stars" name="rating" value="4"/>
                  <label for="4-stars" class="star">★</label>
                  <input type="radio" id="3-stars" name="rating" value="3"/>
                  <label for="3-stars" class="star">★</label>
                  <input type="radio" id="2-stars" name="rating" value="2"/>
                  <label for="2-stars" class="star">★</label>
                  <input type="radio" id="1-star" name="rating" value="1"/>
                  <label for="1-star" class="star">★</label>
                </div>
                <textarea class="writeTextarea" name="story" style="width: 100%;" placeholder="본문을 입력해주세요"  required></textarea>
                <input type="file" name="image">
                <div class="writeBtn">
                <input type="submit" value="작성">&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="취소" onclick="history.back(1)">
                </div>
            </form>
        </div>
    </section>
    <footer></footer>
    <script>
      function validateForm() {
        var rating = document.querySelectorAll('input[name="rating"]:checked');
        if (rating.length === 0) {
          alert("별점을 선택하세요.");
          return false;
        }
        return true;
      }
    </script>
</body>
</html>