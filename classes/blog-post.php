<?
	class BlogPost extends BigTreeModule {
		var $Table = "blog_posts";

        public static function makeImageAbsolute($url) {
            $newUrl = str_replace("{staticroot}", STATIC_ROOT, $url);

            return $newUrl;
        }

        public static function remove($postId) {
            $postId = intval($postId);

            $cResult = sqlquery("delete from blog_posts_in_categories where blog_post_id = $postId");

            if (!$cResult) {
                return false;
            }

            $result = sqlquery("delete from blog_posts where id = $postId");
            $cResult = sqlquery("delete from bigtree_module_view_cache");

            if (!$result) {
                return false;
            }

            return true;
        }
	}
?>
