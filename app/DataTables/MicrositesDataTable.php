<?php

namespace App\DataTables;

use App\Game;
use App\MicrositeInfo;
use App\General;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

use Carbon\Carbon;

use Auth;

class MicrositesDataTable extends DataTable
{
    
    public function dataTable($query)
    {
        $microsite = new EloquentDataTable($query);
        return $microsite
        ->addIndexColumn()
        ->editColumn('created_at', function ($microsite) {
            return $microsite->created_at ? with(new Carbon($microsite->created_at))->format('m/d/Y') : '';
        })
        ->addColumn('action', function($microsite) {

            $html = '<div class="btn-group">';

            if (General::page_access(Auth::user()->group_id, 'microsite', 'alter')) {
                $html .= '<button id="microsite_customize" data-url="'.url('microsites/'.$microsite->hostname).'" type="button" class="btn btn-default"><i class="feather feather-edit-2"></i></button>';
            }

            if (General::page_access(Auth::user()->group_id, 'microsite', 'drop')) {
                $html .= '<button id="delete" data-callback="dataTable" data-type="delete" data-url="'.url('microsites/delete/'.$microsite->hostname).'" type="button" class="btn btn-default"><i class="feather feather-trash-2"></i></button>';
            }

            $html .= '</div>';

            return $html;
        });
    }
    
    public function query()
    {
        return $this->game_id ? MicrositeInfo::OfGame([$this->game_id]) : MicrositeInfo::query();
    }
    
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addColumnBefore([
                        'defaultContent' => '',
                        'data'           => 'DT_Row_Index',
                        'name'           => 'DT_Row_Index',
                        'title'          => 'No.',
                        'render'         => null,
                        'orderable'      => false,
                        'searchable'     => false,
                        'exportable'     => false,
                        'printable'      => true,
                        'footer'         => '',
                    ])
                    ->addAction();
    }

    protected function getColumns()
    {
        return [
            'hostname',
            'home_title',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'microsites_' . time();
    }
}
