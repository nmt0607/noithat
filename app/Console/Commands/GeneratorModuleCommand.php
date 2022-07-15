<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
class GeneratorModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string $name : model
     */
    protected $signature = 'GeneratorModuleCommand {name} {generateName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $baseModel = 'baseModel';
    protected $baseView = 'baseView';
    protected $baseController = 'baseController';
    protected $baseControlleLivewire = 'baseControlleLivewire';
    protected $baseViewLiveWire = 'baseViewLiveWire';
    protected $baseExport = 'baseExport';
    
    protected $modeLang = 'vi'; // vi or en
    protected $hasShow = false; // true or false
    protected $hasDeleteAll = false; // true or false

    protected $baseNamespaceController = 'App\Http\Controllers\Admin\Test';

    protected $countColumnInputViewLivewire = '2'; // 2

    protected $search = '$this->search';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('GeneratorModuleCommand' . $this->arguments()['name']);
        if($this->arguments()['generateName']){
            switch ($this->arguments()['generateName']) {
                case 'm':
                    //generateModel
                    $this->generateModel();
                    break;
                case 'r':
                    //generate url router
                    $this->generateRouter();
                    break;
                case 'c':
                    //generate controller
                    $this->generateController();
                    break;
                case 'v':
                    //generate view
                    $this->generateView();
                    break;   
                case 'cl':
                    //generate livewire (controller)
                    $this->generateControllerLiveWire();
                    break;    
                case 'vl':
                    //generate livewire (view)
                    $this->generateViewLiveWire();
                    break;    
                case 'e':
                    //generate export 
                    $this->generateExport();
                    break;     
                default:
                    $this->info('Invalid generate action');         
            }
        }
        else {
            //generateModel
            $this->generateModel();
            //generate url router
            $this->generateRouter();
            //generate controller
            $this->generateController();
            //generate view
            $this->generateView();
            //generate livewire (controller)
            $this->generateControllerLiveWire();
            //generate livewire (view)
            $this->generateViewLiveWire();
            //generate export 
            $this->generateExport();
        }
    }

//generateModel start

    function generateModel(){
        $file = ucfirst($this->arguments()['name']).'.php';
        $pathStorage = storage_path('');
        $pathStorage = str_replace('/storage','',$pathStorage);
        $pathStorage = str_replace('storage','',$pathStorage);
        $destinationPath=$pathStorage."/app/Models/";

        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        $oldContent = file_get_contents($destinationPath.$file);
        $name = '$searchableByWhere';
        if(!strpos($oldContent,$name)){
            $content = file_get_contents($this->getStub($this->baseModel));
            $content = $this->buildContentModel($content);
            File::put($destinationPath.$file,$content);
        };
        
        $this->info('Model Generated');
    }
    public function buildContentModel($content){
        $array = [
            '{{ modelName }}' => ucfirst($this->arguments()['name']),
            '{{ contentModel }}' => $this->getContentModel(),
        ];

        return str_replace(array_keys($array), array_values($array), $content);
    }

    public function getContentModel(){
        $str = '';
        $NTab = 1;
        $str .= '// create, update column'.PHP_EOL;
        $str .= $this->getNTab($NTab).'protected $fillable = [];'.PHP_EOL.PHP_EOL;
        $str .= $this->getNTab($NTab).'//query search'.PHP_EOL;
        $str .= $this->getNTab($NTab).'protected $searchableByOrWhere = [];'.PHP_EOL;
        $str .= $this->getNTab($NTab).'public function getSearchableByOrWhere(){'.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'return $this->searchableByOrWhere;'.PHP_EOL;
        $str .= $this->getNTab($NTab).'}'.PHP_EOL.PHP_EOL;
        $str .= $this->getNTab($NTab).'protected $searchableByWhere = [];'.PHP_EOL;
        $str .= $this->getNTab($NTab).'public function getSearchableByWhere(){'.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'return $this->searchableByWhere;'.PHP_EOL;
        $str .= $this->getNTab($NTab).'}'.PHP_EOL.PHP_EOL;
        $str .= $this->getNTab($NTab).'// column table'.PHP_EOL;
        $str .= $this->getNTab($NTab).'protected $columnTable = [];'.PHP_EOL;
        $str .= $this->getNTab($NTab).'public function getColumnTable(){'.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'return $this->columnTable;'.PHP_EOL;
        $str .= $this->getNTab($NTab).'}'.PHP_EOL.PHP_EOL;
        $str .= $this->getNTab($NTab).'//column sorting'.PHP_EOL;
        $str .= $this->getNTab($NTab).'protected $columnSortingTable = [];'.PHP_EOL;
        $str .= $this->getNTab($NTab).'public function getColumnSortingTable(){'.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'return $this->columnSortingTable;'.PHP_EOL;
        $str .= $this->getNTab($NTab).'}'.PHP_EOL.PHP_EOL;
        $str .= $this->getNTab($NTab).'//export'.PHP_EOL;
        $str .= $this->getNTab($NTab).'protected $columnExport = [];'.PHP_EOL;
        $str .= $this->getNTab($NTab).'public function  getColumnExport() {'.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'return $this->columnExport;'.PHP_EOL;
        $str .= $this->getNTab($NTab).'}'.PHP_EOL;
        return $str;
    }
//generateModel end





