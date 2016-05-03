<?
$blogs = Blog::getListing();
?>

<div class="blog-listings">
<?
foreach ($blogs as $blogCounter => $blog) {
?>

    <div class="blog-listing">
        <a href="<?= $blog["page"]["link"] ?>"><h2><?= $blog["blog"]["title"] ?></h2></a>
        <p><?= $blog["author"]["last_name"] . ", " . $blog["author"]["first_name"] ?></p>
    </div>

<?
}
?>

</div>
