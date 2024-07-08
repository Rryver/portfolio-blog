<?php


namespace common\components\delivery\deliveryOutputCreator;


use common\components\cart\Cart;
use common\components\delivery\deliveryOutput\DeliveryOutputBoxberryPickpoint;
use common\components\delivery\deliveryOutput\DeliveryOutputDefault;
use common\components\delivery\deliveryOutputCreator\common\DeliveryCreateException;
use common\components\delivery\deliveryOutputCreator\common\DeliveryOutputCreatorInterface;
use common\components\delivery\deliveryOutputCreator\common\NeedUnsetDeliveryModelException;
use common\models\City;
use common\models\Delivery;
use Exception;
use Yii;

/**
 * Class DeliveryOutputCreatorAbstract
 * @package common\components\delivery\deliveryOutputCreator
 *
 * Базовый класс заполнения объекта информации о доставке.
 *
 * Если требуется добавить новую доставку:
 * 1. Создать новый Creator и унаследоваться от этого класса
 * 2. Прописать логику получения цены, интервала доставки и итоговой даты доставки
 * 2.1 Задать логику для метода calculateExternalDeliveryInfo или оставить пустым
 * Метод отвечает за получение информации для дальнейшего рассчета стоимости и времени.
 * Метод сохраняет внешние данные в переменную, что бы несколько раз не обращаться к API
 * 2.2 Задать логику для метода fillPrice()
 * 2.3 Задать логику для метода fillTimeInterval()
 * 2.4 Задать логику для метода fillDeliveryDate()
 *
 * 3. Если в итоговом объекте требуеются новые переменные, то создать наследника от DeliveryOutputDefault
 * 3.1 Переопределить метод createNewDeliveryOutputObject() этого класса в новом Creator и вернуть новый объект доставки созданный в пункте 4
 *
 * 4 Создать const в классе Delivery для новой доставки с уникальным номером
 * 4.1 Добавить новую доставку в Delivery->getDeliveryList() - требуется для выбора модуля расчета при создании доставки в админ панели
 *
 * 5. Добавить в DeliveryOrder->getDeliveryOutputCreator(); Новый case с новой константой
 *
 * 6. Создать и настроить доставку в админ панели
 */
abstract class DeliveryOutputCreatorAbstract implements DeliveryOutputCreatorInterface
{
    /**
     * Модель города, из которого планируется отправка
     * @var Delivery
     */
    protected $deliveryModel;

    /**
     * Модель города, в который планируется доставка
     * @var City
     */
    protected $cityModelTo;

    /**
     * @var DeliveryOutputDefault|DeliveryOutputBoxberryPickpoint
     */
    protected $deliveryOutput;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * Нужно игнорировать параметр "Бесплатно от" при расчете цены доставки
     * Например из за "Крупногабаритного" товара в корзине
     * @var bool
     */
    protected $needSkipPriceFreeFrom;

    /**
     * Информация по доставке. Например ответ от запроса по API от Почты россии
     * @var mixed|array|null
     */
    protected $externalDeliveryInfo;

    /**
     * @param Delivery $deliveryModel Модель города, из которого планируется отправка
     * @param City $cityModelTo
     * @param Cart|null $cart
     */
    public function __construct(Delivery $deliveryModel, City $cityModelTo, Cart $cart = null)
    {
        $this->deliveryModel = $deliveryModel;
        $this->cityModelTo = $cityModelTo;

        if ($cart === null) {
            $this->cart = new Cart();
        } else {
            $this->cart = $cart;
        }
    }

    /**
     * @return DeliveryOutputDefault
     * @throws NeedUnsetDeliveryModelException
     */
    public function create()
    {
        $this->deliveryOutput = $this->createNewDeliveryOutputObject();

        try {
            $this->fillRequiredParams();

            if (!$this->deliveryOutput->isDisable()) {
                $this->calculateExternalDeliveryInfo();
                $this->fillParamsIfNotDisabled();
                $this->checkParams();
            }
        } catch (DeliveryCreateException $e) {
            $this->deliveryOutput->setError(true);
            $this->deliveryOutput->setErrorDescription($e->getMessageForUser() ?? DeliveryOutputDefault::DEFAULT_ERROR_DESCRIPTION);
            Yii::error("Ошибка при заполнении объека доставки. {$e->getMessage()}");
        } catch (NeedUnsetDeliveryModelException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->deliveryOutput->setError(true);
            $this->deliveryOutput->setErrorDescription(DeliveryOutputDefault::DEFAULT_ERROR_DESCRIPTION);
            Yii::error(self::class . " Непредвиденная ошибка. {$e->getMessage()}");
        }

        return $this->deliveryOutput;
    }

    /**
     * @return DeliveryOutputDefault
     */
    protected function createNewDeliveryOutputObject()
    {
        return new DeliveryOutputDefault();
    }

    /**
     * Заполнение обязательных для вывода карточки доставки параметров
     */
    protected function fillRequiredParams()
    {
        $this->fillId();
        $this->fillSort();
        $this->fillName();
        $this->fillDescription();
        $this->fillPriceMin();
        $this->fillPriceFreeFrom();
    }

