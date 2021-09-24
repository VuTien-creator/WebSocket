<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'widgets/header.php' ?>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            <div class="right_col" role="main">
                <?php
                include $view;
                ?>
            </div>
            <!-- /page content -->
            <?php include 'widgets/footer.php' ?>
        </div>
    </div>

    <?php
    //  include 'views/widgets/script.php' 
    ?>
</body>

</html>