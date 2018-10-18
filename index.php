<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container pt-4">
        <form action="date.php" method="post">
            <div class="row align-items-end">
                <div class="col">
                    <div class="form-group">
                        <label for="startDate">Start date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate"
                        value="<?php echo $_SESSION["startDate"]; ?>" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="endDate">End date</label>
                        <input type="date" class="form-control" id="endDate" name="endDate"
                        value="<?php echo $_SESSION["endDate"]; ?>" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <h3>
            Number of work days:
            <?php echo $_SESSION["numberOfDays"] ? $_SESSION["numberOfDays"] : 0; ?>
        </h3>
    </div>

</body>
</html>
