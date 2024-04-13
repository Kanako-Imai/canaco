<style>
    .navbar-default {
        background-color: #3949AB;
        border-color:    #3949AB;;
    }

    .navbar-default .navbar-header li {
        display: inline-block;
        margin-right: 10px; /* リンク間の余白を追加 */
    }

    .navbar-default .navbar-header li:last-child {
        margin-right: 0; /* 最後のリンクの余白を削除 */
    }

    .navbar-default .navbar-header li a {
        color: #fff; /* リンクの色を白に設定 */
        text-decoration: none; /* 下線を削除 */
        padding: 10px 15px; /* リンクの余白を設定 */
    }

    .navbar-default .navbar-header li a:hover {
        background-color: rgba(255, 255, 255, 0.1); /* ホバー時の背景色を設定 */
        border-radius: 5px; /* 角丸を追加 */
    }

    .navbar-default .navbar-header li::after {
        content: ">";
        margin: 0 .6em; /* 記号の左右の余白 */
        color: #777; /* 記号の色 */
    }
</style>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <li><a href="select.php">案件一覧</a></li>
            <li><a href="index.php">案件登録</a></li>
            <li><a href="link_select.php">リンク一覧</a></li>
            <li><a href="link.php">リンク登録</a></li>
            <li><a href="ikinuki.php">IKINUKI</a></li>
            <li><a href="user.php">ユーザー登録</a></li>
            <li><a href="user_select.php">ユーザー一覧</a></li>
            <a href="logout.php">ログアウト</a>
        </div>
    </div>
</nav>
