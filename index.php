<?php
session_start();

include('config/db_connect.php');
include('timeago.php');
$sql = 'SELECT * FROM yaks ORDER BY created DESC';
$result = mysqli_query($conn, $sql);
$yaks = mysqli_fetch_all($result, MYSQLI_ASSOC);

if(isset($_SESSION["loggedin"])){
    $id = $_SESSION['id'];
}

include('voteyak.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <title>Yik Yak</title>
    <?php include ('templates/header.php'); ?>
    <h1>Welcome to Yik Yak, the anonymous social media app</h1>

    <?php
    if(isset($_SESSION["loggedin"])){ ?>
        <div align='center'><a href="postyak.php">Post a yak?</a></div>
    <?php } else { ?>
        <div align='center'>Please login to post a yak</div>
    <?php } ?>

    <h4 style="text-align:center">Yaks</h4>
    <ul class = "yak-layout">
        <div>
            <?php foreach($yaks as $yak):
                echo htmlspecialchars($yak['yak']); ?><br><br>
                <form class="" action="index.php" method="post">
                    <input type="hidden" name="yakid" value="<?php echo $yak['id'] ?>">
                    <button type="submit" name="upvote">Upvote</button>
                    <button type="submit" name="downvote">Downvote</button>
                </form>
                <?php
                echo intval($yak['score']); //getting total score of each yak
                echo "<p style='color:lightgray; font-size: 10px'>". get_time_ago(strtotime($yak['created'])) ."<p style='all:unset;'>"; ?>
                <a style='color:lightgray; font-size: 10px;' href="yakcomments.php?id=<?php echo $yak['id'] ?>">Comments</a><br><br><br><br>
            <?php endforeach; ?>
        </div>
    </ul>

    <?php include ('templates/footer.php'); ?>
</html>
