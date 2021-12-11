<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Mitchell Soto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/site.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <header>
      <?php 
        include("includes/inc_header.php");
      ?>
    </header>
    <div class="container">
        <?php
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'about':
                        include('includes/inc_home.php');
                        break;
                    case 'my_portfolio':
                        include('includes/inc_my_portfolio.php');
                        break;
                    case 'resume':
                        include('includes/inc_resume.php');
                        break;
                    case 'contact_form':
                        include('includes/inc_contact_form.php');
                        break;
                    
                    default:
                        include('includes/inc_home.php');
                        break;
                }
            } else
                include('includes/inc_home.php');
        ?>
    </div>
    <footer>
      <?php include("includes/inc_footer.php");?>
    </footer>
</body>
</html>