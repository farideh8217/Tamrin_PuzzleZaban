<?php
require "core.php";

if (isset($_POST["submit"], $_POST["question_id"], $_POST["order"]) && is_array($_POST["order"])) {
    $question_id = $_POST["question_id"];
    $orders = $_POST["order"];
    foreach ($orders as $word_id => $order) {
        $wordorder = get_wordorder($word_id);
        $status = true;
        if ($wordorder === null) {
            $status = false;
            break;
        }
        $order = (int)($order);
        if ($wordorder !== $order) {
            $status = false;
            break;
        }
    }
    if ($status === true) {
        echo "correct";
    } else {
        echo "incorrect" . '<br>';
        $correct_order_words = get_correct_order_words($question_id);
        $correct_order_words = array_column($correct_order_words, "text", "id");
        print_r(implode("  ", $correct_order_words));
    }
    echo '<a href="">next question</a>';
    exit();
}
$question_id = get_question();
if ($question_id === null) {
    echo "سوالی وجود ندارد";
    exit();
}

$wordofquestions = get_wordofquestion($question_id);
?>
<form action="" method="post">
    <input type="hidden" name="question_id" value="<?= $question_id ?>">
    <?php foreach ($wordofquestions as $wordofquestion_item) { ?>
        <h2 namm="namequestion"><?= $wordofquestion_item["text"] ?></h2>
        <input type="number" min="1" name="order[<?= $wordofquestion_item["id"] ?>]">
    <?php } ?>
    <input type="submit" name="submit">
</form>
