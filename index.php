<?php
require_once "header.php";
function data_uri($contents, $mime)
{
    return ('data:' . $mime . ';base64,' . base64_encode($contents));
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMS - 宿舍管理系统</title>
    <!--- Link CSS --->
    <link rel="stylesheet" href="./css/pages/homepage.css">
    <link rel="stylesheet" href="./css/nav.css">
    <!--- 图标组件库 --->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="./js/lightDarkModeSwitcher.js"></script>
</head>

<body>
    <!-- Nav -->
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="<?php echo (is_null($usertype) || $usertype == "inactived" || is_null($userinfo["header"])) ? "img/stuff.webp" : data_uri($userinfo["header"], "image/png"); ?>" alt="头像">
                </span>
                <div class="text logo-text">
                    <span class="name"><?php echo is_null($usertype) ? "访客" : (($usertype == "inactived") ? "[未激活]" : "" . $userinfo["realname"]) ?></span>
                    <span class="profession"><?php
                                                switch ($usertype) {
                                                    case 'inactived':
                                                        echo "未激活";
                                                        break;
                                                    case 'staff':
                                                        echo "员工";
                                                        break;
                                                    case 'admin':
                                                        echo "管理员";
                                                        break;
                                                    case 'system-admin':
                                                        echo "系统管理员";
                                                        break;
                                                    default:
                                                        echo "访客";
                                                        break;
                                                }
                                                ?></span>
                </div>
            </div>

            <i class="bx bx-chevron-right toggle"></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class="bx bx-search icon"></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">

                    <li class="nav-link">
                        <a href="index.php">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">首页</span>
                        </a>
                    </li>
                    <?php if ($usertype == "admin" || $usertype == "system-admin") { ?>
                        <li class="nav-link">
                            <a href="accept.php">
                                <i class='bx bx-bar-chart-alt-2 icon'></i>
                                <span class="text nav-text">批准</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="roomlist.php">
                                <i class='bx bx-bell icon'></i>
                                <span class="text nav-text">房间列表</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (is_null($usertype)) { ?>
                        <li class="nav-link">
                            <a href="login.php">
                                <i class='bx bx-pie-chart-alt icon'></i>
                                <span class="text nav-text">登录</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="register.php">
                                <i class='bx bx-heart icon'></i>
                                <span class="text nav-text">注册</span>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">？？？</span>
                        </a>
                    </li> -->
                </ul>
            </div>
            <div class="bottom-content">
                <?php if (!is_null($usertype)) { ?>
                    <li class="nax-link">
                        <a class="text nav-text" href='logout.php'><i class="bx bx-log-out icon"></i>Logout</a>
                    </li>
                <?php } ?>
                <li class="mode">
                    <div class="sun-moon">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>
                    <span class="mode-text text">Light Mode</span>
                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>

        </div>
    </nav>
    <!-- Main -->
    <div id="main">
        <div id="title">
            <!-- Title -->
            <div                  style="width: 40%; height: 65vh; left: 30vw; top: 15vh; position: absolute; background: linear-gradient(271deg, #541FA9 0%, rgba(83.58, 31.36, 168.79, 0) 100%);; border-radius: 110px"></div>
            <div id="title-text"  style="width: 55w; left: 16vh; top: 27vh; position: absolute; color: white; font-size: 5em; font-family: Inter; font-weight: 400; word-wrap: break-word">EthRoom</div>
            <div id="title-text2" style="width: 90vw; height: 11vh; left: 17vw; top: 51vh; position: absolute; color: rgba(255, 255, 255, 0.40); font-size: 50px; font-family: Inter; font-weight: 400; letter-spacing: 25px; word-wrap: break-word">A New DMS.</div>
        </div>
        <section id="rooms">
            <span style="text-align:center;display:block;font-size:2em;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">房间</span>
            <div id="remain">
                <div style="text-align:center;margin-top:70px;">
                    剩余房间:
                    <div id="remainNum">
                        <?php
                        echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM `rooms` WHERE status='empty'"));
                        ?>
                    </div>
                </div>
            </div>
            <div id="total">
                <div style="text-align:center;margin-top:70px;">
                    房间总数:
                    <div id="totalNum">
                        <?php
                        echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM `rooms`"));
                        ?>
                    </div>
                </div>
            </div>
            <?php
            /*
            null：访客
            */
            if (!is_null($usertype) && $usertype != "failed") {
            ?>
                <button id="book" class="buttons" onclick='document.location="/roomlist.php"'>
                    预定房间/退还房间
                </button>
                <button id="manage" class="buttons" onclick='document.location="/manage.php"'>
                    管理我的账号
                </button>
                <?php
                if ($usertype != "inactived") {
                ?>
                    <button id="accept" class="buttons" onclick='document.location="/accept.php"'>
                        批准
                    </button>
                <?php
                }
                ?>


            <?php
            } else {
            ?>
                <button id="login" onclick='document.location="/login.php"' class="buttons">
                    登录
                </button>
                <button id="register" onclick='document.location="/register.php"' class="buttons">
                    注册
                </button>
            <?php
            }
            ?>
        </section>
    </div>
    <!--- Scripts Below --->
    <script>
        var remain = document.getElementById("remainNum");
        var total = document.getElementById("totalNum");
        // console.log(remain.innerText+total.innerText);
        if (remain.innerText / total.innerText >= 0.75) {
            document.getElementById("remain").style.background = "rgb(186, 255, 181)";
        } else if (remain.innerText / total.innerText >= 0.25) {
            document.getElementById("remain").style.background = "rgb(255, 222, 181)"
        } else {
            document.getElementById("remain").style.background = "rgb(255, 181, 181)"
        }
        var manage = document.getElementById("manage");
        manage.onclick = function() {
            document.location = "manage.php"
        }
    </script>
</body>
<!--- NSBA SCRIPT --->
<script src="./js/browserChecker.js"></script>
<script src="./js/nav.js"></script>
<script src="./js/lightDarkModeSwitcher.js"></script>
<script>
    var fontMatcher=()=>{    var screenDiv=window.innerWidth / 1920;
        document.getElementById("title-text").style.fontSize=(220 * screenDiv)+"px"
        document.getElementById("title-text2").style.fontSize=(50 * screenDiv)+"px"}
    setInterval(fontMatcher,100)
</script>
</html>