<?php

class AdminController extends Controller
{
    /**
     * Action для "Аутентификация администратора"
     */
    public function actionAuth()
    {
        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $login = $_POST['login'];
            $password = $_POST['password'];

            if ($login == 'admin' && $password == '123') {
                $_SESSION['isAdmin'] = true;
            } else {
                $this->addFlashMessage('Неверный пароль администратора', 'error');
            }

        }

        return $this->redirect('/');
    }

    /**
     * Action для "Выход администратора"
     */
    public function actionLogout()
    {
        $_SESSION['isAdmin'] = false;

        return $this->redirect('/');
    }
}