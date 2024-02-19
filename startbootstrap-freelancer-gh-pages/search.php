<?php
// データベースへ接続
    $dsn = "mysql:dbname=★;host=★;charset=utf8";
    $username = "★";
    $password = "★";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // エラーモードを例外モードに設定
        PDO::ATTR_EMULATE_PREPARES => false, // プリペアドステートメントのエミュレートを無効にする
                ];

try {
$pdo = new PDO($dsn, $username, $password, $options);

    // フォームから送信されたデータを取得
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search_query = $_POST["search"];
    
        // 検索クエリを使ってデータベースから結果を取得
        $sql = "SELECT * FROM common WHERE function LIKE ? OR shortcut LIKE ?";
        $result = $pdo->prepare($sql);
        $result->execute(['%' . $search_query . '%', '%' . $search_query . '%']);
        $data = $result->fetchAll();
    
        // 検索結果をHTML形式で返す
        if (count($data) > 0) {
            echo "<table border='1'>";
            echo "<thead><tr><th>Function</th><th>Shortcut</th></tr></thead>";
            echo "<tbody>";
    
            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["function"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["shortcut"]) . "</td>";
                echo "</tr>";
            }
    
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "該当する結果はありませんでした。";
        }
    // }
} catch (PDOException $e) {
echo "エラー：" . $e->getMessage();
}
?>