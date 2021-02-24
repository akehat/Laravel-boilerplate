<?php

namespace App\Http\Livewire;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Campaigns;
// use App\Domains\Auth\Models\Campaigns;
use Spatie\QueryBuilder\QueryBuilderRequest;

/**
 * Class UsersTable.
 */
class CampaignsTable extends TableComponent
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
       return Campaigns::query();
        

    
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
            Column::make(__('Slug'), 'cause_slug')
                ->searchable()
                ->sortable(),
            Column::make(__('Subdomain'), 'subdomain')
                ->searchable()
                ->sortable(),
                Column::make(__('Cause ID'), 'cause_id')
                ->searchable()
                ->sortable(),
            Column::make(__('Actions'))
                ->format(function (Campaigns $model) {
                    return view('campaigns.actions', ['model' => $model]);
                }),
        ];
    }
}
