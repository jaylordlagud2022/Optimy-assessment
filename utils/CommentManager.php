<?php

class CommentManager
{
    private static ?self $instance = null;

    // Private constructor to prevent direct object creation
    private function __construct()
    {
        require_once(ROOT . '/utils/DB.php');
        require_once(ROOT . '/class/Comment.php');
    }

    /**
     * Singleton pattern implementation to get the single instance of the class.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Fetches all comments from the database.
     *
     * @return Comment[]
     */
    public function listComments(): array
    {
        $db = DB::getInstance();
        $rows = $db->select('SELECT * FROM `comment`');

        return array_map(function($row) {
            return (new Comment())
                ->setId($row['id'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at'])
                ->setNewsId($row['news_id']);
        }, $rows);
    }

    /**
     * Adds a new comment for a specific news item.
     *
     * @param string $body
     * @param int $newsId
     * @return int
     */
    public function addCommentForNews(string $body, int $newsId): int
    {
        $db = DB::getInstance();
        $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES (:body, :created_at, :news_id)";
        $params = [
            ':body' => htmlspecialchars($body, ENT_QUOTES, 'UTF-8'),
            ':created_at' => date('Y-m-d'),
            ':news_id' => $newsId
        ];
        $db->exec($sql, $params);
        return $db->lastInsertId();
    }

    /**
     * Deletes a comment based on the provided ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteComment(int $id): bool
    {
        $db = DB::getInstance();
        $sql = "DELETE FROM `comment` WHERE `id` = :id";
        $params = [':id' => $id];
        return $db->exec($sql, $params) > 0;
    }

	/**
	 * Deletes all comments associated with a specific news item.
	 *
	 * @param int $newsId The ID of the news item.
	 * @return bool True if deletion is successful, false otherwise.
	 */
	public function deleteCommentsForNews(int $newsId): bool
	{
		// Get the database instance
		$db = DB::getInstance();

		// Prepare the SQL statement to delete comments for the news item
		$sql = "DELETE FROM `comment` WHERE `news_id` = :news_id";
		$params = [':news_id' => $newsId];

		// Execute the deletion query
		$deleted = $db->exec($sql, $params) > 0;

		// Return true if deletion is successful, otherwise false
		return $deleted;
	}
}
?>
