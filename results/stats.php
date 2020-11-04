<?php
session_start();
error_reporting(0);

require 'telemetry_settings.php';
require_once 'telemetry_db.php';

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, s-maxage=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>LibreSpeed - Stats</title>
        <style type="text/css">
            html,body{
                margin:0;
                padding:0;
                border:none;
                width:100%; min-height:100%;
            }
            html{
                background-color: hsl(198,72%,35%);
                font-family: "Segoe UI","Roboto",sans-serif;
            }
            body{
                background-color:#FFFFFF;
                box-sizing:border-box;
                width:100%;
                max-width:70em;
                margin:4em auto;
                box-shadow:0 1em 6em #00000080;
                padding:1em 1em 4em 1em;
                border-radius:0.4em;
            }
            h1,h2,h3,h4,h5,h6{
                font-weight:300;
                margin-bottom: 0.1em;
            }
            h1{
                text-align:center;
            }
            table{
                margin:2em 0;
                width:100%;
            }
            table, tr, th, td {
                border: 1px solid #AAAAAA;
            }
            th {
                width: 6em;
            }
            td {
                word-break: break-all;
            }
            div {
                margin: 1em 0;
            }
        </style>
    </head>
    <body>
        <h1>LibreSpeed統計情報</h1>
        <?php
        if (!isset($stats_password) || $stats_password === 'PASSWORD') {
            ?>
                telemetry_setting.phpに$stats_passwordを設定してください。
            <?php
        } elseif ($_SESSION['logged'] === true) {
            if ($_GET['op'] === 'logout') {
                $_SESSION['logged'] = false;
                ?><script type="text/javascript">window.location=location.protocol+"//"+location.host+location.pathname;</script><?php
            } else {
                ?>
                <form action="stats.php" method="GET"><input type="hidden" name="op" value="logout" /><input type="submit" value="ログアウト" /></form>
                <form action="stats.php" method="GET">
                    <h3>計測結果の検索</h3>
                    <input type="hidden" name="op" value="id" />
                    <input type="text" name="id" id="id" placeholder="計測ID" value=""/>
                    <input type="submit" value="検索" />
                    <input type="submit" onclick="document.getElementById('id').value=''" value="最近の計測結果100件を表示" />
                </form>
                <?php
                if ($_GET['op'] === 'id' && !empty($_GET['id'])) {
                    $speedtest = getSpeedtestUserById($_GET['id']);
                    $speedtests = [];
                    if (false === $speedtest) {
                        echo '<div>計測結果を取得しようとしてエラーが発生しました:"'.$_GET['id'].'".</div>';
                    } elseif (null === $speedtest) {
                        echo '<div>検索したIDが見つかりません:"'.$_GET['id'].'".</div>';
                    } else {
                        $speedtests = [$speedtest];
                    }
                } else {
                    $speedtests = getLatestSpeedtestUsers();
                    if (false === $speedtests) {
                        echo '<div>最新のスピードテスト結果を取得しようとしてエラーが発生しました。</div>';
                    } elseif (empty($speedtests)) {
                        echo '<div>計測結果が存在しません。</div>';
                    }
                }
                foreach ($speedtests as $speedtest) {
                    ?>
                    <table>
                        <tr>
                            <th>計測ID</th>
                            <td><?= htmlspecialchars($speedtest['id_formatted'], ENT_HTML5, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>日時</th>
                            <td><?= htmlspecialchars($speedtest['timestamp'], ENT_HTML5, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>IPアドレス/ISP情報</th>
                            <td>
                                <?= htmlspecialchars($speedtest['ip'], ENT_HTML5, 'UTF-8') ?><br/>
                                <?= htmlspecialchars($speedtest['ispinfo'], ENT_HTML5, 'UTF-8') ?>
                            </td>
                        </tr>
                        <tr>
                            <th>ユーザエージェント/言語</th>
                            <td><?= htmlspecialchars($speedtest['ua'], ENT_HTML5, 'UTF-8') ?><br/>
                                <?= htmlspecialchars($speedtest['lang'], ENT_HTML5, 'UTF-8') ?>
                            </td>
                        </tr>
                        <tr>
                            <th>ダウンロード速度</th>
                            <td><?= htmlspecialchars($speedtest['dl'], ENT_HTML5, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>アップロード速度</th>
                            <td><?= htmlspecialchars($speedtest['ul'], ENT_HTML5, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>Ping速度</th>
                            <td><?= htmlspecialchars($speedtest['ping'], ENT_HTML5, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>ジッター</th>
                            <td><?= htmlspecialchars($speedtest['jitter'], ENT_HTML5, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>ログ</th>
                            <td><?= htmlspecialchars($speedtest['log'], ENT_HTML5, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>追加情報</th>
                            <td><?= htmlspecialchars($speedtest['extra'], ENT_HTML5, 'UTF-8') ?></td>
                        </tr>
                    </table>
                    <?php
                }
            }
        } elseif ($_GET['op'] === 'login' && $_POST['password'] === $stats_password) {
            $_SESSION['logged'] = true;
            ?><script type="text/javascript">window.location=location.protocol+"//"+location.host+location.pathname;</script><?php
        } else {
            ?>
            <form action="stats.php?op=login" method="POST">
                <h3>Login</h3>
                <input type="password" name="password" placeholder="パスワード" value=""/>
                <input type="submit" value="ログイン" />
            </form>
            <?php
        }
        ?>
    </body>
</html>
