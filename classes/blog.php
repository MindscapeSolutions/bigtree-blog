<?
	class Blog extends BigTreeModule {
		var $Table = "blogs";

        public $blogId;
        public $record;

        /**
         * Constructor
         *
         * @param int $id
         */
        public function Blog($id) {
            $this->blogId = intval($id);

            $result = sqlquery("select * from blogs where id = " . $this->blogId);
            while ($f = sqlfetch($result)) {
                $this->record = $f;
                break;
            }

        }

        /**
         * Get a blog by its title
         *
         * @param string $title Urlified blog title
         *
         * @return array Blog record
         */
        public static function getByTitle($title) {
            $data = array();

            $result = sqlquery("select * from blogs order by title");

            while ($f = sqlfetch($result)) {
                if (BigTreeCMS::urlify($f["title"]) == $title) {
                    $data = $f;
                    break;
                }
            }

            if (!empty($data)) {
                $blog = new Blog($data["id"]);
                return $blog;
            }
            else {
                return false;
            }
        }

        /**
         * Get a list of the blogs
         *
         * @return array
         */
         public static function getListing() {
            $data = array();

            $blogPages = array();
            $pageResult = sqlquery("select * from bigtree_pages where template='com.mindscapesolutions.blog*blog'");
            while ($f = sqlfetch($pageResult)) {
                $resources = json_decode($f["resources"]);

                if (isset($resources->blogId) && intval($resources->blogId) > 0) {
                    $blogPages[intval($resources->blogId)] = $f["path"];
                }
            }

            $result = sqlquery("select * from blogs order by title");
            while ($f = sqlfetch($result)) {
                $b = array();
                $b["blog"] = $f;

                $author = new BlogAuthor();
                $author = $author->get($f["blog_author_id"]);
                $b["author"] = $author;

                $b["page"] = array();
                if (array_key_exists($f["id"], $blogPages)) {
                    $b["page"]["link"] = WWW_ROOT . $blogPages[$f["id"]];
                }

                $data[] = $b;
            }

            return $data;
         }

        /**
         * Get a post by its title
         *
         * @param string $title Urlified title
         * @param bool $extended Return extended data about the post
         *
         * @return array
         */
        public function getPostByTitle($title, $extended = true) {
            $post = array();

            $result = sqlquery("select * from blog_posts where blog_id = " . $this->blogId . " order by title");

            while ($f = sqlfetch($result)) {
                if (BigTreeCMS::urlify($f["title"]) == $title) {
                    $post["post"] = $f;
                    break;
                }
            }

            $categories = BlogCategory::getIndexedCategories();

            $post["categories"] = array();
            $catResult = sqlquery("select * from blog_posts_in_categories where blog_post_id = " . $post["post"]["id"]);
            while ($f = sqlfetch($catResult)) {
                $post["categories"][$f["blog_category_id"]] = $categories[$f["blog_category_id"]];
            }

            return $post;
        }

        /**
         * Get a listing of post records for the blog
         *
         * @return array of BlogPost records
         */
        public function getPosts() {
            $posts = new BlogPost();
            $posts = $posts->getMatching("blog_id", $this->blogId, "title");

            return $posts;
        }

        /**
         * Get a listing of post records with extended data for the blog
         *
         * @return array
         */
        public function getPostsExtended() {
            $posts = $this->getPosts();
            $categories = BlogCategory::getIndexedCategories();

            $data = array();
            foreach ($posts as $postCounter => $post) {
                $extData = array();
                $extData["post"] = $post;

                $extData["categories"] = array();
                $catResults = sqlquery("select * from blog_posts_in_categories where blog_post_id = " . $post["id"]);
                while ($f = sqlfetch($catResults)) {
                    $extData["categories"][$f["blog_category_id"]] = $categories[$f["blog_category_id"]];
                }

                $data[] = $extData;
            }

            return $data;
        }

        /**
         * Get the total number of blogs for this site
         *
         * @return int
         */
        public static function getTotalBlogs() {
            $total = 0;
            $result = sqlquery("select count(id) from blogs");
            while ($f = sqlfetch($result)) {
                $total = $f["count(id)"];
                break;
            }

            return $total;
        }

	}
?>
