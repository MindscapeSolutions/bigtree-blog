<?
$authorAssigned = BlogAuthor::checkAssigned($bigtree["commands"][0]);

if ($authorAssigned) {
    echo "The author is assigned to a blog and cannot be deleted.";
}
else {
    $result = BlogAuthor::remove($bigtree["commands"][0]);

    if (!$result) {
        echo "There was an internal error when attempting to remove the author.";
    }
    else {
        BigTree::redirect(ADMIN_ROOT . "blog-author");
    }
}

?>
