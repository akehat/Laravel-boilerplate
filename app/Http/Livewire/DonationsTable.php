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
            
           
            Column::make(__('subdomain'), 'subdomain')->exportOnly(),
            Column::make(__('cause_name'), 'cause_name')->searchable()->sortable(),
            Column::make(__('cause_slug'), 'cause_slug')->searchable()->sortable(),
            Column::make(__('cause_id'), 'cause_id')->exportOnly(),
            Column::make(__('created at (EST)'), 'created_at')->exportOnly(),
            Column::make(__('donor_name'), 'donor_full_name')->searchable()->sortable(),
            Column::make(__('donor_email'), 'donor_email')->searchable()->sortable(),
            Column::make(__('donor_phone'), 'donor_phone')->exportOnly(), 
            Column::make(__('donor_street'), 'donor_street')->exportOnly(), 
            Column::make(__('donor_city'), 'donor_city')->exportOnly(), 
            Column::make(__('donor_state'), 'donor_state')->exportOnly(), 
            Column::make(__('donor_zip'), 'donor_zip')->exportOnly(), 
            Column::make(__('status'), 'status')->searchable()->sortable(),           
            Column::make(__('captured'), 'captured')->exportOnly(), 
            Column::make(__('amount'), 'amount')->searchable()->sortable(),
            Column::make(__('currency'), 'currency')->exportOnly(), 
            Column::make(__('source'), 'source')->exportOnly(), 
            Column::make(__('anonymous'), 'anonymous')->exportOnly(), 
            Column::make(__('additional_info'), 'additional_info')->exportOnly(), 
            Column::make(__('team'), 'team')->exportOnly(), 
            Column::make(__('affiliate'), 'affiliate')->exportOnly(), 
            Column::make(__('converted_amount'), 'converted_amount')->exportOnly(), 
            Column::make(__('converted_currency'), 'converted_currency')->exportOnly(), 
            Column::make(__('fee'), 'fee')->exportOnly(), 
            Column::make(__('fee_currency'), 'fee_currency')->exportOnly(), 
            Column::make(__('net'), 'net')->exportOnly(), 
            Column::make(__('net_currency'), 'net_currency')->exportOnly(), 
            Column::make(__('donor_dedication'), 'donor_dedication')->exportOnly(), 
            Column::make(__('charge_id'), 'charge_id')->exportOnly(),
            Column::make(__('updated_at'), 'updated_at')->exportOnly(),
              
            
        ];
    }

}