// generateRouter start
function generateRouter(){
    $file = 'web.php';
    $pathStorage = storage_path('');
    $pathStorage = str_replace('/storage','',$pathStorage);
    $pathStorage = str_replace('storage','',$pathStorage);
    $destinationPath=$pathStorage."/routes//";
    if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }

    $oldContent = file_get_contents($destinationPath.$file);
    $routeName = 'Route::get("/'.$this->arguments()['name'].'", "'.$this->baseNamespaceController.'\\'.ucfirst($this->arguments()['name']).'Controller@index")->name("admin.'.$this->arguments()['name'].'.index");'; 
    $controllerName = ucfirst($this->arguments()['name']).'Controller@index';
    if(!strpos($oldContent,$controllerName)){
        // dd('vào');
        $newContent = $oldContent.PHP_EOL.$routeName;
        File::put($destinationPath.$file,$newContent);
    };
    
    $this->info('Router Generated');
}




// generateRouter end
// generateController start
    function generateController(){
        $file = ucfirst($this->arguments()['name']) . 'Controller.php';;
        $pathStorage = storage_path('');
        $pathStorage = str_replace('/storage','',$pathStorage);
        $pathStorage = str_replace('storage','',$pathStorage);
        $destinationPath=$pathStorage."/".$this->baseNamespaceController."/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }

        $content = file_get_contents($this->getStub($this->baseController));
        $content = $this->buildContentController($content);

        File::put($destinationPath.$file,$content);


        $this->info('Controller Generated');
    }

    public function buildContentController($content){
        $array = [
            '{{ namespace }}' => $this->getDefaultNamespaceController($this->baseNamespaceController),
            '{{ name }}' => ucfirst($this->arguments()['name']).'Controller',
            '{{ useclasses }}' => $this->usedClassesController(),
            '{{ routeView }}' => "'".$this->routeView()."'",
        ];

        return str_replace(array_keys($array), array_values($array), $content);
    }

    protected function getDefaultNamespaceController($rootNamespace){
        return $rootNamespace;
    }
    protected function usedClassesController(){
        return 'use App\Http\Controllers\Controller;' . PHP_EOL . 'use Illuminate\Http\Request;' . PHP_EOL . 'use Illuminate\Http\Reponse;' . PHP_EOL.'use App\Model\\'.ucfirst($this->arguments()['name']).';';
    }
    protected function routeView(){
        return 'admin.'.$this->arguments()['name'].'.'.Str::snake($this->arguments()['name'], '-').'-list';
    }
// generateController end

// generateView start
    function generateView(){
        $file =  Str::snake($this->arguments()['name'], '-').'-list.blade.php';
        $pathStorage = storage_path('');
        $pathStorage = str_replace('/storage','',$pathStorage);
        $pathStorage = str_replace('storage','',$pathStorage);
        $destinationPath=$pathStorage."/resources/views/admin/".$this->arguments()['name'].'/';
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }

        $content = file_get_contents($this->getStub($this->baseView));
        $content = $this->buildView($content);

        File::put($destinationPath.$file,$content);


        $this->info('View Generated');
    }

    public function buildView($content){
        $array = [
            '{{ title }}' => ucfirst($this->arguments()['name']),
            '{{ routeView }}' => "'".$this->routeViewLivewire()."'",
        ];
        return str_replace(array_keys($array), array_values($array), $content);
    }
    protected function routeViewLivewire(){
        $name = $this->getArgumentsName($this->arguments()['name']);
        return 'admin.'.$name.'.'.Str::snake($this->arguments()['name'], '-').'-list';
    }
    protected function getArgumentsName($name){
        return Str::snake($name,'-');
    }
// generateView end



