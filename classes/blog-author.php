<?
	class BlogAuthor extends BigTreeModule {
		var $Table = "blog_authors";

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

	}
?>
