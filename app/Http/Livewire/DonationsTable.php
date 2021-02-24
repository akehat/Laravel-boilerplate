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
// use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * @var string
     */
    public $status;

    /**
     * @var array
     */

    public $exports = ['csv', 'xls'];

    public $exportFileName = 'users-table.csv';

    protected $options = [
        'bootstrap.container' => false,
        'bootstrap.classes.table' => 'table table-striped',
    ];

    /**
     * @param  string  $status
     */
    public function mount($status = 'active'): void
    {
        $this->status = $status;
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
       return Donations::query();
        

    
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            
            Column::make(__('Name'), 'cause_name')
                ->searchable()
                ->sortable(),
            Column::make(__('SLug'), 'cause_slug')
                ->searchable()
                ->sortable(),
            Column::make(__('Subdomain'), 'subdomain')
                ->searchable()
                ->sortable(),
            Column::make(__('Cause ID'), 'cause_id')
                ->searchable()
                ->sortable(),
            // Column::make(__('Donor First Name'), 'donor_first_name')
            //     ->searchable()
            //     ->sortable(),
                
            // Column::make(__('Donor Last Name'), 'donor_last_name')
            //     ->searchable()
            //     ->sortable(),   
            // Column::make(__('Donor Email'), 'donor_email')
            //     ->searchable()
            //     ->sortable(), 
            Column::make(__('Amount'), 'amount')
                ->searchable()
                ->sortable(),  
            Column::make(__('Status'), 'status')
                ->searchable()
                ->sortable(),           
            
        ];
    }


    public function exportOnly()
    {
        // die('iam here');
        // return Storage::disk('exports')->download('export.csv');
    }
}
