<?php
session_start();

$database = [
    'host'=>'localhost',
    'dbname'=>'puzzle_english',
    'user'=>'root',
    'pass'=>''
];
try {
    $db = new PDO("mysql:host={$database['host']};dbname={$database['dbname']}", $database['user'], $database['pass']);
} catch (PDOException $e) {
    exit("An error happend, Error: " . $e->getMessage());
}

function get_question(): ?int
{
    global $db;

    $sql = "SELECT `id` FROM `question` ORDER BY RAND()";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $question = $stmt->fetchColumn();
    if($question === false) return null;
    else return $question;
}

function get_wordofquestion($question_id): array
{
    global  $db;

    $sql = "SELECT * FROM `word` WHERE question_id = :question_id ORDER BY RAND()";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":question_id",$question_id);
    $stmt->execute();

    $word = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $word;
}

function get_wordorder($word_id): ?int
{
    global $db;

    $sql = "SELECT `order` FROM `word` WHERE id = :word_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":word_id",$word_id);
    $stmt->execute();

    $order = $stmt->fetchColumn();
    if($order === false) return null;
    else return $order;
}
function get_correct_order_words($question_id): ?array
{
    global $db;

    $sql = "SELECT * FROM `word` WHERE `question_id` = :question_id ORDER BY `order` ASC";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":question_id",$question_id);
    $stmt->execute();

    $correctorder = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($correctorder === false) return null;
    else return $correctorder;

}