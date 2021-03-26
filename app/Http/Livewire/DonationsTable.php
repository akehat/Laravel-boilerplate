<?php

namespace App\Http\Livewire;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Campaigns;
use App\Models\Donations;
use Spatie\QueryBuilder\QueryBuilderRequest;
use Rappasoft\LaravelLivewireTables\Exports\Export;

use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UsersTable.
 */
class DonationsTable extends TableComponent
{
    use HtmlComponents;

    /**
     * @var string
     */

    public $sortField = 'cause_name';

    public $cause_id;

    /**
     * @var string
     */
    public $status;

    /**
     * @var array
     */

    public $exports = ['csv'];

    public $exportFileName = 'donations-table';

    protected $options = [
        'bootstrap.container' => false,
        'bootstrap.classes.table' => 'table table-striped',
    ];

    /**
     * @param  string  $status
     */
    public function mount($status = 'active',$cid=''): void
    {
        $this->status = $status;
        $this->cause_id = $cid;
     }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
         return Donations::query()
        ->where('cause_id','=',$this->cause_id);
  

       // return Donations::query();
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            
            Column::make(__('Name'), 'cause_name')->searchable()->sortable(),
            Column::make(__('Slug'), 'cause_slug')->searchable()->sortable(),
            Column::make(__('Subdomain'), 'subdomain')->exportOnly(),
            Column::make(__('Cause ID'), 'cause_id')->exportOnly(),
            Column::make(__('Name'), 'donor_full_name')->searchable()->sortable(),
            Column::make(__('Donor Email'), 'donor_email')->searchable()->sortable(),
            Column::make(__('Donor Phone'), 'donor_phone')->exportOnly(), 
            Column::make(__('Donor Street'), 'donor_street')->exportOnly(), 
            Column::make(__('Donor City'), 'donor_city')->exportOnly(), 
            Column::make(__('Donor State'), 'donor_state')->exportOnly(), 
            Column::make(__('Donor Zip'), 'donor_zip')->exportOnly(), 
            Column::make(__('Captured'), 'captured')->exportOnly(), 
            Column::make(__('Currency'), 'currency')->exportOnly(), 
            Column::make(__('Source'), 'source')->exportOnly(), 
            Column::make(__('Anonymous'), 'anonymous')->exportOnly(), 
            Column::make(__('Additional Info'), 'additional_info')->exportOnly(), 
            Column::make(__('Team'), 'team')->exportOnly(), 
            Column::make(__('Affiliate'), 'affiliate')->exportOnly(), 
            Column::make(__('Converted Aamount'), 'converted_amount')->exportOnly(), 
            Column::make(__('Converted Currency'), 'converted_currency')->exportOnly(), 
            Column::make(__('Fee'), 'fee')->exportOnly(), 
            Column::make(__('Fee Currency'), 'fee_currency')->exportOnly(), 
            Column::make(__('Net'), 'net')->exportOnly(), 
            Column::make(__('Net Currency'), 'net_currency')->exportOnly(), 
            Column::make(__('Donor Dedication'), 'donor_dedication')->exportOnly(), 
            Column::make(__('Charge Id'), 'charge_id')->exportOnly(),
            Column::make(__('Created At'), 'created_at')->exportOnly(),
            Column::make(__('Updated At'), 'updated_at')->exportOnly(),
            Column::make(__('Amount'), 'amount')->searchable()->sortable(),  
            Column::make(__('Status'), 'status')->searchable()->sortable(),           
            
        ];
    }

}
