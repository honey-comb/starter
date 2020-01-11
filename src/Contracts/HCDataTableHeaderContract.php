<?php

namespace HoneyComb\Starter\Contracts;


/**
 * Interface HCDataTableHeaderContract
 * @package HoneyComb\Starter\Contracts
 */
interface HCDataTableHeaderContract
{
    /**
     * @param string|null $label
     * @return HCDataTableHeaderContract
     */
    public function setLabel(string $label = null): HCDataTableHeaderContract;

    /**
     * @param bool $status
     * @return HCDataTableHeaderContract
     */
    public function isSortable(bool $status = true): HCDataTableHeaderContract;

    /**
     * @param string $key
     * @param mixed $value
     * @return HCDataTableHeaderContract
     */
    public function addProperty(string $key, $value): HCDataTableHeaderContract;

    /**
     * @return HCDataTableHeaderContract
     */
    public function text(): HCDataTableHeaderContract;

    /**
     * @return HCDataTableHeaderContract
     */
    public function html(): HCDataTableHeaderContract;

    /**
     * @return HCDataTableHeaderContract
     */
    public function checkbox(): HCDataTableHeaderContract;

    /**
     * @param bool $external
     * @return HCDataTableHeaderContract
     */
    public function url(bool $external = true): HCDataTableHeaderContract;

    /**
     * @param string $field
     * @param string|null $label
     * @return array
     */
    public function getDefaultStructure(string $field, string $label = null): array;

    /**
     * @return array
     */
    public function toArray(): array;
}