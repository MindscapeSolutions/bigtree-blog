<?
$result = BlogCategory::remove($bigtree["commands"][0]);

if (!$result) {
    echo "There was an internal error when attempting to remove the category.";
}
else {
    BigTree::redirect(ADMIN_ROOT . "blog-category");
}

?>
