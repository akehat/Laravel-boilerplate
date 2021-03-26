<x-utils.link class="btn btn-info btn-sm" :href="route('admin.donations.show', $donations->cause_id)" :text="__('Donations')" />
<a target="_blank" class="btn btn-info btn-sm" href="{{ $donations->google_sheet_url}}">Google Sheet</a>

<button type="button"  <?php if($donations->status =='archived'){ ?> disabled <?php   } ?> <?php if ($donations->status == '2'){ ?> class="btn btn-warning btn-sm" <?php   } else {?> class="btn btn-info btn-sm" <?php } ?>data-toggle="modal" data-target="#exampleModal">
	@if($donations->status == '2') {{ 'Archived' }} @else {{ 'Archive'}} @endif
</button>
    <div class="dropdown d-inline-block">
            <a class="btn btn-sm btn-secondary dropdown-toggle" id="moreMenuLink" href="#" role="button" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
               @if($donations->status == '1') {{ 'Active' }} @else {{ 'Inactive'}} @endif
            </a>

            <div class="dropdown-menu" aria-labelledby="moreMenuLink">
            	 <x-utils.form-button
                        :action="route('admin.campaigns.status', [$donations, 1])"
                        method="patch"
                        name="confirm-item"
                        button-class="dropdown-item">
                        @lang('Active')
                    </x-utils.form-button>
                    <x-utils.form-button
                        :action="route('admin.campaigns.status', [$donations, 0])"
                        method="patch"
                        name="confirm-item"
                        button-class="dropdown-item">
                        @lang('Inactive')
                    </x-utils.form-button>
             
            </div>
        </div>

<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         Do you want to archive this campaign ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" wire:click.prevent="store({{ $donations->id }})" data-dismiss="modal" class="btn btn-primary ">Yes</button>
      </div>
    </div>
  </div>
</div>





