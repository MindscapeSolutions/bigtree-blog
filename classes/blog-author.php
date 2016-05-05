<?
	class BlogAuthor extends BigTreeModule {
		var $Table = "blog_authors";

        /**
         * Check if an author is assigned to at least one blog
         *
         * @param int $authorId
         *
         * @return bool
         */
        public static function checkAssigned($authorId) {
            $authorId = intval($authorId);

            $result = sqlquery("select * from blogs where blog_author_id = $authorId");

            return sqlrows($result) > 0;
        }

        /**
         * Get last name/first name combos from the blog authors table
         *
         * @param array
         *      => value
         *      => last name
         *
         * @return array
         *      => value
         *      => last name, first name
         */
        public static function GetAllNames($authors) {
            $fullNames = array();

            foreach ($authors as $aCounter => $author) {
                $a = new BlogAuthor();
                $a = $a->get($author["value"]);

                $fullNames[] = array(
                    "value" => $a["id"],
                    "description" => $a["last_name"] . ", " . $a["first_name"]
                );
            }

            return $fullNames;
        }

        /**
         * Remove an author from the database
         *
         * @param int $authorId
         *
         * @return bool
         */
        public static function remove($authorId) {
            $authorId = intval($authorId);

            $result = sqlquery("delete from blog_authors where id = $authorId");
            $cResult = sqlquery("delete from bigtree_module_view_cache");

            if (!$result) {
                return false;
            }
            else {
                return true;
            }
        }
	}
?>
