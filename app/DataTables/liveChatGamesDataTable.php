<?php

namespace App\DataTables;

use App\Game;
use App\General;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

use Carbon\Carbon;

use Auth;

class liveChatGamesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $game = new EloquentDataTable($query);

        return $game
        ->addIndexColumn()
        ->editColumn('created_at', function ($game) {
            return $game->created_at ? with(new Carbon($game->created_at))->format('m/d/Y') : '';
        })
        ->addColumn('action', function($game) {

            $html = '<div class="btn-group">';

            if (General::page_access(Auth::user()->group_id, 'livechats', 'view')) {
                $html .= '<a href="'.url('livechats?game='.$game->id).'" id="viewLiveChats" data-callback="dataTable" data-type="put" data-url="'.url('viewLiveChats/'.$game->id).'" type="button" class="btn btn-sm btn-primary">View Live Chats</a>';
            }

            $html .= '</div>';

            return $html;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Game $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->division ? Game::OfDivision([$this->division]) : Game::query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
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
                    ->addAction(['width' => '80px']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name',
            'url',
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
        return 'games_' . time();
    }
}
