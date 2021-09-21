<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Validate</title>
</head>

<body>
    <?php
    $error = [];
    if (!isset($_POST['name'])) {
        if (strlen($_POST['name']) < 2) {
            $error[] = "Please enter a name with atleast 2 characters. ";
        }
    }
    /**
     * a@b.at 
     *  */
    $email = $_POST['email'];
    $afterAt = substr($email, strpos($email, "@") + 1); //Everything after @
    $dotDomainIndex = strpos($afterAt, '.'); //Everything after "."
    $topLevelDomain = (substr($afterAt, $dotDomainIndex + 1)); //The top level domain of an E-Mail e.g "com"

    if (!isset($_POST['email'])) {
        if (
            !strlen($_POST['name']) < 2 ||
            !strpos($_POST['email'], "@.") ||
            !strpos($afterAt, '.') ||
            !strlen($topLevelDomain) < 2
            //Validates only simple E-Mails for e.g h.dong@hotmail.com !== h.dong@edu.ac.at
        ) {
            $error[] = "Please enter a valid e-mail address. ";
        }
    }

    if (!isset($_POST['category'])) {
        $error[] = "Please select one of the categories. ";
    }

    if (strlen($_POST['message']) < 10) {
        $error[] = "Please be more detailed about your message. ";
    }

    if (isset($_POST['newsletter'])) {
        echo ('Checkbox is checked ');
    }

    $errorMsg = '';
    if (count($error) > 0) {
        $errorMsg = implode(',', $error); //Display errors(?)
    }

    $errorMsg = str_replace(',', '', $errorMsg); //Removes the comma
    echo ($errorMsg);
    ?>


    <form action="" method="POST">

        <label for="name" class="mandatory">Name</label>
        <input type="text" name="name" id="name" class="mb-3" required>



        <label for="email" class="mandatory">E-Mail</label>
        <input type="email" name="email" id="email" class="mb-3">



        <label for="category" class="mandatory">Category</label>
        <select name="category" id="category" class="mb-3">
            <option value="_default" selected disabled>--Please select following options--</option>
            <option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="large">Large</option>
        </select>



        <label for="msg" class="mandatory">Message</label>
        <textarea name="message" id="msg" cols="30" rows="10" class="mb-3"></textarea>



        <div>
            <input type="checkbox" name="newsletter" id="newsletter">
            <label for="newsletter" class="mb-3">Would you like to receive newsletters?</label>
        </div>


        <button value="submit" name="submit">Submit</button>
    </form>
</body>

</html>