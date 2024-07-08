<?php

namespace common\components\utils;


use DateInterval;
use DateTime;

/**
 * Class Utils
 * @package common\components\utils
 */
class Utils
{
    /**
     * Подставляет значение модели по заданному шаблону
     * Если параметр, заданный в шаблоне, неправильный, то он будет проигнорирован
     *
     * @param string $text Шаблон, который необходимо преобразовать в строку
     *
     * Данные, которые необходимо подставить в строку
     * Вида:
     * [
     *  "city" => "Город"
     * ]
     * @param array $model
     * @return string|string[]
     */
    public function replaceMetaTag($text = '', $model = [])
    {
        preg_match_all('~%(.*?)%~', $text,  $matches);

        foreach ($matches[0] as $match) {
            $modelKey = str_replace("%", "", $match);
            if (isset($model[$modelKey])) {
                $text = str_replace($match, $model[$modelKey], $text);
            } else {
                $text = str_replace($match, "", $text);
            }
        }
        return $text;
    }

    /**
     * Преобразует rules ошибки в строку для вывода на фронте
     * @param $errors
     * @return string
     */
    public static function errorsToStr($errors)
    {
        $errorMessage = '';

        foreach ($errors as $key => $error) {
            $errorMessage .= $key . ": " . $error[0] . " ";
        }

        return $errorMessage;
    }

    /**
     * Прибавляет к текущему дню переданное кол-во дней и возвращает результат.
     *
     * @param int $daysToAdd Сколько дней добавить к текущему дню
     * @param string $format Формат, в котором вернется итоговая дата
     * @return string|null Дата
     */
    public static function addDaysToCurrentDate($daysToAdd, $format = "d.m.Y")
    {
        try {
            $datetime = new DateTime();
            $datetime->add(new DateInterval("P{$daysToAdd}D"));

            return $datetime->format($format);
        } catch (\Exception $e) {
        }

        return null;
    }
}
