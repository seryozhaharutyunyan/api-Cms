<?php
namespace App\Model\Setting;

use Engine\Model;

class SettingRepository extends Model
{
    public function getSettings(): array
    {
        $sql = $this->queryBuilder->select()
            ->from('setting')
            ->orderBy('id', 'ASC')
            ->sql();

        return $this->db->setAll($sql);
    }


    /**
     * @param $kayField
     * @return object|array|null
     */
    public function getSettingValue($kayField): object|array|null
    {
        $sql=$this->queryBuilder
            ->select('value')
            ->from('setting')
            ->where('key_field', $kayField)
            ->sql();

        $query= $this->db->set($sql, $this->queryBuilder->values);

        return $query ?? null;
    }
}