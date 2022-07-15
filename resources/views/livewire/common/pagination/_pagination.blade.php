<div id="pageUser" class="title-approve">
    <div class="row px-2">
        <div class="col-md-6 mb-3">
            <div class="form-group filter-pagination mb-0">
               <span>
                <label>Hiển thị</label>
                    <select class="form-control" id="boxpagination" wire:model.lazy="perPage" wire:ignore>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
               </span>
               <span>
                    @php
                    $start = ($paginator->currentPage() - 1) * $paginator->perPage() + 1;
                    if($paginator->total()==0) $start = 0;
                    $end = ($paginator->currentPage() < $paginator->lastPage()) ? $start + $paginator->perPage() - 1 : $paginator->total();
                @endphp

                {{ __('pagination.total_record', [
                    'start' => $start,
                    'end' => $end,
                    'total' => $paginator->total()
                ]) }}
                </span>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            {{ $paginator->appends($_GET)->onEachSide(1)->links('vendor.livewire.bootstrap') }}
        </div>
    </div>
</div>
