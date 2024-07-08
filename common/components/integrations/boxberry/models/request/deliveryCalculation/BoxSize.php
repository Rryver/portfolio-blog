<?php

namespace common\components\integrations\boxberry\models\request\deliveryCalculation;

use common\components\integrations\common\CommonRequestObject;

class BoxSize extends CommonRequestObject
{
    /**
     * Вес, граммы
     * @var int
     */
    private $weight;

    /**
     * Ширина, см
     * @var int|null
     */
    private $width;

    /**
     * Высота, см
     * @var int|null
     */
    private $height;

    /**
     * Длина, см
     * @var int|null
     */
    private $depth;


    /**
     * BoxSize constructor.
     * @param int $weight
     * @param int|null $width
     * @param int|null $height
     * @param int|null $depth
     * @param array $config
     */
    public function __construct(int $weight,
                                ?int $width = null,
                                ?int $height = null,
                                ?int $depth = null,
                                $config = [])
    {
        $this->weight = $weight;
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
        
        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'Weight' => 'weight',
            'Width' => 'width',
            'Height' => 'height',
            'Depth' => 'depth',
        ];
    }

    
    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     */
    public function setWidth(?int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     */
    public function setHeight(?int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int|null
     */
    public function getDepth(): ?int
    {
        return $this->depth;
    }

    /**
     * @param int|null $depth
     */
    public function setDepth(?int $depth): void
    {
        $this->depth = $depth;
    }
    
    
}