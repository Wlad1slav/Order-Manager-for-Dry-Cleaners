<?php
include('base/include.php');
$pageTitle = "Користувачі";

include('base/header.php');
include('base/sidebar.php');
?>

<div>
    <form method="post" class="userForm">
        <h3>User</h3>
        <label>
            Username:
            <input name="username" type="text" required>
        </label>

        <label>
            Password:
            <input name="password" type="password" required>
        </label>

        <label>
            Rights:
            <select name="rights" required>
                <?php
                $rights = require '../settings/rights_list.php';
                foreach ($rights as $right)
                    echo "<option value='" . $right->getId() ."'>" . $right->getSlug() . "</option>";
                ?>
            </select>
        </label>

        <input type="submit" value="ADD">

    </form>
    
    <ul>
        
    </ul>
</div>

<?php include('base/footer.php'); ?>
