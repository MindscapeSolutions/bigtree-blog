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

        public static function remove($categoryId) {
            $categoryId = intval($categoryId);

            $cResult = sqlquery("delete from blog_posts_in_categories where blog_category_id = $categoryId");

            if (!$cResult) {
                return false;
            }

            $result = sqlquery("delete from blog_categories where id = $categoryId");
            $cResult = sqlquery("delete from bigtree_module_view_cache");

            if (!$result) {
                return false;
            }

            return true;
        }
	}
?>
