<?php

class NewsManager
{
    private static ?self $instance = null;

    private function __construct()
    {
        require_once(ROOT . '/utils/DB.php');
        require_once(ROOT . '/utils/CommentManager.php');
        require_once(ROOT . '/class/News.php');
    }

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

	/**
	 * Lists all news items.
	 *
	 * @return News[] An array of News objects representing the news items.
	 */
	public function listNews(): array
	{
		// Get the database instance
		$db = DB::getInstance();
		
		// Fetch all news items from the database
		$rows = $db->select('SELECT * FROM `news`');

		// Map each row to a News object
		return array_map(function($row) {
			return (new News())
				->setId($row['id'])
				->setTitle($row['title'])
				->setBody($row['body'])
				->setCreatedAt($row['created_at']);
		}, $rows);
	}

    /**
     * Adds a new news item.
     *
     * @param string $title
     * @param string $body
     * @return int
     */
    public function addNews(string $title, string $body): int
    {
        $db = DB::getInstance();
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES (:title, :body, :created_at)";
        $params = [
            ':title' => $title,
            ':body' => $body,
            ':created_at' => date('Y-m-d')
        ];
        $db->exec($sql, $params);
        return $db->lastInsertId();
    }

	/**
	 * Deletes a news item and its associated comments.
	 *
	 * @param int $id The ID of the news item to delete.
	 * @return bool True if deletion is successful, false otherwise.
	 */
	public function deleteNews(int $id): bool
	{
		// Get the CommentManager instance
		$commentManager = CommentManager::getInstance();

		// Delete associated comments
		$commentsDeleted = $commentManager->deleteCommentsForNews($id);

		if (!$commentsDeleted) {
			// If deleting associated comments failed, return false
			return false;
		}

		// Delete the news item itself
		$db = DB::getInstance();
		$sql = "DELETE FROM `news` WHERE `id` = :id";
		$params = [':id' => $id];

		// Execute the deletion query
		$newsDeleted = $db->exec($sql, $params) > 0;

		// Return true if both news item and associated comments are successfully deleted, otherwise false
		return $newsDeleted;
	}
}
?>
