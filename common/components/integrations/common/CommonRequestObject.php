<?php


namespace common\components\integrations\common;



/**
 * Class CommonRequestObject
 * @package common\components\delivery\yandex\models\request
 *
 * Базовый класс запроса.
 *
 * Для каждого наследуемого объекта запроса необходимо переопределять метод fields()
 * В методе fields() прописывется массив переменных, которые необходимо добавить в тело запроса.
 * Смотри ArrayableTrait с полным описанием метода
 *
 * Если переменная помечена как [required] значит она обязательна к заполнению
 * Если перменная не отмечена как [required] или помечена как [optional] значит она не обязательна к заполнению
 */
abstract class CommonRequestObject extends CommonObject
{
}