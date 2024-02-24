<?php
include('config/db_connect.php');


if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } {
        echo 'query error: ' . mysqli_error($conn);
    }
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    // make sql
    $sql = "SELECT * FROM pizzas WHERE id=$id";
    // get the query result
    $result = mysqli_query($conn, $sql);
    // fetch result in array format
    $pizza = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);

}

?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="font-mono text-gray-400 flex flex-col items-center my-10 gap-2">
    <?php if ($pizza) { ?>
        <h4 class="text-black font-bold">
            <?php echo htmlspecialchars($pizza['title']); ?>
        </h4>
        <p>Created by:
            <?php echo htmlspecialchars($pizza['email']); ?>
        </p>
        <p>
            <?php echo date($pizza['created_at']); ?>
        </p>
        <h5>Ingredients:</h5>
        <p>
            <?php echo htmlspecialchars($pizza['ingredients']); ?>
        </p>
        <form action="details.php" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'] ?>">
            <input type="submit" name="delete" value="Delete" class="bg-[#cbb09c] p-2 rounded-lg text-black">
    </form>
    <?php } else { ?>
         <h1>There no such Pizza !</h1>
    <?php } ?>
</div>

<?php include('templates/footer.php'); ?>

</html>