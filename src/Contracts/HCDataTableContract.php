<?php

namespace HoneyComb\Starter\Contracts;


/**
 * Interface HCDataTableContract
 * @package HoneyComb\Starter\Contracts
 */
interface HCDataTableContract
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @param string $title
     * @return HCDataTableContract
     */
    public function setTitle(string $title): HCDataTableContract;

    /**
     * @param string|null $source
     * @return HCDataTableContract
     */
    public function setSource(string $source = null): HCDataTableContract;

    /**
     * @param string $method
     * @return HCDataTableContract
     */
    public function setMethod(string $method): HCDataTableContract;

    /**
     * @param array $data
     * @return HCDataTableContract
     */
    public function setData(array $data): HCDataTableContract;

    /**
     * @param string $field
     * @param string|null $label
     * @param callable|null $callable
     * @return HCDataTableContract
     */
    public function addHeader(string $field, string $label = null, callable $callable = null): HCDataTableContract;

    /**
     * @param string $key
     * @param string|null $source
     * @return array
     */
    public function getDefaultStructure(string $key, string $source = null): array;

    /**
     * @return array
     */
    public function toArray(): array;
}