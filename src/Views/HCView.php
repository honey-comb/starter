<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Views;

use HoneyComb\Starter\Contracts\HCDataTableContract;
use HoneyComb\Starter\Contracts\HCViewContract;

/**
 * Class HCView
 * @package HoneyComb\Starter\Views
 */
class HCView implements HCViewContract
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * HCView constructor.
     * @param string $key
     * @param string|null $label
     */
    public function __construct(string $key, string $label = null)
    {
        $this->data = $this->getDefaultStructure($key, $label);
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->data['key'];
    }

    /**
     * @param string $key
     * @return HCViewContract
     */
    public function setKey(string $key): HCViewContract
    {
        $this->data['key'] = $key;

        return $this;
    }

    /**
     * @param string|null $label
     * @return HCViewContract
     */
    public function setLabel(string $label = null): HCViewContract
    {
        $this->data['label'] = $label;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return HCViewContract
     */
    public function addConfig(string $key, $value): HCViewContract
    {
        $this->data['config'][$key] = $value;

        return $this;
    }

    /**
     * @param HCViewContract $view
     * @return HCViewContract
     */
    public function addView(HCViewContract $view): HCViewContract
    {
        $this->data['views'][$view->getKey()] = $view->toArray();

        return $this;
    }

    /**
     * @param HCDataTableContract $dataTable
     * @return HCViewContract
     */
    public function addDataTable(HCDataTableContract $dataTable): HCViewContract
    {
        $this->data['data_tables'][$dataTable->getKey()] = $dataTable->toArray();

        return $this;
    }


    /**
     * @param string $permission
     * @return HCViewContract
     */
    public function addPermission(string $permission): HCViewContract
    {
        $this->data['permissions'][] = $permission;

        return $this;
    }

    /**
     * @param array $permissions
     * @return HCViewContract
     */
    public function setPermissions(array $permissions): HCViewContract
    {
        $this->data['permissions'] = $permissions;

        return $this;
    }

    /**
     * @param string $key
     * @param string|null $label
     * @return array
     */
    public function getDefaultStructure(string $key, string $label = null): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'views' => [],
            'data_tables' => [],
            'permissions' => [],
            'config' => [],
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
