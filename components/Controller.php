<?php

class Controller
{
    /**
     * перенаправление $url
     * @param $url
     * @return bool
     */
    public function redirect($url)
    {
        header('Location: ' . $url);

        return true;
    }

    /**
     * получение сообщения об ошибки
     */
    public function getFlashMessages()
    {
        if (isset($_SESSION['flashMessages']) && is_array($_SESSION['flashMessages'])) {
            $errors = $_SESSION['flashMessages'];

            $_SESSION['flashMessages'] = [];

            return $errors;
        } else {
            [];
        }
    }

    /**
     * получение сообщения по типу
     * @param $message
     * @param $type
     */
    public function addFlashMessage($message, $type)
    {
        if (!isset($_SESSION['flashMessages']) || !is_array($_SESSION['flashMessages'])) {
            $_SESSION['flashMessages'] = [];
        }

        $_SESSION['flashMessages'][] = ['message' => $message, 'type' => $type];
    }
}