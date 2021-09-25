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
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //Push all errors in an array
    $error = [];

    if (isset($_POST['submit'])) {
        //A function to create firstname and lastname
        function validateName(string $nameValue, string $name)
        {
            global $error;
            if (isset($_POST[$nameValue])) {
                if (strlen($_POST[$nameValue]) < 2) {
                    $error[$nameValue] = "Please enter a $name with atleast 2 characters. ";
                }
            }
        }
        validateName("fname", "first name");
        validateName("lname", "last name");

        $email = $_POST['email'];
        $afterAt = substr($email, strpos($email, "@") + 1); //Everything after @
        $dotDomainIndex = strpos($afterAt, '.'); //Everything after "." e. g. .com
        $topLevelDomain = (substr($afterAt, $dotDomainIndex + 1)); //The top level domain of an E-Mail e.g "com"

        if (
            !isset($_POST['email']) ||
            strlen($_POST['email']) < 5 ||
            str_contains($_POST['email'], "@.") ||
            strlen($topLevelDomain) < 2
            //Validates only simple E-Mails for e.g h.dong@hotmail.com !== h.dong@edu.ac.at
        ) {
            $error['email'] = "Please enter a valid e-mail address. ";
        }

        if (!isset($_POST['category'])) {
            $error['category'] = "Please select one of following categories. ";
        }

        if (strlen($_POST['message']) < 10) {
            $error['message'] = "Please be more detailed about your message (At least 10 characters). ";
        }

        if ($_POST['agb'] === '0') {
            $error['agb'] = "Please confirm our terms and conditions";
        }

        //Prevent changing values for radio buttons in HTML via DevTool
        if (isset($_POST['gender'])) {
            if ($_POST['gender'] !== 'male' && $_POST['gender'] !== 'female' && $_POST['gender'] !== 'other') {
                $error['gender'] = "Value changed";
            }
        }

        //Check if radio button is set, if not add it to $_POST
        if (!isset($_POST['gender'])) {
            $_POST['gender'] = '';
            $error['gender'] = "Please select a gender";
        }
    }
    //Show all error message in error array
    /**
     * @param string $errorKey The array key from error array
     */
    function showError(string $errorKey)
    {
        global $error;
        if (isset($error[$errorKey])) {
            echo '<p class="mt-0 error-msg">' . $error[$errorKey] . '</p>';
        }
    }


    //Saves the value after a (failed) submit
    /**
     * @param string The value of the $_POST variable 
     */
    function old(string $value)
    {
        if (isset($_POST[$value])) {
            echo $_POST[$value];
        }
    }

    /**
     * A function to generate radio buttons
     * @param String $name To assign the radio buttons
     * @param String $id To assign the id's with the labels and value
     * @param String $content The context of the radio button
     * */

    function generateRadioButtons(string $name, string $id, string $content)
    {
        $checked = '';
        if (isset($_POST[$name]) && $_POST[$name] === $id) {
            $checked = 'checked= "checked"';
        }
        echo ('
        <input type="radio" name="' . $name . '" id="' . $id . '" value="' . $id . '"' . $checked . '>
        <label for="' . $id . '">' . $content . '</label>
        ');
    }

    //Loop through the array for options
    $options =  [
        "small" => "Small",
        "medium" => "Medium",
        "large" => "Large",
        "xlarge" => "XL"
    ];
    ?>

    <?php

    if (!empty($error) || !isset($_POST['submit'])) : ?>


        <form action="" method="POST" novalidate>
            <label for="fname" class="mandatory">Firstname</label>
            <input type="text" name="fname" id="fname" class="mb-3" value="<?php old('fname'); ?>" required>
            <?php
            showError('fname');
            ?>

            <label for="lname" class="mandatory">Lastname</label>
            <input type="text" name="lname" id="lname" class="mb-3" value="<?php old('lname'); ?>" required>

            <?php
            showError('lname');
            ?>

            <label for="email" class="mandatory">E-Mail</label>
            <input type="email" name="email" id="email" class="mb-3" value="<?php old('email'); ?>">
            <?php
            showError('email');
            ?>
            <p class="mb-0 mt-0 mandatory">Gender</p>
            <div class="mb-3">
                <?php
                generateRadioButtons("gender", "male", "Male");
                generateRadioButtons("gender", "female", "Female");
                generateRadioButtons("gender", "other", "Other");
                ?>
            </div>
            <?php
            showError('gender');
            ?>


            <label for="category" class="mandatory">Category</label>
            <select name="category" id="category" class="mb-3">
                <option value="_default" selected disabled>--Please select following options--</option>
                <?php foreach ($options as $value => $content) : ?>
                    <option value="<?php echo $value; ?>" <?php echo (isset($_POST['category']) && $_POST['category'] === $value ? 'selected="false"' : ""); ?>><?php echo $content; ?></option>
                <?php endforeach; ?>
            </select>
            <?php
            showError('category');
            ?>
            <label for="msg" class="mandatory">Message</label>
            <textarea name="message" id="msg" cols="30" rows="10" class="mb-3"><?php old('message'); ?></textarea>

            <?php
            showError('message');
            ?>

            <div>
                <input type="hidden" name="agb" value="0">
                <input type="checkbox" name="agb" id="agb" value="1" <?php echo (isset($_POST['agb']) && ($_POST['agb'] === '1') ? "checked" : ""); ?>>
                <label for="agb" class="mb-3 mandatory">I agree to the terms and conditions</label>
                <?php
                showError('agb');
                ?>
            </div>
            <div>
                <input type="hidden" name="newsletter" value="0">
                <input type="checkbox" name="newsletter" id="newsletter" value="1">
                <label for="newsletter" class="mb-3">Would you like to receive newsletters?</label>
            </div>

            <button class="send" value="submit" name="submit">Submit</button>
        </form>
</body>

</html>
<?php endif; ?>