<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的留言板</title>
    <meta name="description" content="这是一个供用户留言的页面">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #8ecae6;
            color: white;
            text-align: center;
            padding: 1em 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 2em auto;
            background-color: white;
            padding: 2em;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-top: 0;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 1em;
            padding: 0.5em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #219ebc;
            color: white;
            border: none;
            padding: 0.75em;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0a9396;
        }
        .message {
            border-bottom: 1px solid #ccc;
            padding: 1em 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .message.top {
            background-color: #ffe4c4;
            border: 2px solid #ffa07a;
        }
        .toggle-top {
            background: none;
            border: none;
            color: #219ebc;
            cursor: pointer;
            padding: 0.5em;
        }
        .toggle-top:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>欢迎来到我的留言板</h1>
    </header>
    <div class="container">
        <form action="submit.php" method="post">
            <label for="message">留言内容：</label>
            <textarea name="message" id="message" required></textarea>
            <button type="submit">提交</button>
        </form>
        <div id="messages">
            <?php
            // 读取并显示留言
            $messages = file_get_contents('messages.json');
            $messages = json_decode($messages, true);
            usort($messages, function($a, $b) {
                return ($b['is_top'] ?? false) - ($a['is_top'] ?? false);
            });
            foreach ($messages as $index => $message) {
                $is_top = $message['is_top'] ?? false;
                $class = $is_top ? 'message top' : 'message';
                echo "<div class=\"$class\">" . htmlspecialchars($message['content']) . "
                    <form action='toggle_top.php' method='post' style='display:inline;'>
                        <input type='hidden' name='message_index' value='$index'>
                        <button type='submit' class='toggle-top'>" . ($is_top ? '取消置顶' : '置顶') . "</button>
                    </form>
                </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>