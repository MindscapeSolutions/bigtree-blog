<?
	class BlogCategory extends BigTreeModule {
		var $Table = "blog_categories";

        public static function GetIndexedCategories() {
            $cats = new BlogCategory();
            $cats = $cats->getAll();

            $categories = array();
            foreach ($cats as $catCounter => $cat) {
                $categories[$cat["id"]] = $cat["title"];
            }

            return $categories;
        }

	}
?>
