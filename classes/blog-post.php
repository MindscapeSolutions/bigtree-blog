<?
	class BlogPost extends BigTreeModule {
		var $Table = "blog_posts";

        public static function makeImageAbsolute($url) {
            $newUrl = str_replace("{staticroot}", STATIC_ROOT, $url);

            return $newUrl;
        }
	}
?>
