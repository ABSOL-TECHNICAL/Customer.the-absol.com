<?php
 
namespace App\DataTransferObjects;
 
/**
 * Data Transfer Object for Customer Sync API
 */
class CustomerSyncApi
{
    /**
     * @param string $account_number
     * @param string $cust_account_id
     * @param string $customer_status
     * @param string $customer_last_update
     * @param string|null $attribute5
     */
    public function __construct(
        public readonly string $account_number,
        public readonly string $cust_account_id,
        public readonly string $customer_status,
        public readonly string $customer_last_update,
        public readonly ?string $attribute5
    ) {
    }
 
    /**
     * Create an instance from an associative array.
     *
     * @param array $row
     * @return self
     * @throws \InvalidArgumentException
     */
    public static function fromRow(array $row): self
    {
        if (!isset($row['ACCOUNT_NUMBER'], $row['CUST_ACCOUNT_ID'], $row['STATUS'], $row['LAST_UPDATE_DATE'])) {
            throw new \InvalidArgumentException('Missing required fields in row');
        }
 
        return new self(
            $row['ACCOUNT_NUMBER'],
            $row['CUST_ACCOUNT_ID'],
            $row['STATUS'],
            $row['LAST_UPDATE_DATE'],
            $row['ATTRIBUTE5'] ?? null
        );
    }
}
 
 