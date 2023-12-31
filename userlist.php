<?php
require_once "header.php";
include_once "navpage.php";
if (!($usertype == "admin" || $usertype == "system-admin")) {
    header("Location: manage.php");
} elseif (is_null($usertype)) {
    header("Location: index.php");
}

$sql = "SELECT * FROM `users`";
if (key_exists("id", $_REQUEST)) {
    $sql = "SELECT * FROM `users` WHERE id = '" . $_REQUEST["id"] . "'";
}
if (key_exists("email", $_REQUEST)) {
    $sql = "SELECT * FROM `users` WHERE mail = '" . $_REQUEST["email"] . "'";
}
if (key_exists("view", $_REQUEST)) {
    $sql = "SELECT * FROM `users` WHERE accessment = '" . $_REQUEST["view"] . "'";
}
if (key_exists("realname", $_REQUEST)) {
    $sql = "SELECT * FROM `users` WHERE realname = '" . $_REQUEST["realname"] . "'";
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/list.css">
    <title>列表</title>
</head>

<body>
    <main>
        <h1>用户列表</h1>
        <details>
            <summary>查询条件</summary>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <label>只看：
                    <select name="view">
                        <option value="system-admin">系统管理员</option>
                        <option value="admin">中级管理员</option>
                        <option value="staff">员工</option>
                    </select>
                </label>
                <input type="submit" value="查询" />
            </form>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <label>指定ID：
                    <input type="number" name="id" required />
                </label>
                <input type="submit" value="查询" />
            </form>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <label>指定邮箱：
                    <input type="email" name="email" required />
                </label>
                <input type="submit" value="查询" />
            </form>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <label>指定真名：
                    <input type="text" name="realname" maxlength="8" required />
                </label>
                <input type="submit" value="查询" />
            </form>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <input type="submit" value="查询全部" />
            </form>
        </details>
        <div class="user-list">
            <ul>
                <?php foreach (mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC) as $value) {
                    echo "<li>",
                    "<img src='" . (is_null($value["header"]) ? "img/stuff.webp" : data_uri($value["header"], "image/jpg")) . "' />",
                    "<span class='real-name'>", $value["realname"], "</span><a href='mailto:", $value["mail"], "' class='email'>", $value["mail"], "</a>",
                    "<span class='access'>", ($value["accessment"] == "staff" ? "员工" : ($value["accessment"] == "admin" ? "中级管理员" : "系统管理员")),
                    "<span class='identify'>ID:", $value["id"], " 上次登录时间：", $value["logintime"], "</span>";
                    if ($usertype == "system-admin") {
                        if ($value["accessment"] != "system-admin")
                            echo "<form action='proceed.php' method='post' class='inline'>
                    <input type='hidden' name='type' value='delete-user' />
                    <input type='hidden' name='id' value='" . $value["id"] . "' />
                    <input type='submit' value='删除用户' class='delete'/>
                    </form>";
                        if ($value["accessment"] == "admin")
                            echo "<button onclick=\"querymanage(", $value["id"], ",'", $value["realname"], "')\">更改此用户权限→</button>";
                    }
                    echo "</li>";
                }
                ?>
                <i><small>没有更多了~</small></i>
            </ul>
        </div>
        <div class="sidebar-inner">
            <?php if ($usertype == "system-admin") { ?>
                <form action="proceed.php" method="post">
                    <header>修改管理区域</header>
                    <div>选择管理人员：<span id="change-user">未选择</span></div>
                    <input type="hidden" name="type" value="change-user-manage" />
                    <input type="hidden" name="setid" />
                    <input type="hidden" name="room-data" id="room-data" />
                    <fieldset>
                        当前管理房间号分别为：
                        <ul id="manage-parts">
                            尚未选择管理人员
                        </ul>
                    </fieldset>
                    <fieldset>
                        <label>请输入想添加的房号：
                            <input type="number" id="room-number-add" disabled />
                            <span id="room-info">请键入房号以开始检查</span>
                            <button type="button" onclick="addRoom()" id="add-room" disabled>添加</button>
                        </label>
                    </fieldset>
                    <button type="button" onclick="fetchManage(document.getElementsByName('setid')[0].value);" disabled id="fetch-manage" class="reset">重置/刷新</button>
                    <input type="submit" value="Go(/≧▽≦)/" disabled id="submit">
                </form>
            <?php } else {
                echo "你没有权限修改！";
            } ?>
        </div>
    </main>
</body>
<script src="js/changeManageForUser.js"></script>

</html>