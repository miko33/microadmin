<?php

namespace App\DataTables;

use App\Game;
use App\LiveChatInfo;
use App\General;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

use Carbon\Carbon;

use Auth;

class LiveChatDataTable extends DataTable
{
    
    public function dataTable($query)
    {
        $livechat = new EloquentDataTable($query);
        return $livechat
        ->addIndexColumn()
        ->editColumn('created_at', function ($livechat) {
            return $livechat->created_at ? with(new Carbon($livechat->created_at))->format('m/d/Y') : '';
        })
        ->addColumn('action', function($livechat) {

            $html = '<div class="btn-group">';

            if (General::page_access(Auth::user()->group_id, 'livechats', 'alter')) {
                $html .= '<button id="livechat_customize" data-url="'.url('livechats/'.$livechat->hostname).'" type="button" class="btn btn-default"><i class="feather feather-edit-2"></i></button>';
            }

            if (General::page_access(Auth::user()->group_id, 'livechats', 'drop')) {
                $html .= '<button id="delete" data-callback="dataTable" data-type="delete" data-url="'.url('livechats/delete/'.$livechat->hostname).'" type="button" class="btn btn-default"><i class="feather feather-trash-2"></i></button>';
            }

            $html .= '</div>';

            return $html;
        });
    }
    
    public function query()
    {
        return $this->game_id ? LiveChatInfo::OfGame([$this->game_id]) : LiveChatInfo::query();
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
        return 'livechats_' . time();
    }
}
