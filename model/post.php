<?php

namespace NS_Blog;

require_once 'db.php';
require_once 'user.php';

class UserNotFound extends \Exception {
}

class InsufficientPermissions extends \Exception {
}

class Post extends DB {
    public function __construct() {
        parent::__construct();
        $this->table = 'post';
    }

    public static function createPost(string $title, string $content, int $userId) {
        try {
            $user = User::getById($userId);
        } catch (NotFoundInDB $e) {
            throw new UserNotFound('Je refuse de créer un article pour un utilisateur inconnu (oui, je suis un lache).');

        }

        if ($user->authorisations < 3) {
            throw new InsufficientPermissions();
        }

        $post = new self();
        $post->insert($title, $content, $userId);
    }

    public static function getPosts(int $max=0, bool $hidden=false): array {
        $posts = new self();
        $posts = $posts->fetchPosts($max);

        if ($hidden) {
            return $posts;
        }

        $filtered = [];
        foreach ($posts as $p) {
            if (!$p->hide) {
                $filtered[] = $p;
            }
        }

        return $filtered;
    }

    protected function fetchPosts(int $max): array {
        if ($max) {
            $limit = "LIMIT {$max}";
        } else {
            $limit = '';
        }

        $request = $this->db->prepare(
            "SELECT 
                post.id,
                title,
                content,
                creationDate,
                hide,
                user.pseudo as author
             FROM {$this->table}
             INNER JOIN user on user.id = post.idUser
             ORDER BY id DESC {$limit}"
        );

        $request->execute();

        return $request->fetchAll(\PDO::FETCH_CLASS);
    }

    private function insert(string $title, string $content, int $userId) {
        $request = $this->db->prepare(
            "INSERT INTO {$this->table} (title, content, idUser)
             VALUES (:title, :content, :userId)"
        );

        $request->execute([
            ':title' => $title,
            ':content' => $content,
            ':userId' => $userId
        ]);
    }
}
