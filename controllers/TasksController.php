<?php

include_once ROOT . '/models/Tasks.php';

class TasksController extends Controller
{
    /**
     * Action для "Список задач"
     */
	public function actionIndex()
	{
        $sort = 'id';

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }

        $page = 0;
        $perPage = 3;

        if (isset($_GET['page'])) {
            $page = ((int)$_GET['page']);
        }

        $tasksList = Tasks::getTasksList($page, $perPage, $sort);
        $tasksCount = Tasks::getTasksCount();

        $pagesCount = ceil($tasksCount / $perPage);

        $messages = $this->getFlashMessages();

        $isAdmin = false;

        if (isset($_SESSION['isAdmin'])) {
            $isAdmin = $_SESSION['isAdmin'];
        }

		require_once(ROOT . '/views/tasks/index.php');

		return true;
	}

    /**
     * Action для "Регистрация задачи"
     */
    public function actionRegister()
    {
        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $name = $_POST['name'];
            $email = $_POST['email'];
            $tasks = $_POST['tasks'];

            // Флаг ошибок
            $errors = false;

            // validation
            if (!tasks::checkName($name)) {
                $this->addFlashMessage('Имя не должно быть короче 2-х символов', 'error');
                $errors = true;
            }
            if (!tasks::checkEmail($email)) {
                $this->addFlashMessage('Неправильный email', 'error');
                $errors = true;
            }
            if (!tasks::checkTasks($tasks)) {
                $this->addFlashMessage('Задача не должна быть короче 6-ти символов', 'error');
                $errors = true;
            }

            if ($errors == false) {
                // Если ошибок нет
                // Регистрируем задачу
                Tasks::registerTask($name, $email, $tasks);
                $this->addFlashMessage('Задача успешно зарегистрирована', 'success');
            }
        }

        // отправляем браузер обратно на список задач
        return $this->redirect('/');
    }

    /**
     * Action для "Просмотра задачи"
     */
    public function actionView()
    {
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $this->addFlashMessage('Только для администратора', 'error');
            return $this->redirect('/');
        }

        $id = 0;

        if (isset($_GET['id'])) {
            $id = ((int)$_GET['id']);
        }

        $task = Tasks::getTask($id);

        if (!$task) {
            $this->addFlashMessage('Задача не найдена', 'error');
            return $this->redirect('/');
        }

        $messages = $this->getFlashMessages();

        require_once(ROOT . '/views/tasks/view.php');

        return true;
    }

    /**
     * Action для "Редактирования задачи"
     */
    public function actionEdit()
    {
        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $tasks = $_POST['tasks'];
            $completed = isset($_POST['completed']) && $_POST['completed'] ? 1 : 0;

            // Флаг ошибок
            $errors = false;

            // Валидация данных
            if (!tasks::checkName($name)) {
                $this->addFlashMessage('Имя не должно быть короче 2-х символов', 'error');
                $errors = true;
            }
            if (!tasks::checkEmail($email)) {
                $this->addFlashMessage('Неправильный email', 'error');
                $errors = true;
            }
            if (!tasks::checkTasks($tasks)) {
                $this->addFlashMessage('Задача не должна быть короче 6-ти символов', 'error');
                $errors = true;
            }

            if ($errors == false) {
                // Если ошибок нет
                // Обновляем задачу
                Tasks::updateTask($id, $name, $email, $tasks, $completed);
                $this->addFlashMessage('Задача успешно обновлена', 'success');
                // отправляем браузер обратно на список задач
                return $this->redirect('/');
            } else {
                // отправляем браузер обратно на экран редактирования
                return $this->redirect('/tasks/view?id=' . $id);
            }
        }

        // отправляем браузер обратно на список задач
        return $this->redirect('/');
    }
}

