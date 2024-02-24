<?php

include('config/db_connect.php');

// write query for all pizzas
$sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

// make query & get result
$result = mysqli_query($conn, $sql);
if (!$result) {
    // If query fails, display an error message
    echo 'Query error: ' . mysqli_error($conn);
    // Close the database connection
    mysqli_close($conn);
    // Stop further execution of the script
    exit();
}

// fetch the resultig rows as an array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory
mysqli_free_result($result);

// close connection
mysqli_close($conn);


?>





<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<h4 class="text-gray-500 text-3xl my-5">Pizzas !</h4>
<div>
    <div class="grid grid-cols-3 gap-10">
        <?php foreach ($pizzas as $pizza) { ?>
            <div class="bg-white w-[450px] h-[200px] rounded-md flex items-center justify-center py-2">
                <div>
                
                    <div class="flex flex-col items-center justify-center gap-5">
                        <h6>
                            <?php echo htmlspecialchars($pizza['title']); ?>
                        </h6>
                        <ul>
                            <?php foreach (explode(',', $pizza['ingredients']) as $ing) { ?>
                                <li>
                                    <?php echo htmlspecialchars($ing); ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <div>
                            <a href="details.php?id=<?php echo $pizza['id'] ?>" class="text-[#cbb09c]">MORE INFO</a>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include('templates/footer.php'); ?>

</html>