<?php

namespace App\Http\Livewire;

use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class translations extends PowerGridComponent
{
    use ActionButton;
    
    // public $model;

    // public function __construct(){
    //     $this->model = Translation::query()->get();
    // }

// public function construct(val){
    //     $this->model = Translation::where('lang', $val)->get();
    //     // dd($this->model);
    //     return $this->dataSource();
    // }

    // public function changeModel($val){
    //     return $this->model->where('lang', $val);
    // }

        public function dataSource(): array
        {
            // if (!empty($val)) {
                $model = Translation::query()->get();
            // }else{
            // dd($this->model);
        //  print_r($this->model);
            return PowerGrid::eloquent($model)
                ->addColumn('id')
                ->addColumn('lang')
                ->addColumn('lang_key')
                ->addColumn('lang_value')
                ->addColumn('created_at')
                ->addColumn('created_at_formatted', function(Translation $model) {
                    return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
                })
                ->make();
        }

    public function setUp()
    {
        $this->showCheckBox()
            ->showPerPage()
            // ->showRecordCount('short')
            // ->makeInputSelect(Translation::all(), 'name', 'group_id', ['live_search' => true ,'class' => ''])
            ->showSearchInput();
    }


    public function columns(): array
    {
        return [
            Column::add()
                ->title(__('ID'))
                ->field('id')
                ->searchable()
                ->editOnClick()
                ->sortable(),

            Column::add()
                ->title(__('lang'))
                ->field('lang')
                ->searchable()
                ->editOnClick()
                ->sortable(),

                Column::add()
                ->title(__('lang key'))
                ->field('lang_key')
                ->searchable()
                ->editOnClick()
                ->sortable(),

                Column::add()
                ->title(__('lang value'))
                ->field('lang_value')
                ->searchable()
                ->editOnClick()
                ->sortable(),


            Column::add()
                ->title(__('Created at'))
                ->field('created_at')
                ->hidden(),

            Column::add()
                ->title(__('Created at'))
                ->field('created_at_formatted')
                ->makeInputDatePicker('created_at')
                ->searchable(),
            
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable this section only when you have defined routes for these actions.
    |
    */

    
    // public function actions(): array
    // {
    //    return [
    //        Button::add('edit')
    //            ->caption(__('Edit'))
    //            ->class('bg-indigo-500 text-white')
    //            ->route('translation.edit', ['translation' => 'id']),

    //        Button::add('destroy')
    //            ->caption(__('Delete'))
    //            ->class('bg-red-500 text-white')
    //            ->route('translation.destroy', ['translation' => 'id'])
    //            ->method('delete')
    //     ];
    // }
    

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable this section to use editOnClick() or toggleable() methods
    |
    */

    
    public function update(array $data ): bool
    {
       try {
           $updated = Translation::query()->find($data['id'])->update([
                $data['field'] => $data['value']
           ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status, string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field' => __('Custom Field updated successfully!'),
            ],
            "error" => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field' => __('Error updating custom field.'),
            ]
        ];

        return ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);
    }
    
    public function langFilter(int $id){
     
    }

}
