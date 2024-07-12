<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use App\Helpers\CustomerSync;
 
class SyncCustomerData extends Command
{
    protected $signature = 'sync:customer-data';
 
    protected $description = 'Sync customer data from API to database';
 
    protected $customerSync;
 
    public function __construct(CustomerSync $customerSync)
    {
        parent::__construct();
        $this->customerSync = $customerSync;
    }
 
    public function handle()
    {
        $this->info('Starting customer data sync.');
 
        $this->customerSync->syncCustomers();
 
        $this->info('Customer data sync completed.');
    }
}