// generateControllerLiveWire start

    function generateControllerLiveWire(){
        $file =  Str::studly(Str::snake($this->arguments()['name'], '_'))."List.php";
        $pathStorage = storage_path('');
        $pathStorage = str_replace('/storage','',$pathStorage);
        $pathStorage = str_replace('storage','',$pathStorage);
        $destinationPath=$pathStorage."/App/Http/Livewire/Admin/".ucfirst($this->arguments()['name']). "/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }

        $content = file_get_contents($this->getStub($this->baseControlleLivewire));
        $content = $this->buildContentControllerLivewire($content);

        File::put($destinationPath.$file,$content);
        $this->info('Controller Livewire Generated');
    }

    public function buildContentControllerLivewire($content){
        $array = [
            '{{ namespace }}' => $this->getDefaultNamespace('app'),
            '{{ useclasses }}' => $this->usedClasses(),
            '{{ properties }}' => $this->buildProperties(),
            '{{ rules }}' => $this->getRules(),
            '{{ messages }}' => $this->getMessages(),
            '{{ searchVar }}' => $this->getSearchVar(),
            '{{ query }}' => $this->querySearchLiveWire(),
            '{{ blade }}' => $this->arguments()['name'].'.'.Str::snake($this->arguments()['name'], '-').'-list',
            '{{ resetProperties }}' => $this->getResetProperties(),
            '{{ storeData }}' => $this->getStoreDataLiveWire(),
            '{{ getDataEditToModal }}' => $this->getDataEditToModal(),
            '{{ getDataShowToModal }}' => $this->getDataShowToModal(),
            '{{ updateData }}' => $this->getUpdateDataLiveWire(),
            '{{ standardData }}' => $this->getStandardDataLiveWire(),
            '{{ destroyData }}' => $this->getDestroyDataLivewire(),
            '{{ resetSearch }}' => $this->getResetSearchLivewire(),
            '{{ export }}' => $this->getExportLivewire(),
            '{{ classNameLivewire }}' => Str::studly(Str::snake($this->arguments()['name'], '_')).'List',
            '{{ functionDeleteAll }}' => $this->getFunctionDeleteAll(),
        ];

        return str_replace(array_keys($array), array_values($array), $content);
    }
    protected function getDefaultNamespace($rootNamespace){
        return $rootNamespace . '\Http\Livewire\Admin\\'.ucfirst($this->arguments()['name']);
    }
    protected function usedClasses(){
        return 'use Livewire\Component;' . PHP_EOL .'use App\Http\Livewire\Base\BaseLive;'.PHP_EOL.'use App\\Models\\' . ucfirst($this->arguments()['name']).";" . PHP_EOL.'use Excel;'.PHP_EOL.'use App\\Exports\\'.ucfirst($this->arguments()['name']).'Export;'.PHP_EOL;
    }
    public function buildProperties(): string {
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getFillable();
        $str = '';
        $c = 1;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                if ($c == 1) {
                    $str .= 'public $' . $column . ';' . PHP_EOL;
                } else {
                    $str .= '    public $' . $column . ';' . PHP_EOL;
                }
                $c++;
            }
        }
        if($this->hasDeleteAll){
            $str .= PHP_EOL.$this->getNTab(1).'public $items = [];';
        }
        return $str;
    }
    public function getRules(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        $columns = $model->getFillable();
        $str = '';
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $str .= "        '" . $column . "' => 'required'," . PHP_EOL;
            }
        }
        return 'protected $rules = [' . PHP_EOL . $str  . '    ];' . PHP_EOL;
    }

    public function getMessages(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        $columns = $model->getFillable();
        $str = '';
        $textThe = $this->modeLang=='en'?'The ':'';
        $textRequired = $this->modeLang=='en'?" is required',":" bắt buộc',";
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $str .= "        '" . $column . ".required' => '".$textThe.$this->getColumnLiveWire($column).$textRequired. PHP_EOL;
            }
        }
        return 'protected $messages = [' . PHP_EOL . $str  . '    ];';
    }
    
    public function getSearchVar(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getSearchableByWhere();
        $str = '';
        $c = 0;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $column  = str_replace('-',' ',$column);
                $column  = str_replace('_',' ',$column);
                $column  = Str::title($column);
                $column  = str_replace(' ','',$column);
                if ($c) {
                    $str .= '    public $search' . $column . ';' . PHP_EOL;
                } else {
                    $str .= 'public $search' . $column . ';' . PHP_EOL;
                }
                $c++;
            }
        }
        return $str;      
    }
    public function querySearchLiveWire(){
        $class = 'App\\Models\\' . $this->arguments()['name'];
        $model = new $class;
        $columns = $model->getSearchableByOrWhere();
        $str = '$query = '. ucfirst($this->arguments()['name']).'::query();'.PHP_EOL;
        $i = 0;
        // search text
        $str .= '        if($this->search) {'.PHP_EOL;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at' && $column!='password') {
                if (!$i) {
                    $str .= '            $query = $query->where(function ($query) {'.PHP_EOL.$this->getNTab(4).'$query->where("'. $column . '", "like", "%".$this->search."%")';
                } else {
                    $str .= "->orWhere('" . $column . "', 'like', '%'.$this->search.'%')";
                }
                $i++;
            }
        }
        if($i){
            $str .= ';'.PHP_EOL.$this->getNTab(3).'});'.PHP_EOL;
        }
        $str .= '        }'.PHP_EOL.PHP_EOL;
        // search checkbox
        $columns = $model->getSearchableByWhere();
        $i = 0;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at' && $column!='password') {
                $columnSearch  = str_replace('-',' ',$column);
                $columnSearch  = str_replace('_',' ',$columnSearch);
                $columnSearch  = Str::title($columnSearch);
                $columnSearch  = 'search'.str_replace(' ','',$columnSearch);
                $str .= '        if($this->'.$columnSearch.') {'.PHP_EOL;
                $str .= '            $query->where("'.$column.'", "like", "%".$this->'.$columnSearch.'."%");'.PHP_EOL;
                $str .= '        }'.PHP_EOL;
                $i++;
            }
        }
        if($i){
            $str .= PHP_EOL;
        }
        $str .= $this->getNTab(2).'return $query;'; 
        return $str;
    }

    public function getResetProperties(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getFillable();
        $str = '';
        $i = 0;
        $NTab = 2;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                if (!$i) {
                    $str .= '$this->' . $column . ' = "";';
                } else {
                    $str .= PHP_EOL.$this->getNTab($NTab).'$this->' . $column . ' = "";';
                }
                $i++;
            }
        }
        $str .= PHP_EOL.$this->getNTab($NTab).'$this->resetValidation();';
        return $str;      
    }

    public function getStoreDataLiveWire(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getFillable();
        $str = '';
        $i = 0;
        $NTab = 3;
        $str .= ucfirst($this->arguments()['name']).'::create(['.PHP_EOL; 
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $str .= $this->getNTab($NTab+1).'"'.$column.'" => $this->'.$column.','.PHP_EOL;
            }
        }
        $str .= $this->getNTab($NTab).']);'.PHP_EOL; 
        return $str;   
    }

    public function getDataEditToModal(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getFillable();
        $str = '';
        $i = 0;
        $NTab = 2;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                if(!$i){
                    $str .= '$this->'.$column.' = $row["'.$column.'"];'.PHP_EOL;
                }
                else {
                    $str .= $this->getNTab($NTab).'$this->'.$column.' = $row["'.$column.'"];'.PHP_EOL;
                }
                $i++;
            }
        }
        return $str;     
    }

    public function getDataShowToModal(){
        if($this->hasShow){
            $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
            $model = new $class;
            if (!class_exists($class)){
                throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
            }
            $columns = $model->getFillable();
            $str = 'public function show($row){'.PHP_EOL;
            $NTab = 2;
            $str .= $this->getNTab($NTab)."$"."this->mode = 'show';".PHP_EOL;
            $str .= $this->getNTab($NTab)."$"."this->editId = $"."row['id'];".PHP_EOL;
            foreach ($columns as $column) {
                if ($column != 'created_at' && $column != 'updated_at') {
                    $str .= $this->getNTab($NTab).'$this->'.$column.' = $row["'.$column.'"];'.PHP_EOL;
                }
            }
            $str .= $this->getNTab($NTab-1).'}';
            return $str;     
        }
        return '';
    }

    public function getUpdateDataLiveWire(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getFillable();
        $str = '';
        $NTab = 3;
        $str .= ucfirst($this->arguments()['name']).'::where("id",$this->editId)->update(['.PHP_EOL; 
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $str .= $this->getNTab($NTab+1).'"'.$column.'" => $this->'.$column.','.PHP_EOL;
            }
        }
        $str .= $this->getNTab($NTab).']);'.PHP_EOL; 
        return $str;   
    }

    public function getStandardDataLiveWire(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getFillable();
        $str = '';
        $i = 0;
        $NTab = 2;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                if(!$i){
                    $str .= '$this->'.$column.' = trim($this->'.$column.');'.PHP_EOL;
                }
                else {
                    $str .= $this->getNTab($NTab).'$this->'.$column.' = trim($this->'.$column.');'.PHP_EOL;
                }
                $i++;
            }
        }
        return $str;  
    }


    public function getDestroyDataLivewire(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $str = '';
        $str .=  ucfirst($this->arguments()['name']).'::findorfail($this->deleteId)->delete();';
        return $str;
    }
    public function getResetSearchLivewire(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getSearchableByWhere();
        $str = '';
        $NTab = 2;
        $str .= '$this->search = "";';
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $column  = str_replace('-',' ',$column);
                $column  = str_replace('_',' ',$column);
                $column  = Str::title($column);
                $column  = str_replace(' ','',$column);

                $str .= PHP_EOL.$this->getNTab($NTab).'$this->search' . $column . ' = "";';
            }
        }
        return $str;  
    }

    public function getExportLivewire(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getSearchableByWhere();
        $str = 'return Excel::download(new '.ucfirst($this->arguments()['name']).'Export($this->key_name, $this->sortingName, $this->search';
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $column  = str_replace('-',' ',$column);
                $column  = str_replace('_',' ',$column);
                $column  = Str::title($column);
                $column  = str_replace(' ','',$column);

                $str .= ', $this->search' . $column;
            }
        }
        $str .= '), "'.ucfirst($this->arguments()['name']).'-export-".$today.".xlsx");';
        return $str;
    }
    public function getFunctionDeleteAll(){
        $NTab = 2;
        $str = 'public function deleteAll(){'.PHP_EOL;
        if($this->hasDeleteAll){
            $str .= $this->getNTab($NTab).'$query = $this->getQuery();'.PHP_EOL;
            $str .= $this->getNTab($NTab).'$itemIds = $query->whereIn("'.Str::snake($this->arguments()['name'], '-').'.id",$this->items)->pluck("id")->toArray();'.PHP_EOL;
            $str .= $this->getNTab($NTab).'$query = '.ucfirst($this->arguments()['name']).'::whereIn("'.Str::snake($this->arguments()['name'], '-').'.id",$itemIds)->delete();'.PHP_EOL;
            $str .= $this->getNTab($NTab).'$countDelete = count($itemIds);'.PHP_EOL;
            $str .= $this->getNTab($NTab).'$this->items = array_diff($this->items, $itemIds);'.PHP_EOL;
            $str .= $this->getNTab($NTab).'$this->dispatchBrowserEvent("show-toast", ["type" => "success", "message" => "Xóa thành công ".$countDelete." bản ghi."]);'.PHP_EOL;
            $str .= $this->getNTab($NTab-1).'}'.PHP_EOL;
            return $str;
        }
        return ;
    }
