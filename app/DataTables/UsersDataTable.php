<?php

namespace App\DataTables;

use App\User;
use App\Division;
use App\UserGroup;
use App\General;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

use Carbon\Carbon;

use Auth;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $user = new EloquentDataTable($query);

        return $user
        ->addIndexColumn()
        ->editColumn('division', function ($user) {

            if ($user->division) {
                $division = json_decode($user->division);
            }

            $query = Division::OfId(explode(',', $division->id))->pluck('name')->toArray();

            return ucwords(implode(', ', $query));

        })
        ->editColumn('group_id', function ($user) {

            if ($user->group_id) {
                $group_id = json_decode($user->group_id);
            }

            $query = UserGroup::find($user->group_id);

            return ucwords($query->name);

        })
        ->editColumn('created_at', function ($user) {
            return $user->created_at ? with(new Carbon($user->created_at))->format('m/d/Y') : '';
        })
        ->addColumn('action', function($user) {

            $html = '<div class="btn-group">';

            if (General::page_access(Auth::user()->group_id, 'user', 'alter')) {
                $html .= '<button id="edit" data-callback="dataTable" data-type="put" data-url="'.url('users/'.$user->id).'" type="button" class="btn btn-default"><i class="feather feather-edit-2"></i></button>';
            }

            if (General::page_access(Auth::user()->group_id, 'user', 'drop')) {
                $html .= '<button id="delete" data-callback="dataTable" data-type="delete" data-delete-type="swal" data-url="'.url('users/'.$user->id).'" type="button" class="btn btn-default"><i class="feather feather-trash-2"></i></button>';
            }

            $html .= '</div>';

            return $html;

        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return User::query();
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
            'division',
            'group_id',
            'name',
            'email',
            'username',
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
        return 'users_' . time();
    }
}
