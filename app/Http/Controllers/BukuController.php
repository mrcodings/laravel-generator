<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Repositories\BukuRepository;
use Flash;
use Illuminate\Http\Request;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use function redirect;
use function route;
use function view;
use \Input;
use \Html;
use \Form;

class BukuController extends AppBaseController
{
    /** @var  BukuRepository */
    private $bukuRepository;

    public function __construct(BukuRepository $bukuRepo)
    {
        $this->bukuRepository = $bukuRepo;
    }

    /**
     * Display a listing of the Buku.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
//        $this->bukuRepository->pushCriteria(new RequestCriteria($request));
//        $bukus = $this->bukuRepository->all();
//
//        return view('bukus.index')
//            ->with('bukus', $bukus);
		$grid = new Grid(
			(new GridConfig)
				->setDataProvider(
					//new EloquentDataProvider(User::query())
					new EloquentDataProvider(
						(new Buku)->newQuery()
					)
				)
				->setName('buku_grid')
				->setPageSize(15)
				->setColumns([
					(new FieldConfig)
						->setName('id')
						->setLabel('ID')
						->setSortable(true)
						->setSorting(Grid::SORT_ASC)
					,
					(new FieldConfig)
						->setName('judul')
						->setLabel('Judul')
						->setCallback(function ($val) {
							return "<span class='glyphicon glyphicon-user'></span>{$val}";
						})
						->setSortable(true)
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('deskripsi')
						->setLabel('Deskripsi')
						->setSortable(true)
						->setCallback(function ($val) {
							$icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
							return
								'<small>'
								. $icon
								. $val
								. '</small>';
						})
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('isi')
						->setLabel('Isi')
						->setSortable(true)
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('created_at')
						->setLabel('Created At')
						->setSortable(true)
					,
					(new FieldConfig)
						->setName('updated_at')
						->setLabel('Updated At')
						->setSortable(true)
					,
					(new FieldConfig)
						->setName('id')
                        ->setLabel('Action')
                        ->setSortable(false)
                        ->setCallback(function ($val) {
                            return
//								Form::open(['route' => ['bukus.destroy', $val], 'method' => 'delete'])
                                '<small>'
                                . HTML::decode(HTML::linkRoute('bukus.show', '<span class="glyphicon glyphicon-eye-open"></span>', [$val]))
								. HTML::decode(HTML::LinkRoute('bukus.edit', '<span class="glyphicon glyphicon-pencil"></span>', [$val]))
								. HTML::decode(HTML::LinkRoute('bukus.destroy', '<span class="glyphicon glyphicon-trash"></span>', [$val], array('id' => 'delete')))
//								. Form::button('<span class="glyphicon glyphicon-trash"></span>', ['type' => 'submit', 'class' => 'btn btn-xs', 'onclick' => "return confirm('Are you sure?')"])
                                . '</small>';
//								.Form::close();
                        })
                    ,
				])
				->setComponents([
					(new THead)
						->setComponents([
							(new ColumnHeadersRow),
							(new FiltersRow)
								->addComponents([
									(new RenderFunc(function () {
										return HTML::style('js/daterangepicker/daterangepicker-bs3.css')
										. HTML::script('js/moment/moment-with-locales.js')
										. HTML::script('js/daterangepicker/daterangepicker.js')
										. "<style>
												.daterangepicker td.available.active,
												.daterangepicker li.active,
												.daterangepicker li:hover {
													color:black !important;
													font-weight: bold;
												}
										   </style>";
									}))
								])
							,
							(new OneCellRow)
								->setRenderSection(RenderableRegistry::SECTION_END)
								->setComponents([
									new RecordsPerPage,
									new ColumnsHider,
									(new CsvExport)
										->setFileName('my_report' . date('Y-m-d'))
									,
									new ExcelExport(),
									(new HtmlTag)
										->setContent('<span class="glyphicon glyphicon-refresh"></span> Filter')
										->setTagName('button')
										->setRenderSection(RenderableRegistry::SECTION_END)
										->setAttributes([
											'class' => 'btn btn-success btn-sm'
										])
								])

						])
					,
				])
		);
		$grid = $grid->render();
		return view('bukus.index', compact('grid'));
    }

    /**
     * Show the form for creating a new Buku.
     *
     * @return Response
     */
    public function create()
    {
        return view('bukus.create');
    }

    /**
     * Store a newly created Buku in storage.
     *
     * @param CreateBukuRequest $request
     *
     * @return Response
     */
    public function store(CreateBukuRequest $request)
    {
        $input = $request->all();

        $buku = $this->bukuRepository->create($input);

        Flash::success('Buku saved successfully.');

        return redirect(route('bukus.index'));
    }

    /**
     * Display the specified Buku.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $buku = $this->bukuRepository->findWithoutFail($id);

        if (empty($buku)) {
            Flash::error('Buku not found');

            return redirect(route('bukus.index'));
        }

        return view('bukus.show')->with('buku', $buku);
    }

    /**
     * Show the form for editing the specified Buku.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $buku = $this->bukuRepository->findWithoutFail($id);

        if (empty($buku)) {
            Flash::error('Buku not found');

            return redirect(route('bukus.index'));
        }

        return view('bukus.edit')->with('buku', $buku);
    }

    /**
     * Update the specified Buku in storage.
     *
     * @param  int              $id
     * @param UpdateBukuRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBukuRequest $request)
    {
        $buku = $this->bukuRepository->findWithoutFail($id);

        if (empty($buku)) {
            Flash::error('Buku not found');

            return redirect(route('bukus.index'));
        }

        $buku = $this->bukuRepository->update($request->all(), $id);

        Flash::success('Buku updated successfully.');

        return redirect(route('bukus.index'));
    }

    /**
     * Remove the specified Buku from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $buku = $this->bukuRepository->findWithoutFail($id);

        if (empty($buku)) {
            Flash::error('Buku not found');

            return redirect(route('bukus.index'));
        }

        $this->bukuRepository->delete($id);

        Flash::success('Buku deleted successfully.');

        return redirect(route('bukus.index'));
    }
}
