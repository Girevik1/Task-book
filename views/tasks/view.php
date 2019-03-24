<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Задачник</title>
</head>
<body>

<?php
if (isset($messages) && is_array($messages) && count($messages) > 0) { ?>

<div class="container">
    <?php foreach ($messages as $message) {
        $class = '';

        if ($message['type'] === 'error') {
            $class = 'alert-danger';
        }

        if ($message['type'] === 'success') {
            $class = 'alert-success';
        }
        ?>
        <div class="alert <?= $class ?>" role="alert">
            <?= $message['message'] ?>
        </div>
    <?php }; ?>
</div>
<?php }; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Редактирование задачи</h2>
            <form action="/tasks/edit" method="post">
                <input type="hidden" name="id" value="<?= $task['id'] ?>"/>

                <div class="form-group">
                    <label for="name">ИМЯ</label>
                    <input type="text" class="form-control" name="name" placeholder="" value="<?= $task['name'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="email">E-MAIL АДРЕС</label>
                    <input type="email" class="form-control" name="email" placeholder="" value="<?= $task['email'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="task">ЗАДАЧА</label>
                    <input type="text" class="form-control" name="tasks" placeholder="" value="<?= $task['tasks'] ?>"/>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="completed" value="1" id="completed"
                        <?= $task['completed'] ? 'checked="checked"' : '' ?>>
                        <label class="form-check-label" for="completed">
                            выполнено
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">редактировать</button>

            </form>
        </div>
    </div>
</div>
</body>
</html>


