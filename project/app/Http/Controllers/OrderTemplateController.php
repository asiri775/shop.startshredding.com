<?php

namespace App\Http\Controllers;

use App\AccountManager;
use App\Order;
use App\OrderedProducts;
use App\OrderTemplate;
use App\OrderTemplateItem;
use App\Product;
use App\Clients;
use App\Category;
use App\Models\EmailSubject;
use App\Models\EmailTemplate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Mail\ScheduleOrderPlaced;
use Redirect;
use Illuminate\Support\Facades\DB;

class OrderTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['templateForm'])) {
            $query = "";
            if (isset($_GET['template']) && $_GET['template'] != "") {
                $query .= " and order_templates.name like '%" . $_GET['template'] . "%'";
            }

            if (isset($_GET['status']) && $_GET['status'] != "") {
                $query .= " and  order_templates.is_active='" . $_GET['status'] . "'";
            }

            if (isset($_GET['repeat']) && $_GET['repeat'] != "") {
                $query .= " and  order_templates.repeat='" . $_GET['repeat'] . "'";
            }
            if (isset($_GET['business']) && $_GET['business'] != "") {
                $query .= " and  clients.business_name like '%" . $_GET['business'] . "%'";
            }

            $orders = "SELECT order_templates.id AS template_id,order_templates.name AS template_name,clients.business_name,job_type.name AS job_type,order_templates.repeat,order_templates.schedule_from,order_templates.is_active  
                       FROM order_templates 
                       LEFT JOIN clients ON order_templates.client_id =clients.id 
                       LEFT JOIN job_type ON job_type.id=order_templates.job_type_id 
                       WHERE order_templates.vendor_id=" . Auth::user()->id . " " . $query;

