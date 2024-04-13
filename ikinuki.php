<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>きょうのわんこ</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            font-size: 17px;
        }

        h1 {
            margin-top: 50px;
        }

        .dog-image {
            margin-top: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-header{
            margin-top: 15px;
        }
        
    </style>
</head>



<body>
    <!-- Head[Start] -->
    <?php include("menu.php"); ?>
    <!-- Head[End] -->

    <h1>きょうのわんこ</h1>
    <h2>おしごとがんばってね</h2>

    <?php
    // Dog APIのURL
    $api_url = 'https://dog.ceo/api/breeds/image/random';

    // cURLを初期化
    $curl = curl_init();

    // cURLオプションを設定
    curl_setopt($curl, CURLOPT_URL, $api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    // APIからデータを取得
    $response = curl_exec($curl);

    // エラーチェック
    if ($response === false) {
        echo 'Error occurred: ' . curl_error($curl);
    } else {
        // JSONデータを連想配列に変換
        $data = json_decode($response, true);

        // 画像を表示
        if ($data && isset($data['message'])) {
            echo '<img src="' . $data['message'] . '" class="dog-image" alt="Random Dog Image">';
        } else {
            echo 'Failed to fetch dog image data.';
        }
    }

    // cURLセッションを終了
    curl_close($curl);
    ?>
</body>

</html>