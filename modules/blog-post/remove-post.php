<?
$result = BlogPost::remove($bigtree["commands"][0]);

if (!$result) {
    echo "There was an internal error when attempting to remove the post.";
}
else {
    BigTree::redirect(ADMIN_ROOT . "blog-post");
}

?>
