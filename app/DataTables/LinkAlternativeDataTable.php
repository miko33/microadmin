<?php

namespace App\DataTables;

use App\Game;
use App\LinkAlternativeInfo;
use App\General;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

use Carbon\Carbon;

use Auth;

class LinkAlternativeDataTable extends DataTable
{
    
    public function dataTable($query)
    {
        $linkalternative = new EloquentDataTable($query);
        return $linkalternative
        ->addIndexColumn()
        ->editColumn('created_at', function ($linkalternative) {
            return $linkalternative->created_at ? with(new Carbon($linkalternative->created_at))->format('m/d/Y') : '';
        })
        ->addColumn('action', function($linkalternative) {

            $html = '<div class="btn-group">';

            if (General::page_access(Auth::user()->group_id, 'linkalternatives', 'alter')) {
                $html .= '<button id="linkalternative_customize" data-url="'.url('linkalternatives/'.$linkalternative->hostname).'" type="button" class="btn btn-default"><i class="feather feather-edit-2"></i></button>';
            }

            if (General::page_access(Auth::user()->group_id, 'linkalternatives', 'drop')) {
                $html .= '<button id="delete" data-callback="dataTable" data-type="delete" data-url="'.url('linkalternatives/delete/'.$linkalternative->hostname).'" type="button" class="btn btn-default"><i class="feather feather-trash-2"></i></button>';
            }

            $html .= '</div>';

            return $html;
        });
    }
    
    public function query()
    {
        return $this->game_id ? LinkAlternativeInfo::OfGame([$this->game_id]) : LinkAlternativeInfo::query();
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
        return 'linkalternatives_' . time();
    }
}