            $orders = DB::select(DB::raw($orders));
        } else {

            $orders = OrderTemplate::select('order_templates.id AS template_id', 'order_templates.name AS template_name', 'clients.business_name', 'job_type.name As job_type', 'order_templates.repeat', 'order_templates.schedule_from', 'order_templates.is_active')->where('order_templates.vendor_id', Auth::user()->id)->orderBy('order_templates.id', 'desc')
                ->leftjoin('clients', 'order_templates.client_id', '=', 'clients.id')
                ->leftjoin('job_type', 'job_type.id', '=', 'order_templates.job_type_id')
                ->get();

        }
        return view('vendor.repeat-templates-list', compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $child = Category::where('role','child')->get();
        $subs = Category::where('role','sub')->get();
        $categories = Category::where('role','main')->get();
        $accountManagers = DB::connection('mysql2')->table('EMPLOYEE')
            ->join('employee_company_details', 'EMPLOYEE.UID', '=', 'employee_company_details.employee_id')
            ->where('employee_company_details.department_id', 3)
            ->get();
        $vendor_id = Auth::user()->id;
        $job_type = DB::connection('mysql2')->table('JOB_TYPE')->get();
        return view('vendor.template-create-customer', compact('id', 'accountManagers', 'job_type', 'vendor_id','child','subs','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(

            "name" => 'required',
            "job_type_id" => 'required',
            "repeat" => 'required',
            "days_allowed" => 'required',
            "schedule_from" => 'required',
            "avg_service_time" => 'numeric',
            "is_active" => 'required'

        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();

            $input = $request->all();

        }
        $input = $request->all();
        $dateFromat=explode("-",$input['schedule_from']);
        $dateFromated=$dateFromat[2]."-".$dateFromat[0]."-".$dateFromat[1];
        $template = OrderTemplate::create(
            [
                'client_id'=> $input['client_id'],
                'vendor_id'=> $input['vendor_id'],
                'name' => $input['name'],
                'manager_id' => $input['manager_id'],
                'job_type_id' => $input['job_type_id'],
                'repeat' =>$input['repeat'],
                'days_apart' => $input['days_apart'],
                'weeks_apart' => $input['weeks_apart'],
                'months_apart' => $input['months_apart'],
                'days_allowed' => $input['days_allowed'],
                'schedule_from' => $dateFromated,
                'avg_service_time' => $input['avg_service_time'],
                'is_active' => $input['is_active'],
                'special_notes' => $input['special_notes'],
                'name_for_sams' => $input['name_for_sams'] ?? '',
                'payment_method' => $input['payment_method'],
                'category_id' => $input['category_id'],
                'sub_category_id' => $input['sub_category_id'],
                'child_category_id' => $input['child_category_id'],

            ]
        );
         return redirect('vendor/customer/' . $template->client_id . '/templates')->with('message', 'Template has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\OrderTemplate $orderTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(OrderTemplate $orderTemplate)
    {
        $products = Product::where('vendorid', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->pluck('id', 'title');

        $category = [];

        $categoryMappings = [
            'main_category' => $orderTemplate->category_id,
            'sub_category' => $orderTemplate->sub_category_id,
            'child_category' => $orderTemplate->child_category_id,
        ];

        foreach ($categoryMappings as $key => $categoryId) {
            if (!empty($categoryId)) {
                // Ensure it's initialized as an array
                if (!isset($category[$key])) {
                    $category[$key] = [];
                }

                // Append the name to the array
                $name = Category::where('id', $categoryId)->value('name');
                $category[$key] = $name;
            }
        }

        // echo '<pre>';
        // print_r($category);die;
      
        $job_type = DB::connection('mysql2')->table('JOB_TYPE')->where('UID', $orderTemplate->job_type_id)->first();
        $accountManager = DB::connection('mysql2')->table('EMPLOYEE')->where('UID', $orderTemplate->manager_id)->first();
        $orderTemplateItems = OrderTemplateItem::whereOrderTemplateId($orderTemplate->id)->get();
        return view('vendor.ordertemplate-show', compact('orderTemplate', 'products', 'orderTemplateItems', 'job_type', 'accountManager','category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\OrderTemplate $orderTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orderTemplate = OrderTemplate::findOrFail($id);
        $category = [];

        $categoryMappings = [
            'main_category' => $orderTemplate->category_id,
            'sub_category' => $orderTemplate->sub_category_id,
            'child_category' => $orderTemplate->child_category_id,
        ];

        foreach ($categoryMappings as $key => $categoryId) 
        {
            if (!empty($categoryId)) {
                // Ensure it's initialized as an array
                if (!isset($category[$key])) {
                    $category[$key] = [];
                }

                // Append the name to the array
                $name = Category::where('id', $categoryId)->value('name');
                $category[$key] = $name;
            }
        }

        $child = Category::where('role','child')->get();
        $subs = Category::where('role','sub')->get();
        $categories = Category::where('role','main')->get();

        $accountManagers = DB::connection('mysql2')->table('EMPLOYEE')
            ->join('employee_company_details', 'EMPLOYEE.UID', '=', 'employee_company_details.employee_id')
            ->where('employee_company_details.department_id', 3)
            ->get();

        $job_type = DB::connection('mysql2')->table('JOB_TYPE')->get();

        return view('vendor.template-edit-customer', compact('orderTemplate', 'id', 'accountManagers', 'job_type','category','child','subs','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\OrderTemplate $orderTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            "name" => 'required',
            "job_type_id" => 'required',
            "repeat" => 'required',
            "days_allowed" => 'required',
            "schedule_from" => 'required',
            "avg_service_time" => 'numeric',
            "is_active" => 'required',
            "payment_method" => 'required'

        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
            $input = $request->all();

        }
        if ($request->input('template_id')) {

            $dateFromat=explode("-",$request->input('schedule_from'));
            $dateFromated=$dateFromat[2]."-".$dateFromat[0]."-".$dateFromat[1];
            $template = OrderTemplate::where('id', $request->input('template_id'))->first(); 
            $template->name = $request->input('name');
            $template->job_type_id = $request->input('job_type_id');
            $template->repeat = $request->input('repeat');
            $template->days_apart = $request->input('days_apart');
            $template->weeks_apart = $request->input('weeks_apart');
            $template->months_apart = $request->input('months_apart');
            $template->days_allowed = $request->input('days_allowed');
            $template->schedule_from =  $dateFromated;
            $template->avg_service_time = $request->input('avg_service_time');
            $template->is_active = $request->input('is_active');
            $template->special_notes = $request->input('special_notes');
            $template->manager_id = $request->input('manager_id');
            $template->name_for_sams = $request->input('name_for_sams');
            $template->payment_method = $request->input('payment_method');
            $template->category_id = $request->input('category_id');
            $template->sub_category_id = $request->input('sub_category_id');
            $template->child_category_id = $request->input('child_category_id');
            $template->update();
        }

       return redirect('vendor/customer/' . $template->client_id . '/templates')->with('message', 'Template has been successfully updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\OrderTemplate $orderTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function repeatTemplateDelete($id)
    {
        $template = OrderTemplate::findOrFail($id);
        $client_id = $template->client_id;
        $template->delete();
        return redirect('vendor/customer/' . $client_id . '/templates')->with('message', 'Template Delete Successfully.');
    }

    public function getTemplateAjax($client_id)
    {

        $templates = OrderTemplate::join('clients', 'order_templates.client_id', '=', 'clients.id')
            ->join('vendor_customers', 'vendor_customers.customer_id', '=', 'order_templates.client_id')
            ->join('job_type', 'order_templates.job_type_id', '=', 'job_type.id')
            ->select('order_templates.*','job_type.name AS typeName')
            ->where('vendor_customers.vendor_id', Auth::user()->id)->where('order_templates.client_id', $client_id);

        if ($_GET['template_name']) {
            $templates->where('order_templates.name', 'like',  "%{$_GET['template_name']}%");
        }
        if ($_GET['repeat']) {
            $templates->where('order_templates.repeat', '=',  "{$_GET['repeat']}");
        }
        $type = str_replace('=', '', $_GET['type']);
        if ($type) {
            $templates->where('order_templates.job_type_id', $type);
        }
        if (($_GET['fromTime']) && $_GET['toTime']) {
            $templates->whereBetween('order_templates.last_updated_date', [date('Y-m-d', strtotime($_GET['fromTime'])), date('Y-m-d', strtotime($_GET['toTime']))]);
        }

        return Datatables::of($templates)
            ->addColumn('last_date', function ($template) {
                return (!empty($template->last_updated_date))?date('m-d-Y', strtotime($template->last_updated_date)):'N/A';
            })
            ->addColumn('action', function ($template) {
                return '<a href="/vendor/order-template/' . $template->id . '/edit" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>'
                    . '<a href="/vendor/order-template/' . $template->id . '" class="ml-2 btn btn-xs btn-info"><i class="glyphicon glyphicon-eye"></i>&nbsp;View</a>'
                    . '<a href="/vendor/repeat-template-delete/' . $template->id . '" class="ml-2 btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i>&nbsp;Delete</a>';
            })
            ->make(true);
    }

    public function getTemplateByVendor()
    {
        $templates = OrderTemplate::join('clients', 'order_templates.client_id', '=', 'clients.id')
            ->join('vendor_customers', 'vendor_customers.customer_id', '=', 'order_templates.client_id')
            ->join('job_type', 'order_templates.job_type_id', '=', 'job_type.id')
            ->select('order_templates.id', 'order_templates.name', 'job_type.name AS typeName', 'order_templates.repeat', 'order_templates.schedule_from')
            ->where('vendor_customers.vendor_id', Auth::user()->id);

        return Datatables::of($templates)
            ->addColumn('action', function ($template) {
                return '<a href="/vendor/order-template/' . $template->id . '/edit" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-edit"></i> Edit</a>'
                    . '<a href="/vendor/order-template/' . $template->id . '" class="ml-2 btn btn-xs btn-info"><i class="glyphicon glyphicon-eye"></i> View</a>';
            })
            ->make(true);
    }

    public function getTemplateOrderAjax($client_id)
    {
        $orders = Order::select('orders.*', 'job_type.name as type','clients.name as customer_name')
            ->leftJoin('job_type', 'orders.job_type', '=', 'job_type.id')
            ->leftJoin('clients', 'orders.customerid', '=', 'clients.id')
            ->where('orders.customerid', $client_id);

        if ($_GET['orderId']) {
            $orders->where('orders.id', $_GET['orderId']);
        }

        if ($_GET['quickdate']) {
            $all = false;
            switch ($_GET['quickdate']) {
                case 'today':
                    $start = date('Y-m-d');
                    $end = date('Y-m-d');
                    break;
                case 'yesterday':
                    $start = date('Y-m-d', strtotime('yesterday'));
                    $end = date('Y-m-d', strtotime('yesterday'));
                    break;
                case 'tomorrow':
                    $start = date('Y-m-d');
                    $end = date('Y-m-d', strtotime('tomorrow'));
                    break;
                case 'wholeweek':
                    $start = date('Y-m-d', strtotime('monday this week'));
                    $end = date('Y-m-d', strtotime('sunday this week'));
                    break;
                case 'weekday':
                    $start = date('Y-m-d', strtotime('monday this week'));
                    $end = date('Y-m-d', strtotime('friday this week'));
                    break;
                case 'nextweek':
                    $start = date('Y-m-d', strtotime('monday next week'));
                    $end = date('Y-m-d', strtotime('sunday next week'));
                    break;
                case 'thismonth':
                    $start = date('Y-m-d', strtotime('first day of this month'));
                    $end = date('Y-m-d', strtotime('last day of this month'));
                    break;
                case 'nextmonth':
                    $start = date('Y-m-d', strtotime('first day of next month'));
                    $end = date('Y-m-d', strtotime('last day of next month'));
                    break;
                case 'thisyear':
                    $start = date('Y-m-d', strtotime('first day of January'));
                    $end = date('Y-m-d', strtotime('last day of December'));
                    break;
                case 'yeartodate':
                    $start = date('Y-m-d', strtotime('first day of January'));
                    $end = date('Y-m-d');
                    break;
                default:
                    $all = true;
            }
            if (!$all) {
                $orders->whereBetween('orders.booking_date', [$start, $end]);
            }

        }
        if (isset($_GET['clientName']) && $_GET['clientName'] != "") {
            $orders->where('clients.name', 'like','%'.$_GET['clientName'].'%');
        }
        if (($_GET['fromTime']) && $_GET['toTime']) {
            $orders->whereBetween('orders.booking_date', [date('Y-m-d', strtotime($_GET['fromTime'])), date('Y-m-d', strtotime($_GET['toTime']))]);
        }
        if ($_GET['status']) {
            $orders->where('orders.status', $_GET['status']);
        }
        if ($_GET['method']) {
            $orders->where('orders.method', $_GET['method']);
        }
        $type = str_replace('=', '', $_GET['type']);
        if ($type) {
            $orders->where('orders.job_type', $type);
        }
        return Datatables::of($orders)
            ->addColumn('action', function ($orders) {
                if($orders->order_type==3){
                    return '<a href="/vendor/order-template-order-repeat/' . $orders->id . '" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>'
                        . '&nbsp;<a href="#" class="ml-2 btn btn-xs btn-success" onclick="modalSend('.$orders->id.')" data-toggle="modal" data-target="#send"  data-orderid="'.$orders->id.'"><i class="fa fa-send"></i></a>'
                        . '&nbsp;<a href="/vendor/order-template-delete/' . $orders->id . '" class="ml-2 btn btn-xs btn-danger"><i class="fa fa-remove"></i></a>';
                }
                else {
                    return '<a href="/vendor/order-template-order/' . $orders->id . '" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>'
                        . '&nbsp;<a href="#" class="ml-2 btn btn-xs btn-success" onclick="modalSend('.$orders->id.')" data-toggle="modal" data-target="#send"  data-orderid="'.$orders->id.'"><i class="fa fa-send"></i></a>'
                        . '&nbsp;<a href="/vendor/order-template-delete/' . $orders->id . '" class="ml-2 btn btn-xs btn-danger"><i class="fa fa-remove"></i></a>';
                }

            })
            ->make(true);

    }

    public function OrderTemplateOrderViewRepeat($id)
    {
        $order = Order::where('id', $id)->first();
        $products = OrderTemplateItem::where('order_template_id', $order->template_id)->get();
        return view('vendor.ordertemplate-order-show-repeat', compact('order', 'products'));
    }

    public function getOrderTemplateActivate(Request $request)
    {
        $input = $request->all();
        foreach ($input['isActive_arr'] AS $arr) {
            $orders = OrderTemplate::where('id', $arr);
            $orders->update(['is_active' => 1]);
        }
        return $input['isActive_arr'];
    }

    public function getTemplateOrderDelete(Request $request)
    {
        $input = $request->all();
        foreach ($input['deleteids_arr'] AS $arr) {
            $this->OrderTemplateOrderDelete($arr);
        }
        return $input['deleteids_arr'];
    }


 public function getJobDates($template, $startDate, $endDate)
{
    $jobDates = [];

    // Normalize allowed days (0 = Sun, 6 = Sat)
    $daysAllowed = is_array($template->days_allowed)
        ? $template->days_allowed
        : explode(',', $template->days_allowed);
    $daysAllowed = array_map('intval', $daysAllowed);

    // Parse schedule_from and endDate
    $scheduleFrom = Carbon::parse($template->schedule_from);
    $end = Carbon::parse($endDate);

    // Always add first date as schedule_from
    if ($scheduleFrom <= $end) {
        $jobDates[] = $scheduleFrom->toDateString();
    } else {
        return []; // No schedule possible
    }

    $repeat = strtolower($template->repeat);

    // Helper: Find next allowed day ON or AFTER given date
    $findNextAllowedDate = function (Carbon $fromDate) use ($daysAllowed, $end) {
        for ($i = 0; $i <= 7; $i++) {
            $check = $fromDate->copy()->addDays($i);
            if ($check > $end) break;
            if (in_array($check->dayOfWeek, $daysAllowed)) {
                return $check;
            }
        }
        return null;
    };

    // Daily/Weekly/Quarterly/etc. handler
    $processIntervalRepeat = function ($baseStart, $intervalDays, $end, $findNextAllowedDate) use (&$jobDates) {
        $current = $baseStart->copy();
        while (true) {
            $nextBase = $current->copy()->addDays($intervalDays);
            if ($nextBase > $end) break;

            $nextValid = $findNextAllowedDate($nextBase);
            if ($nextValid && $nextValid <= $end) {
                $jobDates[] = $nextValid->toDateString();
                $current = $nextValid->copy();
            } else {
                break;
            }
        }
    };

    switch ($repeat) {
        case 'on call':
            // Already added schedule_from
            break;

        case 'daily':
            $intervalDays = max(1, (int)($template->days_apart ?? 1));
            $processIntervalRepeat($scheduleFrom, $intervalDays, $end, $findNextAllowedDate);
            break;

        case 'weekly':
            $intervalDays = max(1, (int)($template->weeks_apart ?? 1)) * 7;
            $processIntervalRepeat($scheduleFrom, $intervalDays, $end, $findNextAllowedDate);
            break;

        case 'monthly':
            $monthsApart = max(1, (int)($template->months_apart ?? 1));
            $current = $scheduleFrom->copy();
            while (true) {
                $nextMonthBase = $current->copy()->addMonthsNoOverflow($monthsApart);
                if ($nextMonthBase > $end) break;

                $nextValid = $findNextAllowedDate($nextMonthBase);
                if ($nextValid && $nextValid <= $end) {
                    $jobDates[] = $nextValid->toDateString();
                    $current = $nextValid->copy();
                } else {
                    break;
                }
            }
            break;

        case 'quarterly':
            $processIntervalRepeat($scheduleFrom, 84, $end, $findNextAllowedDate);
            break;

        case 'semi-annual':
            $processIntervalRepeat($scheduleFrom, 168, $end, $findNextAllowedDate);
            break;

        case 'yearly':
            $processIntervalRepeat($scheduleFrom, 336, $end, $findNextAllowedDate);
            break;
    }

    $jobDates = array_unique($jobDates);
    sort($jobDates);
    return $jobDates;
}



    public function makeRecurringOrder(Request $request)
    {
        $template = OrderTemplate::whereId($request->order_template_id)->first();
        $scheduleFrom=date('Y-m-d', strtotime($template->schedule_from));
        $today=date('Y-m-d',time());
        $items = OrderTemplateItem::whereOrderTemplateId($request->order_template_id)->get();

        if (count($items) > 0) 
        {
            $products = [];
            $quantities = [];
            $prices = [];
            $price = 0;
            $subtotal = 0;
            if (!empty($items)) {
                foreach ($items as $item) {
                    $products[] = $item->product_id;
                    $prices[] = $item->base_price;
                    $quantities[] = $item->qty;
                    $subtotal += $item->base_price;
                    $price += $item->base_price * $item->qty;
                }
            }
            $tax = $price * 0.13;
            $cost = $tax + $price;
            $products = implode(',', $products);
            $quantities = implode(',', $quantities);

            if ($request->order_template_type == OrderTemplate::NEXT_MONTH) {
                if ($template->repeat === 'On Call') {
                    Session::flash('error', 'You can only create jobs on a single date for "On Call" templates.');
                    return redirect('/vendor/order-template/' . $template->id);
                }

                $scheduleFrom = Carbon::parse($template->schedule_from);
                $allowedDays = is_array($template->days_allowed)
                    ? $template->days_allowed
                    : explode(',', $template->days_allowed);
                $allowedDays = array_map('intval', $allowedDays);

                // Step 1: Get first allowed day after schedule_from
                $startDate = null;
                for ($i = 0; $i < 7; $i++) {
                    $check = $scheduleFrom->copy()->addDays($i);
                    if (in_array($check->dayOfWeek, $allowedDays)) {
                        $startDate = $check;
                        break;
                    }
                }

                if (!$startDate) {
                    Session::flash('error', 'No valid start day (allowed day) found after schedule date.');
                    return redirect('/vendor/order-template/' . $template->id);
                }

                // Step 2: Define window of 28 days
                $endDate = $startDate->copy()->addDays(28);

                // Step 3: Call getJobDates with this range
                $jobDates = $this->getJobDates($template, $startDate, $endDate);

                foreach ($jobDates as $date) {
                    $this->generateRepeatOrders($template, $quantities, $products, $date, $cost, $prices);
                }

                Session::flash('message', 'Jobs for next month generated successfully.');
                return Redirect('/vendor/order-template-history/' . $template->client_id . '/' . $template->id);
            }


            elseif ($request->order_template_type == OrderTemplate::RANGE) {
                // puvii added
                if ($template->repeat === 'On Call') {
                    Session::flash('error', 'You can only create jobs on a single date for "On Call" templates.');
                    return redirect('/vendor/order-template/' . $template->id);
                }

                $toDate=$request->date;
                $fromDate=$request->genDateFormDate;
                $nextMonthStart = Carbon::parse($fromDate);
                $nextMonthEnd = Carbon::parse($toDate);

                
                
                // Check if schedule_from is before or equal to the start date of the next month
                $scheduleFrom = Carbon::parse($template->schedule_from);

                if ($scheduleFrom->gt($nextMonthStart)) {
                    Session::flash('error', 'Please select a date before or on the schedule from date.');
                    return redirect('/vendor/order-template/' . $template->id);
                }


                $jobDates = $this->getJobDates($template, $scheduleFrom, $nextMonthEnd);

                foreach ($jobDates as $date) {
                    $this->generateRepeatOrders($template, $quantities, $products, $date, $cost, $prices);
                }

                Session::flash('message', 'Jobs for selected range generated successfully.');
                return Redirect('/vendor/order-template-history/' . $template->client_id . '/' . $template->id);
                
            }
            elseif ($request->order_template_type == OrderTemplate::SINGlE_DATE) {
                $date = explode('/', $request->date); // 06/30/2024
                $date = $date[2] . "-" . $date[0] . "-" . $date[1]; // 2024-06-26 => Y-m-d

                if ($scheduleFrom <= $date) {
                    if (empty($request->date)) {
                        Session::flash('error', 'There is no date selected to generate repeat jobs, please select a date and retry');
                        return Redirect('/vendor/order-template/' . $template->id);
                    } else {
                        $date = date('Y-m-d', strtotime($date));

                        $this->generateRepeatOrders($template, $quantities, $products, $date, $cost, $prices);

                        Session::flash('message', 'Single day job has been successfully created');
                        return Redirect('/vendor/order-template-history/' . $template->client_id . '/' . $template->id);
                    }
                } else {
                    Session::flash('error', 'Please select date after schedule from date.');
                    return Redirect('/vendor/order-template/' . $template->id);
                }
            	
            }
            else {
                Session::flash('message', 'Order creation failed.');
                return Redirect('/vendor/order-template/'.$template->id);
            }
        } else {
            Session::flash('error', 'No products were assigned or not a active templates.');
            return Redirect('/vendor/order-template/'.$template->id);
        }

    }

    public function generateRepeatOrders($template, $quantities, $products, $dateIncrement, $cost, $prices)
    {
        $order = Order::create([
            'order_type' => Order::REPEAT_ORDERS,
            'template_id' => $template->id,
            'customerid' => $template->client_id,
            'quantities' => $quantities,
            'products' => $products,
            'payment_status' => "Pending",
            'customer_email' => $template->client->email,
            'customer_name' => $template->client->firstname . " " . $template->client->lastname,
            'customer_phone' => $template->client->phone,
            'customer_address' => $template->client->address,
            'customer_city' => $template->client->city,
            'customer_zip' => $template->client->zip,
            'shipping_email' => $template->email,
            'shipping_name' => $template->name,
            'shipping_phone' => $template->phone,
            'shipping_address' => $template->address,
            'shipping_city' => $template->city,
            'shipping_zip' => $template->zip,
            'job_type' => $template->job_type_id,
            'job_notes' => $template->special_notes,
            'job_status' => 'Scheduled',
            'job_name' => $template->name,
            'booking_date' => $dateIncrement,
            'status' => "scheduled",
            'job_service_time' => $template->avg_service_time,
            'po_number' => $template->po_cro_no,
            'method' => $template->payment_method,
            'pay_amount' => number_format((float)$cost, 2, '.', ''),
        ]);
        $productIds = explode(',', $products);
        $productQuantities = explode(',', $quantities);
        foreach ($productIds as $data => $product) {
            $orderProduct = new OrderedProducts();

            $product = Product::findOrFail($product);

            $orderProduct['orderid'] = $order->id;
            $orderProduct['owner'] = $product->owner;
            $orderProduct['vendorid'] = $product->vendorid;
            $orderProduct['productid'] = $productIds[$data];
            $orderProduct['quantity'] = $productQuantities[$data];
            $orderProduct['payment'] = "pending";
            $orderProduct['cost'] = $prices[$data] * $productQuantities[$data];
            $orderProduct->save();

            $stocks = $product->stock - $productQuantities[$data];
            if ($stocks < 0) {
                $stocks = 0;
            }
            $quant['stock'] = $stocks;
            $product->update($quant);
        }

    }

    public function OrderTemplateOrderView($id)
    {
        $order = Order::where('id', $id)->first();
        $products = OrderedProducts::where('orderid', $id)->get();
        return view('vendor.ordertemplate-order-show', compact('order', 'products'));
    }

    public function OrderTemplateOrderHistory($id)
    {
        $order = Order::where('id', $id)->first();
        $products = OrderedProducts::where('orderid', $id)->get();
        return view('vendor.ordertemplate-history', compact('order', 'products'));
    }

    public function OrderTemplateOrderDelete($id)
    {
        $order = Order::where('id', $id)->first();
        $customerid = $order->customerid;
        $order->delete();
        $products = OrderedProducts::where('orderid', $id)->get();
        foreach ($products as $product) {
            $product->delete();
        }
        Session::flash('message', 'Order has been successfully Deleted');
        return Redirect('/vendor/customer/' . $customerid . '/orders?orderId=&quickdate=&fromTime=&toTime=&status=&method=&type=&orderForm=Search');
    }

    public function getMonthRange($start_date, $end_date, $months_apart,$days_allowed)
    {
        $startMonth = date('Y-m-d', strtotime($start_date));
        $startDate = Carbon::parse($startMonth);
        $startMonth = $startDate->month;
        $endMonth = date('Y-m-d', strtotime($end_date));
        $endDate = Carbon::parse($endMonth);
        $endMonth = $endDate->month;

        $i = 0;
        foreach (range($startMonth, $endMonth, $months_apart) as $number) {

            if ($i == 0) {
                $first_start = date('Y-m-d', strtotime($start_date));
                $first_end = date('Y-m-d', strtotime('last day of this month', strtotime($start_date)));
                $monthData = array('month' => $i, 'start' => $first_start, 'end' => $first_end);
            } else {
                $month = date('Y-m-d', strtotime("+" . $i . " month", strtotime($start_date)));
                $month_start = date('Y-m-d', strtotime('first day of this month', strtotime($month)));
                $month_end = date('Y-m-d', strtotime('last day of this month', strtotime($month)));
                $monthData = array('month' => $i, 'start' => $month_start, 'end' => $month_end);
            }
            $monthList[] = $monthData;

            $i = $number;
        }

        foreach ($monthList AS $value) {
            $finalOut[] = $this->getMonthRangeByNext($value['start'],$value['end']);
        }


        $finalList = $this->putOneList($finalOut);
        foreach ($finalList As $days)
        {
            $day = Carbon::parse($days);
            $allow=$day->dayOfWeek;
            if(in_array($allow,$days_allowed))
            {
                $list[]=$days;
            }
        }
       return $list;
    }

    public function getMonthRangeByNext($first,$last)
    {
        $i = 0;
        while (end($datesFirst) < $last) {
            $incrementDate = date('Y-m-d', strtotime($first . '+' . $i . ' days'));
            $datesFirst[] = $incrementDate;
            $i++;
        }
        return $datesFirst;
    }

    public function getDateRange($start_date, $end_date, $days_apart,$days_allowed)
    {
        $list=[];
        $i = $days_apart;
        $dates = array($start_date);
        while (end($dates) < $end_date) {
            $incrementDate = date('Y-m-d', strtotime(end($dates) . ' +' . $i . ' days'));
            if ($incrementDate > $end_date) {
                break;
            }
            $dates[] = $incrementDate;
            $i = +$days_apart;
        }
        foreach ($dates As $days)
        {
            $day = Carbon::parse($days);
            $allow=$day->dayOfWeek;
            if(in_array($allow,$days_allowed))
            {
                $list[]=$days;
            }
        }
        return $list;
    }

    public function getDateRangeNonApart($start_date, $end_date)
    {
        $i = 0;
        $dates = array($start_date);
        while (end($dates) < $end_date) {
            $incrementDate = date('Y-m-d', strtotime(end($dates) . ' +' . $i . ' days'));
            if ($incrementDate > $end_date) {
                break;
            }
            $dates[] = $incrementDate;
            $i++;
        }

        return $dates;
    }

    public function getDatesFromRange($start, $end)
    {

        $dates = array($start);
        while (end($dates) < $end) {
            $dates[] = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
        }

        return $dates;
    }

    public function putOneList($finalList)
    {
        foreach ($finalList AS $key => $val) {
            foreach ($val as $value) {
                $flat[] = $value;
            }
        }

        return $flat;

    }

    public function getWeeklyDateRange($start, $end, $weeks_apart,$days_allowed,$next=null)
    {
        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));
        $startDate = Carbon::parse($start);

        //print_r($start." ".$end);die;
        $dayWeek = $startDate->dayOfWeek;

        if($next)
        {
            $i = 0;
            while ($i < 7) {
                $incrementDate = date('Y-m-d', strtotime($start . '+' . $i . ' days'));
                $datesFirst[] = $incrementDate;
                $i++;
            }

        } else {
            $dif = 7 - $dayWeek;
            $i = 0;
            while ($i <= $dif) {
                $incrementDate = date('Y-m-d', strtotime(end($start) . '+' . $i . ' days'));
                $datesFirst[] = $incrementDate;
                $i++;
            }
        }


        $startNext = date('Y-m-d', strtotime(end($datesFirst) . '+1 days'));

        while ($incrementDate <= $end) {
            $incrementDate = date('Y-m-d', strtotime("$startNext +" . $weeks_apart . " week"));
            if ($incrementDate >= $end) {
                break;
            }
            $next = $this->getWeeklyDateRangeByNext($incrementDate);
            $datesRest[] = $next;
            $startNext = end($next);
        }

      //print_r($this->putOneList($datesRest));die;
        if ($datesRest) {
            $lastList = array_merge($datesFirst, $this->putOneList($datesRest));
        } else {
            $lastList = $datesFirst;
        }

        foreach ($lastList As $days)
        {
            $day = Carbon::parse($days);
            $allow=$day->dayOfWeek;
            if(in_array($allow,$days_allowed))
            {
                $list[]=$days;
            }
        }

        print_r($list);die;
        return $list;
    }

    public function getWeeklyDateRangeByNext($next)
    {

        $i = 0;
        while ($i < 7) {
            $incrementDate = date('Y-m-d', strtotime($next . '+' . $i . ' days'));
            $datesFirst[] = $incrementDate;
            $i++;
        }
        return $datesFirst;
    }

    public function getQuarterlyRange($start_date, $end_date, $days_allowed)
    {
        $start_date = date('Y-m-d', strtotime($start_date));
        for ( $i = 0; $i < 60; $i++ ) {
            $incrementDate =  date('Y-m-d', strtotime(' +'.$i.' days', strtotime($start_date)));
            $day = Carbon::parse($incrementDate);
            $allow=$day->dayOfWeek;
            if(in_array($allow,$days_allowed) AND $incrementDate>$end_date)
            {
                $list[]=$incrementDate;
            }

        }
        return $list;
    }

    public function getSemiAnnualRange($start_date, $end_date, $days_allowed)
    {
        $start_date = date('Y-m-d', strtotime($start_date));
        for ( $i = 0; $i < 180; $i++ ) {
            $incrementDate =  date('Y-m-d', strtotime(' +'.$i.' days', strtotime($start_date)));
            $day = Carbon::parse($incrementDate);
            $allow=$day->dayOfWeek;
            if(in_array($allow,$days_allowed) AND $incrementDate>$end_date)
            {
                $list[]=$incrementDate;
            }
        }
        return $list;

    }

    public function getYearlyRange($start_date, $end_date, $days_allowed)
    {
        $start_date = date('Y-m-d', strtotime($start_date));
        for ( $i = 0; $i < 360; $i++ ) {
            $incrementDate =  date('Y-m-d', strtotime(' +'.$i.' days', strtotime($start_date)));
            $day = Carbon::parse($incrementDate);
            $allow=$day->dayOfWeek;
            if(in_array($allow,$days_allowed) AND $incrementDate>$end_date)
            {
                $list[]=$incrementDate;
            }
        }
        return $list;
    }

    public function history($id,$temp_id)
    {
        $orders = Order::select('orders.*', 'job_type.name as type')
            ->leftJoin('job_type', 'orders.job_type', '=', 'job_type.id')
            ->leftJoin('order_templates', 'order_templates.id', '=', 'orders.template_id')
            ->where('orders.customerid', $id)->where('orders.template_id',$temp_id)->where('order_templates.vendor_id', Auth::user()->id);
        $client_id=$id;
        $template_id=$temp_id;
        if (isset($_GET['orderId'])) {
            $orders->where('orders.id', $_GET['orderId']);
        }

        if (isset($_GET['quickdate'])) {
            $all = false;
            switch ($_GET['quickdate']) {
                case 'today':
                    $start = date('Y-m-d');
                    $end = date('Y-m-d');
                    break;
                case 'yesterday':
                    $start = date('Y-m-d', strtotime('yesterday'));
                    $end = date('Y-m-d', strtotime('yesterday'));
                    break;
                case 'tomorrow':
                    $start = date('Y-m-d');
                    $end = date('Y-m-d', strtotime('tomorrow'));
                    break;
                case 'wholeweek':
                    $start = date('Y-m-d', strtotime('monday this week'));
                    $end = date('Y-m-d', strtotime('sunday this week'));
                    break;
                case 'weekday':
                    $start = date('Y-m-d', strtotime('monday this week'));
                    $end = date('Y-m-d', strtotime('friday this week'));
                    break;
                case 'nextweek':
                    $start = date('Y-m-d', strtotime('monday next week'));
                    $end = date('Y-m-d', strtotime('sunday next week'));
                    break;
                case 'thismonth':
                    $start = date('Y-m-d', strtotime('first day of this month'));
                    $end = date('Y-m-d', strtotime('last day of this month'));
                    break;
                case 'nextmonth':
                    $start = date('Y-m-d', strtotime('first day of next month'));
                    $end = date('Y-m-d', strtotime('last day of next month'));
                    break;
                case 'thisyear':
                    $start = date('Y-m-d', strtotime('first day of January'));
                    $end = date('Y-m-d', strtotime('last day of December'));
                    break;
                case 'yeartodate':
                    $start = date('Y-m-d', strtotime('first day of January'));
                    $end = date('Y-m-d');
                    break;
                default:
                    $all = true;
            }
            if (!$all) {
                $orders->whereBetween('orders.booking_date', [$start, $end]);
            }

        }
        if (isset($_GET['fromTime']) && isset($_GET['toTime'])) {
            $orders->whereBetween('orders.booking_date', [date('Y-m-d', strtotime($_GET['fromTime'])), date('Y-m-d', strtotime($_GET['toTime']))]);
        }
        if (isset($_GET['status'])) {
            $orders->where('orders.status', $_GET['status']);
        }
		
	    if(isset($_GET['orderType']))
		{
			// $jobType = str_replace('=', '', $_GET['jobType']);
            $jobType = str_replace('=', '', $_GET['jobType'] ?? '');
			if ($jobType) {
			   $orders->where('orders.job_type', $jobType);
			}
		}	
		if(isset($_GET['jobName']))
		{
			// $jobName = str_replace('=', '', $_GET['jobName']);
            $jobName = str_replace('=', '', $_GET['jobName'] ?? '');
			if ($jobName) {
				$orders->whereRaw('LOWER(orders.job_name) LIKE  "%'.trim(strtolower($jobName)).'%"');  
			}
		}
		
		if(isset($_GET['orderType']))
		{
			// $orderType = str_replace('=', '', $_GET['orderType']);
            $orderType = str_replace('=', '', $_GET['orderType'] ?? '');
			if ($orderType) {
				$orders->where('orders.order_type', $orderType);
			}
		}
      
         $orders->orderBy('orders.id', 'desc')->get();
         $template=OrderTemplate::where('id',$template_id)->first();
         $query = "SELECT * FROM `job_type`";
         $jobType = DB::select(DB::raw($query));
        if (!empty($orders)) {
            return view('vendor.ordertemplate-history', compact('orders','template','jobType','template_id','client_id'));
        } else {
            return NULL;
        }

    }

    public function getTemplateHistoryAjax($client_id,$temp_id)
    {
        $orders = Order::select('orders.*', 'job_type.name as type')
            ->leftJoin('job_type', 'orders.job_type', '=', 'job_type.id')
            ->where('orders.customerid', $client_id)->where('template_id',$temp_id);

        if ($_GET['orderId']) {
            $orders->where('orders.id', $_GET['orderId']);
        }

        if ($_GET['quickdate']) {
            $all = false;
            switch ($_GET['quickdate']) {
                case 'today':
                    $start = date('Y-m-d');
                    $end = date('Y-m-d');
                    break;
                case 'yesterday':
                    $start = date('Y-m-d', strtotime('yesterday'));
                    $end = date('Y-m-d', strtotime('yesterday'));
                    break;
                case 'tomorrow':
                    $start = date('Y-m-d');
                    $end = date('Y-m-d', strtotime('tomorrow'));
                    break;
                case 'wholeweek':
                    $start = date('Y-m-d', strtotime('monday this week'));
                    $end = date('Y-m-d', strtotime('sunday this week'));
                    break;
                case 'weekday':
                    $start = date('Y-m-d', strtotime('monday this week'));
                    $end = date('Y-m-d', strtotime('friday this week'));
                    break;
                case 'nextweek':
                    $start = date('Y-m-d', strtotime('monday next week'));
                    $end = date('Y-m-d', strtotime('sunday next week'));
                    break;
                case 'thismonth':
                    $start = date('Y-m-d', strtotime('first day of this month'));
                    $end = date('Y-m-d', strtotime('last day of this month'));
                    break;
                case 'nextmonth':
                    $start = date('Y-m-d', strtotime('first day of next month'));
                    $end = date('Y-m-d', strtotime('last day of next month'));
                    break;
                case 'thisyear':
                    $start = date('Y-m-d', strtotime('first day of January'));
                    $end = date('Y-m-d', strtotime('last day of December'));
                    break;
                case 'yeartodate':
                    $start = date('Y-m-d', strtotime('first day of January'));
                    $end = date('Y-m-d');
                    break;
                default:
                    $all = true;
            }
            if (!$all) {
                $orders->whereBetween('orders.booking_date', [$start, $end]);
            }

        }
        if (($_GET['fromTime']) && $_GET['toTime']) {
            $orders->whereBetween('orders.booking_date', [date('Y-m-d', strtotime($_GET['fromTime'])), date('Y-m-d', strtotime($_GET['toTime']))]);
        }
        if ($_GET['status']) {
            $orders->where('orders.status', $_GET['status']);
        }
        $jobType = str_replace('=', '', $_GET['jobType']);
        if ($jobType) {
           $orders->where('orders.job_type', $jobType);
        }
        $jobName = str_replace('=', '', $_GET['jobName']);
        if ($jobName) {
            $orders->whereRaw('LOWER(orders.job_name) LIKE  "%'.trim(strtolower($jobName)).'%"');  
        }
        $orderType = str_replace('=', '', $_GET['orderType']);
        if ($orderType) {
            $orders->where('orders.order_type', $orderType);
        }
        $orders->orderBy('orders.id', 'desc')->get();
        return Datatables::of($orders)
            ->addColumn('action', function ($orders) {
                return '<a href="/vendor/order-template-order-view/' . $orders->id . '" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-eye"></i> View</a>'
                    . '&nbsp;<a href="#" class="ml-2 btn btn-xs btn-success" onclick="modalSend('.$orders->id.')" data-toggle="modal" data-target="#send"  data-orderid="'.$orders->id.'"><i class="glyphicon glyphicon-send"></i> Email</a>'
                    . '&nbsp;<a href="/vendor/order-template-history-delete/' . $orders->id . '" class="ml-2 btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';

            })
            ->make(true);
    }

    public function OrderTemplateHistoryView($id)
    {
        $order = Order::where('id', $id)->first();
        $products = OrderTemplateItem::where('order_template_id', $order->template_id)->get();
        return view('vendor.ordertemplate-history-order-show', compact('order', 'products'));
    }

    public function OrderTemplateHistoryDelete($id)
    {
        $order = Order::where('id', $id)->first();
        $customerid = $order->customerid;
        $order->delete();
        $products = OrderedProducts::where('orderid', $id)->get();
        foreach ($products as $product) {
            $product->delete();
        }
        Session::flash('message', 'Order has been successfully Deleted');
        return Redirect('/vendor/order-template-history/' . $customerid . '/'.$order->template_id.'/');
    }

    public function notify(Request $request)
    {
        //find booking
        if ($request->order_id)
        {
            $order = Order::where('id', $request->order_id)->first();
            $customerid = $order->customerid;
            $client = Clients::whereId($customerid)->first();
            //send email to customer - refund true
            try {
                // Send Booking Cancelled email
                // customer email
                $EmailSubjectCustomer = EmailSubject::where('token', 'Kc0zS251')->first();
                $EmailTemplate = EmailTemplate::where('domain', 2)->where('subject_id', $EmailSubjectCustomer['id'])->first();
                $status=Mail::to($request->send_email)->send(new ScheduleOrderPlaced($client->name, $order, $EmailSubjectCustomer['subject'], $EmailTemplate));
               

            } catch (\Exception $ex) {
               // print_r($ex);
            }
            //set success message and redirect to bookings.show
            Session::flash('message', __('Vendor repeat order invoice successfully sent.'));
            return Redirect('/vendor/order-template-history/' . $customerid . '/'.$order->template_id.'/');
        }
    }

    public function notifyAll(Request $request)
    {
        //find booking
        if ($request->order_ids)
        {
            $order_ids=explode(',',$request->order_ids);
            $orders = Order::whereIn('id',$order_ids)->get();
            $customerid = $orders[0]->customerid;
            $client = Clients::whereId($customerid)->first();
            //send email to customer - refund true
            try {
                // Send Booking Cancelled email
                foreach ($orders As $order)
                {
                    // customer email
                    $EmailSubjectCustomer = EmailSubject::where('token', 'Kc0zS251')->first();
                    $EmailTemplate = EmailTemplate::where('domain', 2)->where('subject_id', $EmailSubjectCustomer['id'])->first();
                    Mail::to($request->send_email)->send(new ScheduleOrderPlaced($client->name, $order, $EmailSubjectCustomer['subject'], $EmailTemplate));
                }

            } catch (\Exception $ex) {
               //print_r($ex);
            }
            //set success message and redirect to bookings.show
            Session::flash('message', __('Vendor repeat orders invoices successfully sent.'));
            return Redirect('/vendor/order-template-history/' .$customerid. '/'.$order->template_id.'/');
        }
    }




}