// generateControllerLiveWire end

// generateViewLiveWire start

    function generateViewLiveWire(){
        $file =  Str::snake($this->arguments()['name'], '-').'-list.blade.php';
        $pathStorage = storage_path('');
        $pathStorage = str_replace('/storage','',$pathStorage);
        $pathStorage = str_replace('storage','',$pathStorage);
        $destinationPath=$pathStorage."/resources/views/livewire/admin/".$this->arguments()['name'].'/';
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }

        $content = file_get_contents($this->getStub($this->baseViewLiveWire));
        $content = $this->buildViewLivewire($content);

        File::put($destinationPath.$file,$content);
        $this->info('View Livewire Generated');
    }

    public function buildViewLivewire($content){
        $array = [
            '{{ title }}' =>  Str::title(Str::snake(ucfirst($this->arguments()['name']),' ')),
            '{{ searchInput }}' =>  $this->getInputSearchLivewire(),
            '{{ columnHeadTable }}' => $this->getColumnHeadTableLivewire(),
            '{{ columnBodyTable }}' => $this->getColumnBodyTableLivewire(),
            '{{ modalBodyLivewire }}' => $this->getModalBodyLivewire(),
            '{{ showButton }}' => $this->getShowButton(),
            '{{ titleModal }}' => $this->getTitleModal(),
            '{{ modalButtonSave }}' => $this->getmodalButtonSave(),
            '{{ buttonDeleteAll }}' => $this->getButtonDeleteAll(),
            '{{ thDeleteAll }}' => $this->hasDeleteAll?'<th></th>':'',
            '{{ tdDeleteAll }}' => $this->hasDeleteAll?'<td><input type="checkbox" wire:model="items" value="{{$row->id}}"></td>':'',
        ];
        return str_replace(array_keys($array), array_values($array), $content);
    }
    public function getInputSearchLivewire(){
        $class = 'App\\Models\\' . $this->arguments()['name'];
        $model = new $class;
        $columnSearchOrWhere = $model->getSearchableByOrWhere();
        if(!count($columnSearchOrWhere)){
            $columns = $model->getSearchableByWhere();
        }
        else {
            $columnSearchOrWhere = [''];
            $columnSearchWhere = $model->getSearchableByWhere();
            $columns = array_unique(array_merge ($columnSearchOrWhere, $columnSearchWhere));
        }
        $countColumn = count($columns);
        $colNum = (int) 12/($this->countColumnInputViewLivewire);
        $str = '';
        $NTab = 4;
        for ($i = 0; $i < (int)($countColumn/$this->countColumnInputViewLivewire); $i++){
            $columnSearch  = str_replace('-',' ',$columns[2*$i]);
            $columnSearch  = str_replace('_',' ',$columnSearch);
            $columnSearch  = Str::title($columnSearch);
            $columnSearch  = 'search'.str_replace(' ','',$columnSearch);

            $str .= '<div class="form-group row">'.PHP_EOL;
            $str .= $this->getNTab($NTab).'<label for="'.($columns[2*$i]?$columns[2*$i]:'Search').'" class="col-1 col-form-label">'.$this->getColumnLiveWire($columns[2*$i]).'</label>'.PHP_EOL;
            $str .= $this->getNTab($NTab).'<div class="col-4">'.PHP_EOL;
            $str .= $this->getNTab($NTab+1).'<input wire:model.debounce.1000ms="'.$columnSearch.'" placeholder="'.$this->getColumnLiveWire($columns[2*$i]).'"type="text" class="form-control">'.PHP_EOL;
            $str .= $this->getNTab($NTab).'</div>'.PHP_EOL;

            $columnSearch  = str_replace('-',' ',$columns[2*$i+1]);
            $columnSearch  = str_replace('_',' ',$columnSearch);
            $columnSearch  = Str::title($columnSearch);
            $columnSearch  = 'search'.str_replace(' ','',$columnSearch);
           
            $str .= $this->getNTab($NTab).'<label for="'.$columns[2*$i+1].'" class="offset-1 col-1 col-form-label">'.$this->getColumnLiveWire($columns[2*$i+1]).'</label>'.PHP_EOL;
            $str .= $this->getNTab($NTab).'<div class="col-4">'.PHP_EOL;
            $str .= $this->getNTab($NTab+1).'<input wire:model.debounce.1000ms="'.$columnSearch.'" placeholder="'.$this->getColumnLiveWire($columns[2*$i+1]).'"type="text" class="form-control">'.PHP_EOL;
            $str .= $this->getNTab($NTab).'</div>'.PHP_EOL;
            $str .= $this->getNTab($NTab-1).'</div>'.PHP_EOL;
        }
        if($countColumn%$this->countColumnInputViewLivewire!=0){
            $columnSearch  = str_replace('-',' ',$columns[$countColumn-1]);
            $columnSearch  = str_replace('_',' ',$columnSearch);
            $columnSearch  = Str::title($columnSearch);
            $columnSearch  = 'search'.str_replace(' ','',$columnSearch);

            $str .= $this->getNTab($NTab-1).'<div class="form-group row">'.PHP_EOL;
            $str .= $this->getNTab($NTab).'<label for="'.$columns[$countColumn-1].'" class="col-1 col-form-label">'.$this->getColumnLiveWire($columns[$countColumn-1]).'</label>'.PHP_EOL;
            $str .= $this->getNTab($NTab).'<div class="col-4">'.PHP_EOL;
            $str .= $this->getNTab($NTab+1).'<input wire:model.debounce.1000ms="'.$columnSearch.'" placeholder="'.$this->getColumnLiveWire($columns[$countColumn-1]).'"type="text" class="form-control">'.PHP_EOL;
            $str .= $this->getNTab($NTab).'</div>'.PHP_EOL;
            $str .= $this->getNTab($NTab-1).'</div>'.PHP_EOL;
        }
        $str .= PHP_EOL;
        return $str;
    }
    public function getColumnHeadTableLivewire(){
        $class = 'App\\Models\\' . $this->arguments()['name'];
        $model = new $class;
        $columns = $model->getColumnTable();
        $columnsSorting = $model->getColumnSortingTable();
        $str = '';
        $NTab = 6;
        $i=0;
        foreach($columns as $key => $column){
            if ($column != 'created_at' && $column != 'updated_at') {
                $columnTable = $this->getColumnLiveWire($column);
                if(in_array($column,$columnsSorting)){
                    $str .= '<th class="{{$key_name=="'.$column.'"?($sortingName=="desc"?"sorting_desc":"sorting_asc"):"sorting"}}" wire:click="'.'sorting('."'".$column."'".')">'.$columnTable.'</th>'.PHP_EOL.$this->getNTab($NTab);
                }
                else {
                    $str .= '<th>'.$columnTable.'</th>'.PHP_EOL.$this->getNTab($NTab);
                }
                $i++;
            }
        }
        return $str;
    }
    public function getColumnBodyTableLivewire(){
        $class = 'App\\Models\\' . $this->arguments()['name'];
        $model = new $class;
        $columns = $model->getColumnTable();
        $columnsSearchByWhere = $model->getSearchableByWhere();
        $columnsSearchByOrWhere = $model->getSearchableByOrWhere();
        $str = '';
        $NTab = 7;
        $i=0;
        foreach($columns as $key => $column){
            if ($column != 'created_at' && $column != 'updated_at') {
                if(in_array($column,$columnsSearchByOrWhere)){
                    if(!$i) $str .= '<td>{!!boldTextSearchV2($row->'.$column.',$search)!!}</td>';
                    else $str .= PHP_EOL.$this->getNTab($NTab).'<td>{!!boldTextSearchV2($row->'.$column.',$search)!!}</td>';
                }
                elseif(in_array($column,$columnsSearchByWhere)){
                    $columnSearch  = str_replace('-',' ',$column);
                    $columnSearch  = str_replace('_',' ',$columnSearch);
                    $columnSearch  = Str::title($columnSearch);
                    $columnSearch  = 'search'.str_replace(' ','',$columnSearch);

                    if(!$i) $str .= '<td>{!!boldTextSearchV2($row->'.$column.',$'.$columnSearch.')!!}</td>';
                    else $str .= PHP_EOL.$this->getNTab($NTab).'<td>{!!boldTextSearchV2($row->'.$column.',$'.$columnSearch.')!!}</td>';
                }
                else {
                    if(!$i) $str .= '<td>{{$row->'.$column.'}}</td>';
                    else $str .= PHP_EOL.$this->getNTab($NTab).'<td>{{$row->'.$column.'}}</td>';
                }
                $i++;
            }
        }
        return $str;
    }
    public function getModalBodyLivewire(){
        $class = 'App\\Models\\' . $this->arguments()['name'];
        $model = new $class;
        $columns = $model->getFillable();
        $str = '';
        $NTab = 4;
        $i = 0;
        $str .= '<div class="modal-body">'.PHP_EOL;
        foreach($columns as $key => $column){
            if ($column != 'created_at' && $column != 'updated_at') {
                // else $str .= $this->getNTab($NTab).'<div class="modal-body">'.PHP_EOL;
                $str .= $this->getNTab($NTab+1).'<div class="form-group">'.PHP_EOL;
                $str .= $this->getNTab($NTab+2).'<label> '.$this->getColumnLiveWire($column).'(<span style="color:red">*</span>)</label>'.PHP_EOL;
                $str .= $this->getNTab($NTab+2).'<input type="text"  class="form-control" placeholder="'.$this->getColumnLiveWire($column).'" wire:model.defer="'.$column.'" '.($this->hasShow?'{{$mode=="show"?"disabled":""}}':'').'>'.PHP_EOL;
                $str .= $this->getNTab($NTab+2).'@error("'.$column.'")'.PHP_EOL;
                $str .= $this->getNTab($NTab+3).'@include("layouts.partials.text._error")'.PHP_EOL;
                $str .= $this->getNTab($NTab+2).'@enderror'.PHP_EOL;
                $str .= $this->getNTab($NTab+1).'</div>'.PHP_EOL;
                $i++;
            }
        }
        $str .= $this->getNTab($NTab).'</div>'.PHP_EOL;
        return $str;
    }



    public function getColumnLiveWire($column){
        if($this->modeLang=='en'){
            $column  = str_replace('-',' ',$column);
            $column  = str_replace('_',' ',$column);
            $column  = Str::title($column);
            return $column?Str::title(Str::snake(ucfirst($column),' ')):'Search';
        }
        else {
            if(!$column) return 'Search';
            $class = 'App\\Models\\' . $this->arguments()['name'];
            $model = new $class;
            $tranlate = $model->getTranslate();
            if(isset($tranlate[$column])){
                return $tranlate[$column];
            }
            else {
                $column  = str_replace('-',' ',$column);
                $column  = str_replace('_',' ',$column);
                $column  = Str::title($column);
                return Str::title(Str::snake(ucfirst($column),' '));
            }
        }
    }
    public function getNTab($number=1){
        $str = '';
        for($i = 0; $i < $number; $i++){
            $str.= '    ';
        }
        return $str;
    }
    public function getShowButton(){
        $str = '';
        $NTab = 8;
        if($this->hasShow){
            $str .=  '<button type="button" data-toggle="modal" data-target="#modelCreateEdit"  class="btn par6" title="show" wire:click="show({{$row}})">'.PHP_EOL;
            $str .= $this->getNTab($NTab+1).'<img src="/images/eye.svg" alt="Chi tiết">'.PHP_EOL;
            $str .= $this->getNTab($NTab).'</button>'.PHP_EOL;
            // dd($str);
            return $str;
        }
        return '';
    }
    public function getTitleModal(){
        if($this->hasShow){
            return '{{$this->mode=="create"?"Thêm mới":($this->mode=="update"?"Chỉnh sửa":"Chi tiết")}}';
        }
        else {
            return '{{$this->mode=="create"?"Thêm mới":"Chỉnh sửa"}}';
        }
    }

    public function getmodalButtonSave(){
        if($this->hasShow){
            return '@if($mode!="show") <button type="button" class="btn btn-primary" wire:click="saveData">Lưu</button> @endif';
        }
        return '<button type="button" class="btn btn-primary" wire:click="saveData">Lưu</button>';
    }

    public function getButtonDeleteAll(){
        if($this->hasDeleteAll){
            $NTab = 5;
            $str = '<div style="margin-left:5px;float: left;text-align: center;">'.PHP_EOL;
            $str .= $this->getNTab($NTab+1).'<button class ="btn btn-danger" data-toggle="modal" data-target="#modal-delete-all" {{(count($items))?"":"disabled"}}>'.PHP_EOL;
            $str .= $this->getNTab($NTab+2).'<i class="fa fa-trash"></i> Xóa tất cả'.PHP_EOL;
            $str .= $this->getNTab($NTab+1).'</button>'.PHP_EOL;
            $str .= $this->getNTab($NTab).'</div>';
            return $str;
        }
        return ;
    }
