<?php


namespace Evrinoma\EximBundle\Vuetable;


use Evrinoma\UtilsBundle\Manager\BaseEntityInterface;

class AdaptorVuetable
{
//region SECTION: Fields
    private $manager;
    private $dto;
    private $data;
//endregion Fields

//region SECTION: Constructor
    /**
     * AdaptorVuetable constructor.
     *
     * @param $manager
     * @param $dto
     * @param $data
     */
    public function __construct(BaseEntityInterface $manager, VuetableInterface $dto, $data)
    {
         $this->manager = $manager;
         $this->dto = $dto;
         $this->data = $data;
    }
//endregion Constructor


//region SECTION: Public
    /**
     * @return array
     */
    public function toVuetable()
    {
        $total = $this->manager->getCount($this->dto);

        $vuetableData = $this->dto ? [
            'total'         => $total,
            'per_page'      => $this->dto->getPerPage(),
            'current_page'  => $this->dto->getPage(),
            'last_page'     => ($this->dto->getPerPage() !== 0) ? intdiv($total, $this->dto->getPerPage()) + (($total % $this->dto->getPerPage()) !== 0 ? 1 : 0) : 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'from'          => $this->dto->getPage() * $this->dto->getPerPage() - $this->dto->getPerPage() + 1,
            'to'            => $this->dto->getPage() * $this->dto->getPerPage(),
            'data'          => $this->data,
        ] : [
            'total'         => 0,
            'per_page'      => 0,
            'current_page'  => 0,
            'last_page'     => 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'from'          => 0,
            'to'            => 0,
            'data'          => 0,
        ];

        return $vuetableData;
    }
//endregion Public
}