<?php
include('config/db_connect.php');
$email = $title = $ingredients = '';
$errors = ['email' => '', 'title' => '', 'ingredients' => ''];

if (isset($_POST['submit'])) {
    //echo htmlspecialchars($_POST['email']);
    // echo htmlspecialchars($_POST['title']);
    //echo htmlspecialchars($_POST['ingredients']);

    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required <br />';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'email must be a valid email address';
        }
    }

    if (empty($_POST['title'])) {
        $errors['title'] = 'Title is required <br />';
    } else {
        $title = $_POST['title'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors['title'] = 'Title must be letters and spaces only';
        }
    }

    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'At least one ingredient is required <br />';
    } else {
        $ingredients = $_POST['ingredients'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
            $errors['ingredients'] = 'Ingredients must be a comma separated list';
        }
    }

    if (array_filter($errors)) {

    } else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
        $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            // If query fails, display an error message
            echo 'Query error: ' . mysqli_error($conn);
            // Close the database connection

        }
        
    }
}

?>



<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>
<section class="flex flex-col w-[800px] justify-center items-center my-10 bg-white rounded-md px-5">
    <h4 class="text-5xl text-[#cbb09c]">Add a Pizza</h4>
    <form action="add.php" method="POST" class="flex flex-col w-full my-5">
        <label class="text-gray-500 text-lg">Your Email:</label>
        <input type="text" name="email" class="h-[50px] mb-5 border-2 border-[#cbb09c]"
            value="<?php echo htmlspecialchars($email) ?>">
        <div class="text-red-500 font-bold mb-3">
            <?php echo $errors['email'] ?>
        </div>
        <label class="text-gray-500 text-lg">Pizza Title:</label>
        <input type="text" name="title" class="h-[50px] mb-5 border-2 border-[#cbb09c]"
            value="<?php echo htmlspecialchars($title) ?>">
        <div class="text-red-500 font-bold mb-3">
            <?php echo $errors['title'] ?>
        </div>
        <label class="text-gray-500 text-lg">Ingredients (comma seperated):</label>
        <input type="text" name="ingredients" class="h-[50px] mb-5 border-2 border-[#cbb09c]"
            value="<?php echo htmlspecialchars($ingredients) ?>">
        <div class="text-red-500 font-bold mb-3">
            <?php echo $errors['ingredients'] ?>
        </div>
        <div class="flex items-center justify-center">
            <input type="submit" name="submit" value="Submit"
                class="text-3xl bg-[#cbb09c] p-3 text-white rounded-md mr-10">
        </div>
    </form>
</section>
<?php include('templates/footer.php'); ?>

</html>