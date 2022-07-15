<?php

namespace App\Http\Livewire\Base;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\TrimAndNullEmptyStrings;
abstract class BaseLive extends Component
{
	use WithPagination;
    use TrimAndNullEmptyStrings;

	public $deleteId;
    public $reset = false;
    public $searchTerm;

    public $perPage = 25;
    protected  static function paginationView()
    {
        return 'livewire.common.pagination._pagination';
    }
    public function deleteId($id){

        $this->deleteId=$id;
    }
    public function levelClicked(){

    }
    public function resetSearch(){
        $this->reset = true;

    }
    public function updatingSearchTerm() {
        $this->resetPage();
    }
    public function updatingSearchCategory() {
        $this->resetPage();
    }
    public function updatingStore(){
        // dd($this->checkEditPermission);
    }
    public function updatingSetDate() {
        $this->resetPage();
    }
    public function updatingPerPage() {
        $this->resetPage();
    }

    public function updatingSearchName() {
        $this->resetPage();
    }

    public function updatingSearchType() {
        $this->resetPage();
    }

    public function updatingSearchFund() {
        $this->resetPage();
    }

    public function updatingFromDate() {
        $this->resetPage();
    }

    public function updatingToDate() {
        $this->resetPage();
    }
    
    public function updatingSearch() {
        $this->resetPage();
    }
}
