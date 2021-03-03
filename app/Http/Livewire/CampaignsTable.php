<?php

namespace App\Http\Livewire;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Campaigns;
use App\Models\Donations;
use App\Models\DonationsArchive;
use Spatie\QueryBuilder\QueryBuilderRequest;

/**
 * Class CampaignsTable.
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
    // public function openModal(){
    //  $this->emit('show');
    // }

    /**
     * @param  string  $status
     */
    public function mount($status = 'active'): void
    {
        // echo $status;die('fds');

        $this->status = $status;
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        if($this->status != 'all'){
              return Campaigns::query()
           ->where('status','=',$this->status);
        }else{
            return Campaigns::query();
        }
      
  
       // 
        

    
    }
     public function store($id){
      
  
        $campaigns = Campaigns::find($id);
       
        $getDonations = Donations::where('cause_id', '=', $campaigns->cause_id)->first();
         
        $donations = Donations::find($getDonations->id);
   
  
        $data = array(
        
         "subdomain"=>$donations->subdomain,
            "cause_name"=>$donations->cause_name,
            "cause_slug"=>$donations->cause_slug,
            "cause_id"=>$donations->cause_id,
            "created at (EST)"=>$donations->created_at,
            "donor_first_name"=>$donations->donor_first_name,
            "donor_full_name"=>$donations->donor_full_name,
            "donor_last_name"=>$donations->donor_last_name,
            "donor_email"=>$donations->donor_email,
            "donor_phone"=>$donations->donor_phone,
            "donor_street"=>$donations->donor_street,
            "donor_city"=>$donations->donor_city,
            "donor_state"=>$donations->donor_state,
            "donor_zip"=>$donations->donor_zip,
            "status"=>$donations->status,
            "captured"=>$donations->captured,
            "amount"=>$donations->amount,
            "currency"=>$donations->currency,
            "source"=>$donations->source,
            "anonymous"=>$donations->anonymous,
            "additional_info"=>$donations->additional_info,
            "team"=>$donations->team,
            "affiliate"=>$donations->affiliate,
            "converted_amount"=>$donations->converted_amount,
            "converted_currency"=>$donations->converted_currency,
            "fee"=>$donations->fee,
            "fee_currency"=>$donations->fee_currency,
            "net"=>$donations->net,
            "net_currency"=>$donations->net_currency,
            "donor_dedication"=>$donations->donor_dedication,
            "donation_id"=>$donations->donation_id,
            "charge_id"=>$donations->charge_id,

        );

        if ($data) { 
            // $getDonations=Donations::where('donation_id', '=',$donations->donation_id)->first();
            // if ($getDonations === null) {
                $DonationsArchive = DonationsArchive::create($data); //create DonationsArchive
                $campaigns->status = '2';
                $campaigns->save(); 
               
            // }
           
        }

        
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
                    return view('campaigns.actions', ['donations' => $model]);
                }),
        ];
    }
}
