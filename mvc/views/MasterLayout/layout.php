<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './mvc/views/widgets/header.php' ?>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            <div class="right_col" role="main">
                <?php
                // require_once './mvc/views/DetailLayout/'.$data['page'].'.php';
                include './mvc/views/DetailLayout/'.$data['page'].'.php';

                ?>
            </div>
            <!-- /page content -->
            <?php include './mvc/views/widgets/footer.php' ?>
        </div>
    </div>

    <?php
    //  include 'views/widgets/script.php' 
    ?>
</body>

</html>