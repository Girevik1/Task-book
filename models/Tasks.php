<?php

class Tasks
{
    /**
     * Возвращает массив задач
     * @param $page
     * @param $perPage
     * @param $sort
     * @return array
     */
    public static function getTasksList($page, $perPage, $sort) {
        $pageOffset = $page * $perPage;
        $allowedSortColumns = ['id', 'name', 'email', 'tasks', 'completed'];

        $sortColumn = 'id';

        if (in_array($sort, $allowedSortColumns)) {
            $sortColumn = $sort;
        }

        $db = Db::getConnection();
        $tasksList = array();

        $sql = 'SELECT id, name, email, tasks, completed FROM tasks ORDER BY '.$sortColumn.' ASC LIMIT :limit OFFSET :offset';
        $result = $db->prepare($sql);
        $result->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $result->bindParam(':offset', $pageOffset, PDO::PARAM_INT);
        $result->execute();

        $i = 0;
        while($row = $result->fetch()) {
            $tasksList[$i]['id'] = $row['id'];
            $tasksList[$i]['name'] = $row['name'];
            $tasksList[$i]['email'] = $row['email'];
            $tasksList[$i]['tasks'] = $row['tasks'];
            $tasksList[$i]['completed'] = $row['completed'];
            $i++;
        }

        return $tasksList;
    }

    /**
     * Возвращает задачу по id
     * @param $id
     * @return mixed
     */
    public static function getTask($id) {
        $db = Db::getConnection();

        $sql = 'SELECT id, name, email, tasks, completed FROM tasks WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch();
    }

    /**
     * Проверяет имя: не меньше, чем 2 символа
     * @param string $name <p>Имя</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет задачу: не меньше, чем 6 символов
     * @param string $tasks <p>задачи</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkTasks($tasks)
    {
        if (strlen($tasks) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Возвращает общее количество задач
     */
    public static function getTasksCount() {
        $db = Db::getConnection();

        $sql = 'SELECT count(*) as total FROM tasks';
        $result = $db->prepare($sql);
        $result->execute();

        $total = $result->fetch()['total'];

        return $total;
    }

    /**
     * Регистрация задач
     * @param $name
     * @param $email
     * @param $tasks
     * @return bool
     */
    public static function registerTask($name, $email, $tasks)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'INSERT INTO tasks (name, email, tasks)'
            . 'VALUES (:name, :email, :tasks)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':tasks', $tasks, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Обновление задачи
     * @param $id
     * @param $name
     * @param $email
     * @param $tasks
     * @param $completed
     * @return bool
     */
    public static function updateTask($id, $name, $email, $tasks, $completed)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'UPDATE tasks SET name = :name, email = :email, tasks = :tasks, completed = :completed WHERE id = :id';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':tasks', $tasks, PDO::PARAM_STR);
        $result->bindParam(':completed', $completed, PDO::PARAM_INT);
        return $result->execute();
    }
}