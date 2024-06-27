<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取用户提交的留言内容
    $message_content = $_POST["message"];
    
    // 读取现有的留言数据
    $messages = file_get_contents('messages.json');
    $messages = json_decode($messages, true) ?? [];
    
    // 创建新留言
    $new_message = [
        'content' => $message_content,
        'is_top' => false // 新留言默认不置顶
    ];
    
    // 将新留言添加到留言数组
    $messages[] = $new_message;
    
    // 将更新后的留言数组保存回 messages.json 文件
    file_put_contents('messages.json', json_encode($messages));
    
    // 重定向回留言板页面
    header("Location: index.html");
}
?>