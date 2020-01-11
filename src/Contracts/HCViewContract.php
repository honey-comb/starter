<?php

namespace HoneyComb\Starter\Contracts;


/**
 * Interface HCViewContract
 * @package HoneyComb\Starter\Contracts
 */
interface HCViewContract
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @param string $key
     * @return HCViewContract
     */
    public function setKey(string $key): HCViewContract;

    /**
     * @param string|null $label
     * @return HCViewContract
     */
    public function setLabel(string $label = null): HCViewContract;

    /**
     * @param string $key
     * @param mixed $value
     * @return HCViewContract
     */
    public function addConfig(string $key, $value): HCViewContract;

    /**
     * @param HCViewContract $view
     * @return HCViewContract
     */
    public function addView(HCViewContract $view): HCViewContract;

    /**
     * @param HCDataTableContract $dataTable
     * @return HCViewContract
     */
    public function addDataTable(HCDataTableContract $dataTable): HCViewContract;

    /**
     * @param string $permission
     * @return HCViewContract
     */
    public function addPermission(string $permission): HCViewContract;

    /**
     * @param array $permissions
     * @return HCViewContract
     */
    public function setPermissions(array $permissions): HCViewContract;

    /**
     * @param string $key
     * @param string|null $label
     * @return array
     */
    public function getDefaultStructure(string $key, string $label = null): array;

    /**
     * @return array
     */
    public function toArray(): array;
}