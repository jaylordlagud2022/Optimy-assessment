<?php

define('ROOT', __DIR__);
require_once(ROOT . '/utils/NewsManager.php');
require_once(ROOT . '/utils/CommentManager.php');

// List all news items and their associated comments
foreach (NewsManager::getInstance()->listNews() as $news) {
    echo("############ NEWS " . $news->getTitle() . " ############\n");
    echo($news->getBody() . "\n");
    foreach (CommentManager::getInstance()->listComments() as $comment) {
        if ($comment->getNewsId() == $news->getId()) {
            echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
        }
    }
}

// // Test deletion of a news item
// $newsIdToDelete = 1; // Specify the news ID to delete (change this to a valid news ID)
// $success = NewsManager::getInstance()->deleteNews($newsIdToDelete);
// if ($success) {
//     echo "News item with ID $newsIdToDelete deleted successfully.\n";
// } else {
//     echo "Failed to delete news item with ID $newsIdToDelete.\n";
// }



// // Test add comments of a news item
// $newsIdToaddComment = 2; // Specify the news ID to delete (change this to a valid news ID)
// $success = CommentManager::getInstance()->addCommentForNews('hello this is test', $newsIdToaddComment);
// if ($success) {
//     echo "News item with ID $newsIdToaddComment added comment successfully.\n";
// }