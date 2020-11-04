# LibreSpeed(カスタマイズ版)
## 概要
本ソースコードは、LibreSpeedのカスタマイズ版です。

* [Original code](https://github.com/librespeed/speedtest)


## 変更点
本カスタマイズ版は、既存サイトとLibreSpeedの統合を容易にするための変更が
行われています。具体的には次の変更が加えられています。

* オリジナルのexample-singleServer-full.htmlからHTMLとJavaScript/CSSを分離
* ボタンやグラフなどのパーツをHTMLタグで表現できるように変更
* speedtest.jsからのspeedtest_worker.jsの呼び出しパスを変更

## 利用方法
### 配置方法
既存のコンテンツとカスタマイズ版LibreSpeedを、次のようなディレクトリ構成に
なるように配置します。


```
site/
|-- index.html    -- 速度測定の機能を実装するHTML
|-- others        -- サイトに必要なcss等
`-- speedtest     -- 本ソースコード
```

### DBの準備
DBの設定はオリジナルのLibreSpeedと同じです。


### LibreSpeedコンポーネント用のHTMLタグについて
本カスタマイズでは、HTMLタグによりボタンやグラフを動的に表示するようになっています。
次がHTMLの例です。

```
<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript" src="speedtest.js"></script>
  <script type="text/javascript" src="dg_speedtest.js"></script>
  <link rel="stylesheet" href="dg_speedtest.css">
</head>
<body>
  <div id="librespeed_btn"></div>
  <div id="librespeed_rander_ping" data-type="ping" data-title="Ping速度" data-unit="ms"></div>
  <div id="librespeed_rander_jitter" data-type="jitter" data-title="Jitter(速度の揺らぎ幅)" data-unit="ms"></div>
  <div id="librespeed_rander_dl" data-type="dl" data-title="ダウンロード" data-unit="Mbps"></div>
  <div id="librespeed_rander_ul" data-type="ul" data-title="アップロード" data-unit="Mbps"></div>
  <div id="librespeed_resultid"></div>
  <div id="librespeed_resulturl"></div>
</body>
</html>
```

本カスタマイズを利用するために、まず必要なのはつぎのJavaScript/CSSの読み込みです。

```
  <script type="text/javascript" src="speedtest.js"></script>
  <script type="text/javascript" src="dg_speedtest.js"></script>
  <link rel="stylesheet" href="dg_speedtest.css">
```

次にLibreSpeedコンポーネント用のHTMLタグを配置します。
それぞれタグにidが割り当てられています。id別の解説は次の通りです。

* librespeed_btn : Start/Stopボタンの表示領域
* librespeed_rander_ping Ping結果の表示領域
* librespeed_rander_jitter: Jitter結果の表示領域
* librespeed_rander_dl: ダウンロード結果の表示領域
* librespeed_rander_ul: アップロード結果の表示領域
* librespeed_resultid: 結果IDの表示領域
* librespeed_resulturl: 結果共有URLのの表示領域

またdata-titleで結果のタイトルの指定や、data-unitで単位を指定できるようになっています。


# オリジナルのLibreSpeedのReadme(翻訳)
Flash、Java、Websocket、Bullshitの技術は使われていません。
LibreSpeedは、XMLHttpRequestとWeb Workersを使用して、Javascriptで実装された非常に軽量な速度測定ソフトウェアです。

## 試用
[速度測定を実施する](https://librespeed.org)

## ブラウザ互換性
最新のすべてのブラウザーがサポートされています。

* IE11
* 最新のEdge
* 最新のChrome
* 最新のFirefox
* 最新のSafari

モバイル版でも動作します。

## 特徴
* ダウンロード速度測定
* アップロード速度測定
* Ping速度測定
* Jitter測定
* IPアドレス。ISPサーバからの距離(オプション)
* テレメトリ(オプション)
* 測定結果の共有
* 複数の測定ポイントの利用(オプション)

![Screenshot](https://speedtest.fdossena.com/mpot_v6.gif)


## サーバ要件
* Apache2を備えた適度に高速なWebサーバー(nginx,IISもサポート)
* PHP 5.4以上(他のバックエンドも利用可能)
* テスト結果を保存するMySQLデータベース（オプション, PostgreSQLおよびSQLiteもサポート）
* 高速なインターネット接続

## インストレーションビデオ
* [Ubuntu Server 19.04のクイックインストールガイド](https://fdossena.com/?p=speedtest/quickstart_v5_ubuntu.frag)

## アンドロイドアプリ
LibreSpeedインストール用のAndroidクライアントを構築するためのテンプレートは[こちら](https://github.com/librespeed/speedtest-android)から入手できます。

## Docker
Dockerブランチをご覧ください。

## Goバックエンド
Go実装が [`speedtest-go`](https://github.com/librespeed/speedtest-go) リポジトリから利用できます。
このリポジトリは [Maddie Zhan](https://github.com/maddie)によってメンテナンスされています。

## Node.jsバックエンド
部分的なNode.js実装は [dunklesToast](https://github.com/dunklesToast) によって開発されたブランチで利用できます。
現時点では使用をお勧めしません。

## 寄付
[![Donate with Liberapay](https://liberapay.com/assets/widgets/donate.svg)](https://liberapay.com/fdossena/donate)  
[PayPalで寄付する](https://www.paypal.me/sineisochronic)  

## License
Copyright (C) 2016-2020 Federico Dossena

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/lgpl>.