    /**
     * Заполнение параметров, которые требуются, если доставка все еще не "disabled"
     */
    protected function fillParamsIfNotDisabled()
    {
        $this->fillMarkup();
        $this->fillPrice();
        $this->fillTimeInterval();
        $this->fillDeliveryDate();
    }

    /**
     * Метод для вызова других методов, которые проверяют какие либо уже заполненые данные
     *
     * @throws NeedUnsetDeliveryModelException
     */
    protected function checkParams()
    {
        $this->checkPriceMin();
        $this->checkFreePriceFrom();
        $this->addMarkupToPrice();
    }

    /**
     * Получение информации о стоимости и времени доставки из внешних источников (например API или другой модуль)
     * и сохранение в переменную $this->externalDeliveryInfo для дальнейшего использования
     *
     * @throws DeliveryCreateException
     * @throws NeedUnsetDeliveryModelException
     * @throws Exception
     */
    protected abstract function calculateExternalDeliveryInfo();

    /**
     * Конечная стоимость доставки после всех расчетов (форматированная строка). Вид: "200 руб"
     */
    protected abstract function fillPrice();

    /**
     * Время доставки в виде "1-2 дня"
     */
    protected abstract function fillTimeInterval();

    /**
     * Предполагаемая дата доставки. Рассчитывается исходя из текущего дня и времени доставки
     * Формат: 22.01.2024
     */
    protected abstract function fillDeliveryDate();

    /**
     * Заполнение ID модели (Берется из БД из таблицы Delivery из колонки id)
     */
    protected function fillId()
    {
        $this->deliveryOutput->setId($this->deliveryModel->id);
    }

    /**
     * Заполенине числа для сортировки
     */
    protected function fillSort()
    {
        $this->deliveryOutput->setSort($this->deliveryModel->sort);
    }

    /**
     * Заполнение "наименования доставки"
     */
    protected function fillName()
    {
        $this->deliveryOutput->setName($this->deliveryModel->name);
    }

    /**
     * Заполенине "Описания доставки"
     */
    protected function fillDescription()
    {
        $this->deliveryOutput->setDescription($this->deliveryModel->description);
    }

    /**
     * Заполнение "бесплатно от"
     */
    protected function fillPriceFreeFrom()
    {
        $this->deliveryOutput->setPriceFreeFrom($this->deliveryModel->price_free_from);
    }

    /**
     * Заполнение "наценки (число)"
     */
    protected function fillMarkup()
    {
        $this->deliveryOutput->setMarkup($this->deliveryModel->markup);
    }

    /**
     * Заполнение "Минимальной цены, при которой доставка будет показана пользователю"
     */
    protected function fillPriceMin()
    {
        $this->deliveryOutput->setPriceMin($this->deliveryModel->min);
    }

    /**
     * Добавляет наценку к рассчитанной заранее цене доставки
     */
    protected function addMarkupToPrice()
    {
        if (!$this->deliveryModel->markup || !$this->deliveryModel->markup_type) {
            return;
        }

        $deliveryPrice = $this->deliveryOutput->getPrice();
        if (isset($deliveryPrice) && $deliveryPrice > 0) {
            switch ($this->deliveryModel->markup_type) {
                case Delivery::MARKUP_TYPE_FIXED:
                    $price = $deliveryPrice + $this->deliveryModel->markup;
                    break;
                case Delivery::MARKUP_TYPE_PERCENT:
                    $price = $deliveryPrice + round(($deliveryPrice / 100 * $this->deliveryModel->markup), 0);
                    break;
                default:
                    $price = $deliveryPrice;
            }

            $this->deliveryOutput->setPrice($price);
        }
    }

    /**
     * Проверка "Минимальной стоимости корзины для показа доставки пользователю"
     *
     * Проверка нужно показать или скрыть доставку от пользователя в зависимости от текущей стоимости корзины
     *
     * @throws NeedUnsetDeliveryModelException
     */
    protected function checkPriceMin()
    {
        $cartSum = $this->cart->getSum();
        $minPriceToShowDelivery = $this->deliveryOutput->getPriceMin();

        if ($cartSum < $minPriceToShowDelivery) {
            throw new NeedUnsetDeliveryModelException("Сумма корзины {$cartSum}. Сумма, при которой можно вывести доставку \"{$this->deliveryOutput->getName()}\" равна $minPriceToShowDelivery}");
        }
    }

    /**
     * Проверка "Бесплатно от"
     *
     * Если стоимости корзины хватает, то доставка бесплатная
     */
    protected function checkFreePriceFrom()
    {
        $priceFreeFrom = $this->deliveryOutput->getPriceFreeFrom();

        if ($this->deliveryOutput->getPrice() == null || $priceFreeFrom === null || $this->needSkipPriceFreeFrom) {
            return;
        }

        $cartSum = $this->cart->getSum();
        if ($cartSum >= $priceFreeFrom) {
            $this->deliveryOutput->setPrice(0);
        }
    }
}