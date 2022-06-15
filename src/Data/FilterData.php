<?php
namespace App\Data;

class FilterData
{
    /**
     * @var ?string
     */
    public ?string $name = null;

    /**
     * @var ?string
     */
    public ?string $place = null;
    
    /**
     * @var ?integer
     */
    public ?int $priority = null;

    /**
     * @var datetime
     */
    public $beginDate = null;

    /**
     * @var datetime
     */
    public $endDate = null;
}