// generateViewLiveWire end




// generateExport start

    function generateExport(){
        $file =  ucfirst($this->arguments()['name']).'Export.php';
        $pathStorage = storage_path('');
        $pathStorage = str_replace('/storage','',$pathStorage);
        $pathStorage = str_replace('storage','',$pathStorage);
        $destinationPath=$pathStorage."/app/Exports/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }

        $content = file_get_contents($this->getStub($this->baseExport));
        $content = $this->buildExport($content);

        File::put($destinationPath.$file,$content);
        $this->info('Export Generated');
    }

    public function buildExport($content){
        $startCol = 'A';
        $startRow = '3';
        $arrayText = [
            'A1:F1' => 'Table '.ucfirst($this->arguments()['name']).' data',
            'A2:F2' => 'Chào các bạn',
        ];
        $array = [
            '{{ model }}' =>  "use App\Models\\".ucfirst($this->arguments()['name']).';',
            '{{ className }}' => ucfirst($this->arguments()['name']).'Export',
            '{{ properties }}' => $this->buildPropertiesExport(),
            '{{ constructData }}' => $this->getConstructData(),
            '{{ initDataContruct }}' => $this->getInitDataContruct(),
            '{{ queryExport }}' => $this->getQueryExport(),
            '{{ headingExport }}' => $this->getHeadingExport(),
            '{{ mapExport }}' => $this->getMapExport(),
            '{{ afterSheet }}' => $this->getAfterSheet($startCol, $startRow, $arrayText),
            '{{ strartRow }}' => '"'.$startCol.$startRow.'"',
        ];
        return str_replace(array_keys($array), array_values($array), $content);
    }

    public function buildPropertiesExport(): string {
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getSearchableByWhere();
        $str = 'protected $key_name;'.PHP_EOL.'    protected $sortingName;'.PHP_EOL;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $str .= '    protected $' . $column . ';' . PHP_EOL;
            }
        }
        return $str;
    }
    public function getConstructData(): string {
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getSearchableByWhere();
        $str = '$key_name, $sortingName, $search';
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $column  = str_replace('-',' ',$column);
                $column  = str_replace('_',' ',$column);
                $column  = Str::title($column);
                $column  = str_replace(' ','',$column);

                $str .= ', $search' . $column;
            }
        }
        return $str;
    }

    public function getInitDataContruct(): string {
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getSearchableByWhere();
        $NTab = 2;
        $str = '$this->key_name = trim($key_name);'.PHP_EOL.$this->getNTab($NTab).'$this->sortingName = trim($sortingName);'.PHP_EOL.$this->getNTab($NTab).'$this->search = trim($search);';
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $column  = str_replace('-',' ',$column);
                $column  = str_replace('_',' ',$column);
                $column  = Str::title($column);
                $column  = str_replace(' ','',$column);

                $str .= PHP_EOL.$this->getNTab($NTab).'$this->search' . $column.'= trim($search'.$column.');';
            }
        }
        return $str;
    }


    public function getQueryExport(){
        $class = 'App\\Models\\' . $this->arguments()['name'];
        $model = new $class;
        $columns = $model->getSearchableByOrWhere();
        $str = '$query = '. ucfirst($this->arguments()['name']).'::query();'.PHP_EOL;
        $i = 0;
        $NTab = 2;
        // search text
        $str .= $this->getNTab($NTab).'if($this->search) {'.PHP_EOL;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at' && $column!='password') {
                if (!$i) {
                    $str .= $this->getNTab($NTab+1).'$query = $query->where(function ($query) {'.PHP_EOL.$this->getNTab($NTab+2).'$query->where("'. $column . '", "like", "%".$this->search."%")';
                } else {
                    $str .= "->orWhere('" . $column . "', 'like', '%'.$this->search.'%')";
                }
            }
            $i++;
        }
        if($i){
            $str .= ';'.PHP_EOL.$this->getNTab($NTab+1).'});'.PHP_EOL;
        }
        $str .= $this->getNTab($NTab).'}'.PHP_EOL.PHP_EOL;
        // search checkbox
        $columns = $model->getSearchableByWhere();
        $i = 0;
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at' && $column!='password') {
                $columnSearch  = str_replace('-',' ',$column);
                $columnSearch  = str_replace('_',' ',$columnSearch);
                $columnSearch  = Str::title($columnSearch);
                $columnSearch  = 'search'.str_replace(' ','',$columnSearch);
                $str .= $this->getNTab($NTab).'if($this->'.$columnSearch.') {'.PHP_EOL;
                $str .= $this->getNTab($NTab+1).'$query->where("'.$column.'", "like", "%".$this->'.$columnSearch.'."%");'.PHP_EOL;
                $str .= $this->getNTab($NTab).'}'.PHP_EOL;
            }
            $i++;
        }
        if($i){
            $str .= PHP_EOL;
        }
        $str .= $this->getNTab($NTab).'$query = $query->orderBy($this->key_name,$this->sortingName)->get();';
        return $str;
    }

    public function getHeadingExport(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getColumnExport();
        $NTab = 3;
        $str = '"STT",';
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $str .= PHP_EOL.$this->getNTab($NTab).'"'.$this->getColumnLiveWire($column).'",';
            }
        }
        return $str;
    }

    public function getMapExport(){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getColumnExport();
        $NTab = 3;
        $str = '++$this->stt,';
        foreach ($columns as $column) {
            if ($column != 'created_at' && $column != 'updated_at') {
                $str .= PHP_EOL.$this->getNTab($NTab).'$data->'.$column.',';
            }
        }
        return $str;
    }

    public function getAfterSheet($startCol, $startRow, $arrayText=[]){
        $class = 'App\\Models\\' . ucfirst($this->arguments()['name']);
        $model = new $class;
        if (!class_exists($class)){
            throw new \Exception('Model Not Found. Please Check if Model Exists at -'.$class);
        }
        $columns = $model->getColumnExport();
        $NTab = 4;
        $countColumns = count($columns)+1;
        $start = $startCol.$startRow;
        //merge column
        $arrayTextKey = array_keys($arrayText);
        $str = '$event->sheet->getDelegate()'.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'->setMergeCells(['.PHP_EOL;
        foreach($arrayTextKey as $value){
            if(strpos($value,':')!== false){
                $str .= $this->getNTab($NTab+2).'"'.$value.'",'.PHP_EOL;
            }
        }
        $str .= $this->getNTab($NTab+1).']);'.PHP_EOL;
        foreach($arrayText as $key => $value){
            if(strpos($key,':')!== false){
                $key = substr($key,0,strpos($key,':'));
            }
            $str .= $this->getNTab($NTab).'$event->sheet->getDelegate()->setCellValue("'.$key.'", "'.$value.'");'.PHP_EOL;
        }
        // default style
        $str .= PHP_EOL.$this->getNTab($NTab).'$event->sheet->getStyle("'.$start.':'.$this->getColumnIndex($countColumns,$startCol).$startRow.'")->getAlignment()->setWrapText(true);'.PHP_EOL;
        $str .= $this->getNTab($NTab).'$active_sheet = $event->sheet->getDelegate();'.PHP_EOL;
        $str .= $this->getNTab($NTab).'$active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);'.PHP_EOL;
        $str .= $this->getNTab($NTab).'$active_sheet->getParent()->getDefaultStyle()->getAlignment()->applyFromArray('.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'array("horizontal" => "left")'.PHP_EOL;
        $str .= $this->getNTab($NTab).');'.PHP_EOL.PHP_EOL;
        // title
        $str .= $this->getNTab($NTab).'$arrayAlphabet = ['.PHP_EOL;
        $str .= $this->getNTab($NTab+1);
        for($i = 2; $i <= $countColumns; $i++){
            $str .= '"'.$this->getColumnIndex($i,$startCol).'", ';
        }
        $str .= PHP_EOL.$this->getNTab($NTab).'];'.PHP_EOL;
        $str .= $this->getNTab($NTab).'foreach ($arrayAlphabet as $alphabet) {'.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'$event->sheet->getColumnDimension($alphabet)->setWidth(30);'.PHP_EOL;
        $str .= $this->getNTab($NTab).'}'.PHP_EOL;
        $str .= $this->getNTab($NTab).'$event->sheet->getColumnDimension("'.$startCol.'")->setWidth(5);'.PHP_EOL;
        $str .= $this->getNTab($NTab).'// title'.PHP_EOL;
        $str .= $this->getNTab($NTab).'$cellRange = "'.$start.':'.$this->getColumnIndex($countColumns,$startCol).$startRow.'";'.PHP_EOL;
        $str .= $this->getNTab($NTab).'$active_sheet->getStyle($cellRange)->applyFromArray($default_font_style_title);'.PHP_EOL;
        $str .= $this->getNTab($NTab).'$active_sheet->getStyle($cellRange)->getAlignment()->applyFromArray('.PHP_EOL;
        $str .= $this->getNTab($NTab+1).'array("horizontal" => "center", "vertical"=>"center")'.PHP_EOL;
        $str .= $this->getNTab($NTab).');'.PHP_EOL.PHP_EOL;
        $str .= $this->getNTab($NTab).'if($this->countRow) $active_sheet->getStyle("'.$startCol.($startRow+1).':'.$this->getColumnIndex($countColumns,$startCol).'".($this->countRow+'.$startRow.'))->applyFromArray($default_font_style2);'.PHP_EOL.PHP_EOL;
        // style array text
        $str .= $this->getNTab($NTab).'//style array text'.PHP_EOL;
        foreach($arrayTextKey as $value){
            $str .= $this->getNTab($NTab).'$active_sheet->getStyle("'.$value.'")->getAlignment()->applyFromArray('.PHP_EOL;
            $str .= $this->getNTab($NTab+1).'array("horizontal" => "center", "vertical"=>"center")'.PHP_EOL;
            $str .= $this->getNTab($NTab).');'.PHP_EOL;
            $str .= $this->getNTab($NTab).'$active_sheet->getStyle("'.$value.'")->applyFromArray($default_font_style_title2);'.PHP_EOL;
        }
        return $str;
    }
    public function getColumnIndex($number,$startCol='A'){
        $numberColumnStart = Coordinate::columnIndexFromString($startCol);
        return Coordinate::stringFromColumnIndex($number+$numberColumnStart-1);
    }
// generateExport end
    protected function getStub($stubName){
        if (file_exists(base_path() . '/stubs/base/' . $stubName . '.stub')) {
            return base_path() . '/stubs/base/' . $stubName . '.stub';
        }
    }
}
