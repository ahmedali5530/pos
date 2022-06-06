<?php


namespace App\Core\Dto\Controller\Api\Admin\Setting;


use App\Core\Dto\Common\Setting\SettingDto;

class SettingListResponseDto
{
    /**
     * @var SettingDto[]
     */
    private $list = [];

    public static function createFromList($list): self
    {
        $dto = new self();
        foreach($list as $item){
            $dto->list[] = SettingDto::createFromSetting($item);
        }

        return $dto;
    }

    /**
     * @return SettingDto[]
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param SettingDto[] $list
     */
    public function setList(array $list): void
    {
        $this->list = $list;
    }
}