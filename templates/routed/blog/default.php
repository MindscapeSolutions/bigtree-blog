<?
$blogCount = Blog::getTotalBlogs();

switch (count($bigtree["commands"])) {
    case 0:
        // blog post listing
        $blog = new Blog($blogId);
?>

<div class="posts">

<?
foreach ($blog->getPostsExtended() as $postCounter => $post) {
    $postDate = new DateTime($post["post"]["original_post_date"]);
?>

    <div class="post">
        <h2><?= $post["post"]["title"] ?></h2>
        <p>
            <?= $postDate->format("F j, Y") ?>

<?
    if (count($post["categories"]) > 0) {
        echo "&nbsp;|&nbsp;";

        $catCounter = 0;
        foreach ($post["categories"] as $catId => $cat) {
            echo $cat;

            if ($catCounter < count($post["categories"]) - 1) {
                echo ", ";
            }

            $catCounter++;
        }
    }
?>

        </p>

<?
    if (!empty($post["post"]["summary"])) {
?>

        <p><?= $post["post"]["summary"] ?></p>

<?
    }
    else {
        $truncateCount = BigTreeAdmin::getSetting("com.mindscapesolutions.blog*summary-truncate")["value"];
        if (empty($truncateCount)) {
            $truncateCount = 100;
        }
        else {
            $truncateCount = intval($truncateCount);
        }
?>

        <p><?= substr(strip_tags($post["post"]["content"]), 0, $truncateCount) . " ..." ?></p>

<?
    }

    $readMoreLabel = BigTreeAdmin::getSetting("com.mindscapesolutions.blog*read-more-label")["value"];
    $readMoreLabel = !empty($readMoreLabel) ? $readMoreLabel : "Read More";

    if ($blogCount < 2) {
?>
    
        <p><a href="<?= WWW_ROOT ?>blog/<?= BigTreeCMS::urlify($post["post"]["title"]) ?>"><?= $readMoreLabel ?></a></p>

<?
    }
    else {
?>

        <p><a href="<?= WWW_ROOT ?>blog/<?= BigTreeCMS::urlify($blog->record["title"]) ?>/<?= BigTreeCMS::urlify($post["post"]["title"]) ?>"><?= $readMoreLabel ?></a></p>

<?
    }
?>

    </div> <!-- post -->

<?
}
?>

</div> <!-- posts -->



<?
        break; // blog listing

    case 1:
        // blog post for default blog        
        $blog = new Blog($blogId);
        $post = $blog->getPostByTitle($bigtree["commands"][0]);
        break;
    case 2:
        // blog post for author blog
        $blog = Blog::getByTitle($bigtree["commands"][0]);
        $post = $blog->getPostByTitle($bigtree["commands"][1]);
        break;
}

switch (count($bigtree["commands"])) {
    case 1:
    case 2:
        $postDate = new DateTime($post["post"]["original_post_date"]);
?>

    <div class="post-detail">
        <h2><?= $post["post"]["title"] ?></h2>
        <p>
            <?= $postDate->format("F j, Y") ?>

<?
    if (count($post["categories"]) > 0) {
        echo "&nbsp;|&nbsp;";

        $catCounter = 0;
        foreach ($post["categories"] as $catId => $cat) {
            echo $cat;

            if ($catCounter < count($post["categories"]) - 1) {
                echo ", ";
            }

            $catCounter++;
        }
    }
?>

        </p>

<?
    if (!empty($post["post"]["feature_image"])) {
?>

        <p><img src="<?= $post["post"]["feature_image"] ?>" /></p>
<?
    }
?>

        <p><?= $post["post"]["content"] ?></p>
    </div> <!-- post-detail -->

    <div>
        <a href="<?= WWW_ROOT . $bigtree["page"]["path"] ?>">Back to Blog</a>
    </div>
<?
        break;
}
?>

