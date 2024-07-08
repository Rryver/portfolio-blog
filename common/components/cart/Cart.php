<?php


namespace common\components\cart;


use yii\base\Component;

class Cart extends Component
{
    /**
     * Сумма корзины, в рублях
     * @var float
     */
    private $sum;

    /**
     * Вес корзины, в граммах
     * @var float
     */
    private $weight;


    /**
     * @param float $sum
     * @param float $weight
     * @param array $config
     */
    public function __construct(float $sum = 0.0, float $weight = 0.0, $config = [])
    {
        $this->sum = $sum;
        $this->weight = $weight;

        parent::__construct($config);
    }

    /**
     * Метод получения корзины для текущего пользователя
     * Если пользователь есть в БД, то корзина хранится в БД
     * Если пользователя нет, то корзина хранится в сессии.
     *
     * Если корзины нет, то создается новая пустая корзина
     *
     * @return Cart
     */
    public static function getCurrentUserCart()
    {
        //TODO Добавить логику получения корзины текущего пользователя

        return new Cart();
    }

    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     */
    public function setSum(float $sum): void
    {
        $this->sum = $sum;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

}