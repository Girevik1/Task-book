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
            <?php if ($isAdmin) { ?>
                Здравствуйте, Админ! <a href="/logout">Выход</a>
            <?php } else { ?>
                <h2>Авторизация для администратора</h2>
                <form action="/auth/" method="post">
                    <div class="form-group">
                        <label for="login">ИМЯ</label>
                        <input type="text" class="form-control" id="login" placeholder="" name="login">
                    </div>
                    <div class="form-group">
                        <label for="password">ПАРОЛЬ</label>
                        <input type="password" class="form-control" id="password" placeholder=""
                               name="password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">вход</button>
                </form>
            <?php } ?>
        </div>
    </div>
</div>

<br>
<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Запиши свою задачу</h2>
            <form action="/tasks/register" method="post">

                <div class="form-group">
                    <label for="name">ИМЯ</label>
                    <input type="text" class="form-control" name="name" placeholder=""/>
                </div>
                <div class="form-group">
                    <label for="email">E-MAIL АДРЕС</label>
                    <input type="email" class="form-control" name="email" placeholder=""/>
                </div>
                <div class="form-group">
                    <label for="task">ЗАДАЧА</label>
                    <input type="text" class="form-control" name="tasks" placeholder=""/>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">задать</button>

            </form>
        </div>
    </div>
</div>

<br>
<br>

<div class="container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th><a href="/?page=<?= $page ?>&sort=name">ИМЯ</a></th>
            <th><a href="/?page=<?= $page ?>&sort=email">E-MAIL АДРЕС</a></th>
            <th><a href="/?page=<?= $page ?>&sort=tasks">ЗАДАЧИ</a></th>
            <th><a href="/?page=<?= $page ?>&sort=completed">ВЫПОЛНЕНО</a></th>
            <?php if ($isAdmin) { ?>
                <th></th>
            <?php } ?>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasksList as $tasksItem) { ?>
            <tr>
                <td><?= $tasksItem['name']; ?></td>
                <td><?= $tasksItem['email']; ?></td>
                <td><?= $tasksItem['tasks']; ?></td>
                <td><?= $tasksItem['completed'] ? 'Да' : 'Нет'; ?></td>
                <?php if ($isAdmin) { ?>
                    <td>
                        <a href="/tasks/view?id=<?= $tasksItem['id']; ?>">Редактировать</a>
                    </td>
                <?php } ?>
            </tr>
        <?php }; ?>
        </tbody>
    </table>
    <ul class="pagination justify-content-center">
        <? if ($page > 0) { ?>
            <li class="page-item"><a class="page-link" href="/?page=<?= $page - 1 ?>&sort=<?= $sort ?>">Предыдущая</a>
            </li>
        <? } ?>
        <? for ($i = max([$page - 5, 0]); $i < min([$page + 5, $pagesCount]); $i++) { ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="/?page=<?= $i ?>&sort=<?= $sort ?>">
                    <?= $i + 1 ?>
                </a>
            </li>
        <? } ?>
        <? if ($page < ($pagesCount - 1)) { ?>
            <li class="page-item"><a class="page-link" href="/?page=<?= $page + 1 ?>&sort=<?= $sort ?>">Следующая</a>
            </li>
        <? } ?>
    </ul>
</div>
</body>
</html>


