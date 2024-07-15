<?php

namespace App\Http\Controllers;

use App\JobType;
use App\Settings;
use App\Vendors;
use App\Withdraw;
use App\Order;
use App\OrderedProducts;
use App\Product;
use App\OrderTemplate;
use App\Clients;
use App\VendorCustomers;
use App\OrderInquiry;
use App\ServiceAgreement;
use App\ClientCreditCard;
use App\OrderTemplateItem;
use App\Mail\ServiceAgreementMail;
use App\Mail\ServiceAgreementPDFMail;
use App\Models\Upload_document;
use PDF;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;

class VendorController extends Controller
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
        return view('vendor.dashboard');
    }

	public function vieworders($status)
    {
        $orders = array();
        $searchSort = "";
        $text = "All Orders";
        $filterStatus = array();
        $q = "";
        if (isset($_GET['q']) && $_GET['q'] != "") {
            $q = $searchSort = $_GET['q'];
        }
        switch ($status) {
            case 'active':
                $orders = OrderedProducts::where('vendorid', Auth::user()->id)->where('status', config('constants.PENDING_ORDER'))->limit(30)->orderBy('id', 'desc')->get();
                $text = "Active Orders";
                break;
            case 'in-transit':
                $text = "In-Transit Orders";
                $arrayOfTrnasit = array(config('constants.IN_TRANSIT'), config('constants.AT_PLANT_RECE'), config('constants.AT_PLANT_COMPLETE'), config('constants.ON_DELIVERY'));
                $filterStatus = $arrayOfTrnasit;
                $commaSepratedString = implode(',', $arrayOfTrnasit);
                if ($searchSort != "") {
                    $commaSepratedString = $searchSort;
                }
                $orders = DB::select('SELECT * FROM `ordered_products` WHERE vendorid = ' . Auth::user()->id . ' and status IN (' . $commaSepratedString . ')');
                break;
            case 'completed':
                $text = "Completed Orders";
                $arrayOfTrnasit = array(config('constants.COMPLETED_DELIVERY'), config('constants.COMPLETED_IN_STORE'));
                $filterStatus = $arrayOfTrnasit;
                $commaSepratedString = implode(',', $arrayOfTrnasit);
                if ($searchSort != "") {
                    $commaSepratedString = $searchSort;
                }
                $orders = DB::select('SELECT * FROM `ordered_products` WHERE vendorid = ' . Auth::user()->id . ' and status IN (' . $commaSepratedString . ')');
                break;
        }
        return view('vendor.vieworders', compact('orders', 'text', 'filterStatus', 'q'));
    }


    public function profile($id)
    {
        $orders = array();
        $searchSort = "";
        $text = "User Profile";
        $filterStatus = array();
        $q = "";
        $totalOrders = array();
        $orderIds = [];

        /*echo Auth::user()->id.' - '.$id;
        die;*/
        $vendorId = Auth::user()->id;

        $userDetails = DB::select("select * from clients where id='$id'");
        $orderids = DB::select("select * from orders where customerid='$id'");
        if ($orderids != null) {
            foreach ($orderids as $single) {
                $orders[] = $single->id;
            }
            $orderIdsString = implode(',', $orders);
            //$totalOrders=DB::select("select * from orders where customerid='$id'");

            $users = DB::select("select * from ordered_products where vendorid='$vendorId' group by orderid");
            if ($users != null) {
                foreach ($users as $user) {
                    $orderIds[] = $user->orderid;
                }
            }
            if (count($orderids) > 0) {
                $orderIdsStr = implode(',', $orderIds);


                $totalOrders = DB::select("select * from orders where id in ($orderIdsStr) and customerid='$id'");


            }

            //$totalOrders=DB::select("select * from ordered_products where vendorid='$vendorId' and orderid in ($orderIdsString)");
        }

        //$orders = OrderedProducts::where('vendorid',Auth::user()->id)->where('status',config('constants.PENDING_ORDER'))->limit(30)->orderBy('id','desc')->get();

        //$userDetails = DB::select("");

        return view('vendor.profile', compact('userDetails', 'totalOrders'));
    }


    public function withdraw()
    {
        //$countries = Country::all();
        $user = Vendors::findOrFail(Auth::user()->id);
        return view('vendor.withdrawmoney', compact('user', 'countries'));
    }

    public function details($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {

        }
        $model = DB::select("select * from ordered_products where orderid='$id'");
        
        
        $orderCheck=Order::where("id",$id)->where("order_type",3)->first();
        if($orderCheck){
            $orderinquiry=OrderInquiry::where("order_id",$id)->first();
             return view('vendor.details', compact('model', 'order','orderinquiry'));
        }
        else {
             return view('vendor.details', compact('model', 'order'));
        }
           
    }

    public function withdraws()
    {
        if (isset($_GET['earningbtn'])) {
            $query = "";

            if (isset($_GET['orderId']) && $_GET['orderId'] != "") {
                $query .= " and orderid='" . $_GET['orderId'] . "'";
            }
            $startTime = date('Y-m-d 00:00:00');
            $endTime = date('Y-m-d 23:59:59');
            if (isset($_GET['time']) && $_GET['time'] != "") {

                switch ($_GET['time']) {
                    case 'week':
                        $startTime = date('Y-m-d 00:00:00', strtotime('this week'));
                        $endTime = date('Y-m-d H:i:s');
                        break;
                    case 'month':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of this month'));
                        $endTime = date('Y-m-d H:i:s');
                        break;

                    case 'year':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . date('Y')));
                        $endTime = date('Y-m-d H:i:s');
                        break;
                    case 'lastYear':
                        $lastYear = date('Y') - 1;
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . $lastYear));
                        $endTime = date('Y-m-d 23:59:59', strtotime('Dec 31'));
                        break;
                    case 'all':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January 1970'));
                        $endTime = date('Y-m-d H:i:s');
                        break;

                }

                $query .= " and  created_at>='" . $startTime . "' and created_at<='" . $endTime . "'";
            } else {


                if (isset($_GET['fromTime']) && $_GET['fromTime'] != "") {
                    $query .= " and  created_at>='" . date('Y-m-d 00:00:00', strtotime($_GET['fromTime'])) . "'";
                }

                if (isset($_GET['toTime']) && $_GET['toTime'] != "") {
                    $query .= " and  created_at<='" . date('Y-m-d 23:59:59', strtotime($_GET['toTime'])) . "'";
                }

            }
            if (isset($_GET['process']) && $_GET['process'] != "") {
                $query .= " and  status='" . $_GET['process'] . "'";
            }


            $userString = "";
            $namesearch = false;
            if (isset($_GET['clientName']) && $_GET['clientName'] != "") {
                $usersquery = "select * from clients where name like '%" . $_GET['clientName'] . "%'";
                $users = DB::select(DB::raw($usersquery));
                $userArray = array();
                if ($users != null) {
                    foreach ($users as $user) {
                        $userArray[] = $user->id;
                    }
                }
                if (count($userArray) > 0) {
                    $userString = implode(',', $userArray);
                }
                $namesearch = true;
            }

            if ($namesearch) {
                if ($userString != "") {
                    $sqlQuery = "SELECT * FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id WHERE `vendorid` = " . Auth::user()->id . " and `paid` = 'yes' " . $query . " and orders.customerid in ($userString)";
                } else {
                    $sqlQuery = "SELECT * FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id WHERE `vendorid` = " . Auth::user()->id . " and `paid` = 'yes' " . $query . " and orders.customerid = 0 ";
                }
            } else {
                $sqlQuery = "SELECT * FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id WHERE `vendorid` = " . Auth::user()->id . " and `paid` = 'yes' " . $query;
            }

            $earnings = DB::select(DB::raw($sqlQuery));

        } else if (isset($_GET['sideTime']) && $_GET['sideTime'] != "") {
            $startTime = date('Y-m-d 00:00:00');
            $endTime = date('Y-m-d 23:59:59');
            if (isset($_GET['sideTime'])) {
                switch ($_GET['sideTime']) {
                    case 'week':
                        $startTime = date('Y-m-d 00:00:00', strtotime('this week'));
                        break;
                    case 'month':
                        $startTime = date('Y-m-d 00:00:00', strtotime('this month'));
                        break;
                    case 'year':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . date('Y')));
                        break;
                    case 'all':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January 1970'));
                        break;
                }
            }
            $sqlQuery = "SELECT * FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid = orders.id WHERE `vendorid` = " . Auth::user()->id . " and `paid` = 'yes'  and  created_at>='" . $startTime . "' and created_at<='" . $endTime . "'";
            $earnings = DB::select(DB::raw($sqlQuery));
        } else {
            $sqlQuery = "SELECT * FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid = orders.id WHERE `vendorid` = " . Auth::user()->id . " and `paid` = 'yes'";
            $earnings = DB::select(DB::raw($sqlQuery));
        }

        if (isset($_GET['historybtn'])) {
            $query = "";
            if (isset($_GET['ref']) && $_GET['ref'] != "") {
                $query .= " and reference like '%" . $_GET['ref'] . "%'";
            }

            $startTime = date('Y-m-d 00:00:00');
            $endTime = date('Y-m-d 23:59:59');
            if (isset($_GET['time']) && $_GET['time'] != "") {

                switch ($_GET['time']) {
                    case 'week':
                        $startTime = date('Y-m-d 00:00:00', strtotime('this week'));
                        $endTime = date('Y-m-d H:i:s');
                        break;
                    case 'month':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of this month'));
                        $endTime = date('Y-m-d H:i:s');
                        break;

                    case 'year':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . date('Y')));
                        $endTime = date('Y-m-d H:i:s');
                        break;
                    case 'lastYear':
                        $lastYear = date('Y') - 1;
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . $lastYear));
                        $endTime = date('Y-m-d 23:59:59', strtotime('Dec 31'));
                        break;
                    case 'all':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January 1970'));
                        $endTime = date('Y-m-d H:i:s');
                        break;

                }

                $query .= " and  created_at>='" . $startTime . "' and created_at<='" . $endTime . "'";
            } else {


                if (isset($_GET['fromTime']) && $_GET['fromTime'] != "") {
                    $query .= " and  created_at>='" . date('Y-m-d 00:00:00', strtotime($_GET['fromTime'])) . "'";
                }

                if (isset($_GET['toTime']) && $_GET['toTime'] != "") {
                    $query .= " and  created_at<='" . date('Y-m-d 23:59:59', strtotime($_GET['toTime'])) . "'";
                }

            }

            $getHistory = DB::select('SELECT * FROM `withdraws` WHERE vendorid = ' . Auth::user()->id . $query);
        } else {
            $getHistory = DB::select('SELECT * FROM `withdraws` WHERE vendorid = ' . Auth::user()->id);
        }


        $withdraws = Withdraw::where('vendorid', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('vendor.withdraws', compact('withdraws', 'earnings', 'getHistory'));
    }

    public function customers()
    {
        $customers = VendorCustomers::where('vendor_customers.vendor_id', Auth::user()->id)
            ->where('vendor_customers.status', 1)
            ->join('clients', 'vendor_customers.customer_id', '=', 'clients.id')
            ->get(['clients.*']);

        $customer_array = [];
        foreach ($customers as $customer) {
            if (!empty($customer->first_name)) {
                $temp = [];
                $temp[0] = $customer->first_name . " " . $customer->last_name;
                $temp[1] = (string)$customer->latitude;
                $temp[2] = (string)$customer->longitude;
                $temp[3] = $customer->address;
                $temp[4] = $customer->email;
                $temp[5] = $customer->phone;
                $temp[6] = $customer->city;
                $temp[7] = (string)$customer->zip;

                $customer_array[] = $temp;

            } else {
                continue;
            }
        }

        $customer_array = json_encode($customer_array);

        return view('vendor.customers', compact('customers', 'customer_array'));
    }

    //add customer
    public function customer()
    {
        $query = "SELECT * FROM `orders`";

        $customers = DB::select(DB::raw($query));


        return view('vendor.customer', compact('customers'));

    }

    public function pos()
    {
        //$products=Product::where('vendorid',Auth::user()->id)->orderBy('id','desc')->get();
        $query = "";

        if (isset($_GET['product']) && $_GET['product'] != "") {
            $query .= " and title like '%" . $_GET['product'] . "%' ";
        }

        if (isset($_GET['category']) && $_GET['category'] != "") {
            $query .= " and category like '%" . $_GET['category'] . ",%' ";
        }

        if (isset($_GET['status']) && $_GET['status'] != "") {
            $query .= " and status = '" . $_GET['status'] . "' ";
        }

        if ($query != "") {
            $query = "SELECT * FROM `products` WHERE `vendorid`=" . Auth::user()->id . " " . $query . " order by id desc";
        } else {
            $query = "SELECT * FROM `products` WHERE `vendorid`=" . Auth::user()->id . " order by id desc";
        }

        $products = DB::select(DB::raw($query));
        return view('vendor.pos', compact('products'));
    }

    public function plant()
    {

        $param = "";
        $s = '';
        if (isset($_GET['order'])) {
            if (isset($_GET['status']) && $_GET['status'] != "") {
                //$param.=" status = '".$_GET['status']."' ";
                $s = " status = '" . $_GET['status'] . "' ";
            } else {
                $s = "status in (3,4)";
            }
            if (isset($_GET['time']) && $_GET['time'] != "") {

                $setttleDate = explode('-', $_GET['time']);
                $dateFiltered = $setttleDate[0] . "/" . $setttleDate[1] . "/" . $setttleDate[2];

                $param .= " and  created_at>='" . date('Y-m-d 00:00:00', strtotime($dateFiltered)) . "' and created_at <= '" . date('Y-m-d 23:59:59', strtotime($dateFiltered)) . "'";
            }
            if ($param != "") {

                $query = "SELECT * FROM `ordered_products` WHERE `vendorid`=" . Auth::user()->id . " and " . $s . " " . $param . " order by id desc";
            } else {
                $query = "SELECT * FROM `ordered_products` WHERE `vendorid`=" . Auth::user()->id . " and " . $s . " order by id desc";
            }

        } else {
            $query = "SELECT * FROM `ordered_products` WHERE `vendorid`=" . Auth::user()->id . " and status in (3,4) order by id desc";
        }

        // //echo $query;die;

        $orders = DB::select(DB::raw($query));


        $param2 = "";
        $s2 = '';
        if (isset($_GET['order2'])) {
            if (isset($_GET['status']) && $_GET['status'] != "") {
                //$param.=" status = '".$_GET['status']."' ";
                $s2 = " status = '" . $_GET['status'] . "' ";
            } else {
                $s2 = "status in (2,5,6)";
            }
            if (isset($_GET['time']) && $_GET['time'] != "") {
                $setttleDate = explode('-', $_GET['time']);
                $dateFiltered = $setttleDate[0] . "/" . $setttleDate[1] . "/" . $setttleDate[2];
                $param2 .= " and  created_at>='" . date('Y-m-d 00:00:00', strtotime($dateFiltered)) . "' and created_at<='" . date('Y-m-d 23:59:59', strtotime($dateFiltered)) . "'";
            }
            if ($param2 != "") {

                $query2 = "SELECT * FROM `ordered_products` WHERE `vendorid`=" . Auth::user()->id . " and " . $s2 . " " . $param2 . " order by id desc";
            } else {
                $query2 = "SELECT * FROM `ordered_products` WHERE `vendorid`=" . Auth::user()->id . " and " . $s2 . " order by id desc";
            }

        } else {
            $query2 = "SELECT * FROM `ordered_products` WHERE `vendorid`=" . Auth::user()->id . " and status in (2,5,6) order by id desc";
        }


        $orders2 = DB::select(DB::raw($query2));
        return view('vendor.plant', compact('orders', 'orders2'));
    }


    public function withdrawsubmit(Request $request)
    {
        $from = Vendors::findOrFail(Auth::user()->id);

        $withdrawcharge = Settings::findOrFail(1);
        $charge = $withdrawcharge->withdraw_fee;

        if ($request->amount > 0) {

            $amount = $request->amount;

            if ($from->current_balance >= $amount) {
                $fee = (($withdrawcharge->withdraw_charge / 100) * $amount) + $charge;
                $finalamount = $amount - $fee;
                $finalamount = number_format((float)$finalamount, 2, '.', '');

                $balance1['current_balance'] = $from->current_balance - $amount;
                $from->update($balance1);

                $newwithdraw = new Withdraw();
                $newwithdraw['vendorid'] = Auth::user()->id;
                $newwithdraw['method'] = $request->methods;
                $newwithdraw['acc_email'] = $request->acc_email;
                $newwithdraw['iban'] = $request->iban;
                $newwithdraw['country'] = $request->acc_country;
                $newwithdraw['acc_name'] = $request->acc_name;
                $newwithdraw['address'] = $request->address;
                $newwithdraw['swift'] = $request->swift;
                $newwithdraw['reference'] = $request->reference;
                $newwithdraw['amount'] = $finalamount;
                $newwithdraw['fee'] = $fee;
                $newwithdraw->save();

                return redirect()->back()->with('message', 'Withdraw Request Sent Successfully.');

            } else {
                return redirect()->back()->with('error', 'Insufficient Balance.')->withInput();
            }
        }
        return redirect()->back()->with('error', 'Please enter a valid amount.')->withInput();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Clients::whereId($id)->first();

        if (!empty($client)) {
            return view('vendor.customer-details', compact('client'));
        } else {
            return NULL;
        }
    }

    public function documents($id)
    {
        $client = Clients::whereId($id)->first();
        $documents =DB::table('clients')
                        ->join('orders', 'clients.id', '=', 'orders.customerid')
                        ->join('service_agreements', 'orders.id', '=', 'service_agreements.order_id')
                        ->select('service_agreements.*', 'orders.booking_date', 'orders.pay_amount')
                        ->where('clients.id', $id)
                        ->get();

        if (!empty($client)) {
            return view('vendor.customer-documents', compact('client', 'documents'));
        } else {
            return NULL;
        }
    }

    public function billing($id)
    {
        $client = Clients::whereId($id)->first();
        $card_details = ClientCreditCard::where('client_id', $client->id)->orderBy('id', 'desc')->get();
        if (!empty($client)) {
            return view('vendor.customer-billing', compact('client', 'card_details'));
        } else {
            return NULL;
        }
    }

    public function edit_card($id){

        $card_detail = ClientCreditCard::find($id);
        $user = Clients::find($card_detail->client_id);
        $client = $user;
        return view('vendor.billing-edit', compact('user','client', 'card_detail'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function templates($id)
    {

          $client = Clients::whereId($id)->first();
          $query = "SELECT * FROM `job_type`";
          $jobType = DB::select(DB::raw($query));
//        $query2 = "SELECT * FROM `orders`";
//        $orders=OrderedProducts::select('orderid')->where('vendorid',Auth::user()->id)->get();
        $customers = OrderTemplate::join('clients', 'order_templates.client_id', '=', 'clients.id')
            ->join('vendor_customers', 'vendor_customers.customer_id', '=', 'order_templates.client_id')
//            ->join('job_type', 'order_templates.job_type_id', '=', 'job_type.id')
            ->select('clients.name')
            ->where('vendor_customers.vendor_id', Auth::user()->id)->groupBy('clients.name');
        //print_r($customers);die;
        if (!empty($customers)) {
            return view('vendor.customer-templates', compact('customers','client','jobType'));
        } else {
            return NULL;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function orders($id)
    {
        if (isset($_GET['orderForm'])) {
            $query = "";

            if (isset($_GET['orderId']) && $_GET['orderId'] != "") {
                $query .= " and ordered_products.orderid='" . $_GET['orderId'] . "'";
            }
            $startTime = date('Y-m-d 00:00:00');
            $endTime = date('Y-m-d 23:59:59');
            if (isset($_GET['time']) && $_GET['time'] != "") {

                switch ($_GET['time']) {
                    case 'week':
                        $startTime = date('Y-m-d 00:00:00', strtotime('this week'));
                        $endTime = date('Y-m-d H:i:s');
                        break;
                    case 'month':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of this month'));
                        $endTime = date('Y-m-d H:i:s');
                        break;

                    case 'year':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . date('Y')));
                        $endTime = date('Y-m-d H:i:s');
                        break;
                    case 'lastYear':
                        $lastYear = date('Y') - 1;
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . $lastYear));
                        $endTime = date('Y-m-d 23:59:59', strtotime('Dec 31'));
                        break;
                    case 'all':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January 1970'));
                        $endTime = date('Y-m-d H:i:s');
                        break;

                }

                $query .= " and  ordered_products.created_at>='" . $startTime . "' and ordered_products.created_at<='" . $endTime . "'";
            } else {
                if (isset($_GET['fromTime']) && $_GET['fromTime'] != "") {
                    $query .= " and  ordered_products.created_at>='" . date('Y-m-d 00:00:00', strtotime($_GET['fromTime'])) . "'";
                }

                if (isset($_GET['toTime']) && $_GET['toTime'] != "") {
                    $query .= " and  ordered_products.created_at<='" . date('Y-m-d 23:59:59', strtotime($_GET['toTime'])) . "'";
                }

            }

            if (isset($_GET['process']) && $_GET['process'] != "") {
                $query .= " and  ordered_products.status='" . $_GET['process'] . "'";
            }

           // $query .= " AND  orders.order_type=3 AND orders.customerid=".$id;

            if (isset($_GET['paidStatus']) && $_GET['paidStatus'] != "") {
                $query .= " and  ordered_products.payment='" . $_GET['paidStatus'] . "'";
            }


            $userString = "";
            $namesearch = false;
            if (isset($_GET['clientName']) && $_GET['clientName'] != "") {
                $usersquery = "select * from clients where name like '%" . $_GET['clientName'] . "%'";
                $users = DB::select(DB::raw($usersquery));
                $userArray = array();
                if ($users != null) {
                    foreach ($users as $user) {
                        $userArray[] = $user->id;
                    }
                }
                if (count($userArray) > 0) {
                    $userString = implode(',', $userArray);
                }
                $namesearch = true;
            }

            if ($namesearch) {
                if ($userString != "") {
                    $orders = "SELECT *,ordered_products.status as status, orders.status AS order_status FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id LEFT JOIN clients ON orders.customerid = clients.id WHERE `vendorid` = " . Auth::user()->id . $query . " and orders.customerid in ($userString)";
                } else {
                    $orders = "SELECT *,ordered_products.status  as status, orders.status AS order_status FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id LEFT JOIN clients ON orders.customerid = clients.id WHERE `vendorid` = " . Auth::user()->id . $query . " and orders.customerid = 0 ";
                }
            } else {
                $orders = "SELECT *,ordered_products.status, orders.status AS order_status  FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id LEFT JOIN clients ON orders.customerid = clients.id WHERE `vendorid` = " . Auth::user()->id . $query;
            }


            $orders = DB::select(DB::raw($orders));

            foreach ($orders as $customer) {

                if (!empty($customer->first_name)) {
                    $temp = [];
                    $temp[0] = $customer->first_name . " " . $customer->last_name;
                    $temp[1] = (string)$customer->latitude;
                    $temp[2] = (string)$customer->longitude;
                    $temp[3] = $customer->address;
                    $temp[4] = $customer->email;
                    $temp[5] = $customer->phone;
                    $temp[6] = (string)$customer->orderid;
                    $temp[7] = (string)(date('M d, Y', strtotime($customer->created_at)));
                    $temp[8] = '$ ' . $customer->cost;
                    $temp[9] = $customer->order_status;
                    $temp[10] = $customer->payment == 'completed' ? 'Paid' : ($customer->payment == 'pending' ? 'Not Paid' : 'Partial Paid');

                    $customer_array[] = $temp;

                } else {
                    continue;
                }
            }

        } else {
            $orders = OrderedProducts::where('vendorid', 43)->orderBy('id', 'desc')->get();
        }
        $query = "SELECT * FROM `job_type`";
        $jobType = DB::select(DB::raw($query));
         $client = Clients::whereId($id)->first();
        if (!empty($client)) {
            return view('vendor.customer-orders', compact('client','orders','jobType'));
        } else {
            return NULL;
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function repeatOrders()
    {

    }


    public function history($id)
    {
        if (isset($_GET['orderForm'])) {
            $query = "";

            if (isset($_GET['orderId']) && $_GET['orderId'] != "") {
                $query .= " and ordered_products.orderid='" . $_GET['orderId'] . "'";
            }
            $startTime = date('Y-m-d 00:00:00');
            $endTime = date('Y-m-d 23:59:59');
            if (isset($_GET['time']) && $_GET['time'] != "") {

                switch ($_GET['time']) {
                    case 'week':
                        $startTime = date('Y-m-d 00:00:00', strtotime('this week'));
                        $endTime = date('Y-m-d H:i:s');
                        break;
                    case 'month':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of this month'));
                        $endTime = date('Y-m-d H:i:s');
                        break;

                    case 'year':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . date('Y')));
                        $endTime = date('Y-m-d H:i:s');
                        break;
                    case 'lastYear':
                        $lastYear = date('Y') - 1;
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January ' . $lastYear));
                        $endTime = date('Y-m-d 23:59:59', strtotime('Dec 31'));
                        break;
                    case 'all':
                        $startTime = date('Y-m-d 00:00:00', strtotime('first day of January 1970'));
                        $endTime = date('Y-m-d H:i:s');
                        break;

                }

                $query .= " and  ordered_products.created_at>='" . $startTime . "' and ordered_products.created_at<='" . $endTime . "'";
            } else {
                if (isset($_GET['fromTime']) && $_GET['fromTime'] != "") {
                    $query .= " and  ordered_products.created_at>='" . date('Y-m-d 00:00:00', strtotime($_GET['fromTime'])) . "'";
                }

                if (isset($_GET['toTime']) && $_GET['toTime'] != "") {
                    $query .= " and  ordered_products.created_at<='" . date('Y-m-d 23:59:59', strtotime($_GET['toTime'])) . "'";
                }

            }

            if (isset($_GET['process']) && $_GET['process'] != "") {
                $query .= " and  ordered_products.status='" . $_GET['process'] . "'";
            }

            // $query .= " AND  orders.order_type=3 AND orders.customerid=".$id;

            if (isset($_GET['paidStatus']) && $_GET['paidStatus'] != "") {
                $query .= " and  ordered_products.payment='" . $_GET['paidStatus'] . "'";
            }


            $userString = "";
            $namesearch = false;
            if (isset($_GET['clientName']) && $_GET['clientName'] != "") {
                $usersquery = "select * from clients where name like '%" . $_GET['clientName'] . "%'";
                $users = DB::select(DB::raw($usersquery));
                $userArray = array();
                if ($users != null) {
                    foreach ($users as $user) {
                        $userArray[] = $user->id;
                    }
                }
                if (count($userArray) > 0) {
                    $userString = implode(',', $userArray);
                }
                $namesearch = true;
            }

            if ($namesearch) {
                if ($userString != "") {
                    $orders = "SELECT *,ordered_products.status as status, orders.status AS order_status FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id LEFT JOIN clients ON orders.customerid = clients.id WHERE `vendorid` = " . Auth::user()->id . $query . " and orders.customerid in ($userString)";
                } else {
                    $orders = "SELECT *,ordered_products.status  as status, orders.status AS order_status FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id LEFT JOIN clients ON orders.customerid = clients.id WHERE `vendorid` = " . Auth::user()->id . $query . " and orders.customerid = 0 ";
                }
            } else {
                $orders = "SELECT *,ordered_products.status, orders.status AS order_status  FROM ordered_products INNER JOIN `orders` ON ordered_products.orderid =orders.id LEFT JOIN clients ON orders.customerid = clients.id WHERE `vendorid` = " . Auth::user()->id . $query;
            }


            $orders = DB::select(DB::raw($orders));

            foreach ($orders as $customer) {

                if (!empty($customer->first_name)) {
                    $temp = [];
                    $temp[0] = $customer->first_name . " " . $customer->last_name;
                    $temp[1] = (string)$customer->latitude;
                    $temp[2] = (string)$customer->longitude;
                    $temp[3] = $customer->address;
                    $temp[4] = $customer->email;
                    $temp[5] = $customer->phone;
                    $temp[6] = (string)$customer->orderid;
                    $temp[7] = (string)(date('M d, Y', strtotime($customer->created_at)));
                    $temp[8] = '$ ' . $customer->cost;
                    $temp[9] = $customer->order_status;
                    $temp[10] = $customer->payment == 'completed' ? 'Paid' : ($customer->payment == 'pending' ? 'Not Paid' : 'Partial Paid');

                    $customer_array[] = $temp;

                } else {
                    continue;
                }
            }

        } else {
            $orders = OrderedProducts::where('vendorid', Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        $query = "SELECT * FROM `job_type`";
        $jobType = DB::select(DB::raw($query));
        $client = Clients::whereId($id)->first();
        if (!empty($client)) {
            return view('vendor.ordertemplate-history', compact('client','orders','jobType'));
        } else {
            return NULL;
        }

    }

    public function sa_link(Request $request)
    {
        $id = $request->id;
        $vendorId = Auth::user()->id;
        $order = Order::findOrFail($id);
        
        $user = Clients::find($order->customerid);
        if(count($order->get()) != 0){

            // $serverUrl = url('/');

            // $link = $serverUrl."/shop-documents/".$id;
            $userData = [
                'user_id' => $user->id,
                'order_id' => $order->id
            ];

            $token = Crypt::encryptString(json_encode($userData));
            $order->token = $token;
            $order->update();
            $url = URL::temporarySignedRoute(
                'confirm.service', 
                now()->addHours(24), // Expiry time
                ['token' => $token] // Additional parameters
            );
            try {
                // Send the email
                Mail::to($user->email)->send(new ServiceAgreementMail($id, $url));
                $userAddressSplitted = explode(", ", $order->customer_address, 1); 
                $shippingAddressSplitted = $order->shipping_address? 
                    explode(", ", $order->shipping_address, 1): $userAddressSplitted;
                $validator = Validator::make(['order_id' => $order->id], [
                    'order_id' => 'required|max:255|unique:service_agreements'
                ]);
                
                if ($validator->fails()) {
                    // return redirect()->back()->with('message', 'Service Agreement link Sent Successfully.');
                    return json_encode(['message' => 'Service Agreement link Sent Successfully.']);
                }
        
                $serviceAgreement = ServiceAgreement::Create([
                    "company_name" => $user->business_name ? $user->business_name : "",
                    "contact_name" => $user->name,
                    "phone_number" => $user->phone,
                    "email" => $user->email,
                    "billing_address_1" => $userAddressSplitted[0],
                    "billing_address_2" => count($userAddressSplitted)>1? $userAddressSplitted[1] : "",
                    "billing_city" => $order->customer_city,
                    "billing_state" => $user->Province_State,
                    "billing_postal_code" => $order->customer_zip,
                    "billing_phone" => $order->customer_phone,
                    "billing_email" => $order->customer_email,
                    "shipping_address_1" => $shippingAddressSplitted[0],
                    "shipping_address_2" => count($shippingAddressSplitted)>1? $shippingAddressSplitted[1] : "",
                    "shipping_city" => $order->shipping_city ? $order->shipping_city: $order->customer_city,
                    "shipping_state" => "",
                    "shipping_postal_code" => $order->shipping_zip? $order->shipping_zip: $order->customer_zip,
                    "shipping_phone" => $order->shipping_phone ? $order->shipping_phone : $order->customer_phone,
                    "shipping_email" => $order->shipping_email ? $order->shipping_email : $order->customer_email,
                    "order_id" => $order->id,
                    "sa_state" => '0'
                ]);
                // return redirect()->back()->with('message', 'Service Agreement link Sent Successfully.');
                return json_encode(['message' => 'Service Agreement link Sent Successfully.']);
            } catch (\Exception $e) {
                // Error occurred while sending email
                // return redirect()->back()->with('errors', 'Service Agreement link Sent Failed.');
                return json_encode(['errors' => 'Service Agreement link Sent Failed.']);
            }
        }
        else {
            // return redirect()->back()->with('errors', 'Service Agreement link Sent Failed.');
            return json_encode(['errors' => 'Service Agreement link Sent Failed.']);
        }
        
    }

    public function service_agreement($id)
    {
        $order = Order::find($id);
        $customer = Clients::find($order->customerid);
        $user = $customer;
        $documents = ServiceAgreement::where('order_id', $id)->first();
        $order_details =DB::table('ordered_products')
                        ->join('products', 'products.id', '=', 'ordered_products.productid')
                        ->select('ordered_products.*','products.title')
                        ->where('ordered_products.orderid', $order->id)
                        ->get();
        return view('home.vendor-service-agreement', compact('user','customer','documents', 'order','order_details'));
    }

    public function complete_sa(Request $request)
    {
        $serviceAgreement = ServiceAgreement::updateOrCreate(['order_id' => $request->order_id]);
        $serviceAgreement->fill($request->all());
        $serviceAgreement->update();
        return redirect('/vendor/details/'.$request->order_id)->with('message', 'Completed Document Successfully');
    }

    public function order_print($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {

        }
        $model = DB::select("select * from ordered_products where orderid='$id'");
        $orderCheck=Order::where("id",$id)->where("order_type",3)->first();
        view()->share('model', $model);
        view()->share('order', $order);
        
        return view('home.shop.order_pdf_print');
        if($orderCheck){
            $orderinquiry=OrderInquiry::where("order_id",$id)->first();
            view()->share('orderinquiry', $orderinquiry);
             return view('vendor.order_print', compact('model', 'order','orderinquiry'));
        }
        else {
             return view('vendor.order_print', compact('model', 'order'));
        }
    }

    public function service_agreement_print($id)
    {
        $order = Order::find($id);
        $customer = Clients::find($order->customerid);
        $user = $customer;
        $documents = ServiceAgreement::where('order_id', $id)->first();
        $order_details =DB::table('ordered_products')
                        ->join('products', 'products.id', '=', 'ordered_products.productid')
                        ->select('ordered_products.*','products.title')
                        ->where('ordered_products.orderid', $order->id)
                        ->get();
        view()->share('documents', $documents);
        view()->share('order', $order);
        view()->share('order_details', $order_details);
        return view('vendor.service_agreement_print', compact('order','documents', 'order_details'));
    }

    public function service_agreement_download($id)
    {
        $order = Order::find($id);
        $customer = Clients::find($order->customerid);
        $user = $customer;
        $documents = ServiceAgreement::where('order_id', $id)->first();
        $order_details =DB::table('ordered_products')
                        ->join('products', 'products.id', '=', 'ordered_products.productid')
                        ->select('ordered_products.*','products.title')
                        ->where('ordered_products.orderid', $order->id)
                        ->get();
        view()->share('documents', $documents);
        view()->share('order', $order);
        view()->share('order_details', $order_details);
        // return view('vendor.service_agreement_download');
        
        $booking_date = date('mdy', strtotime($order->booking_date));
        $pdf = PDF::loadView('vendor.service_agreement_download',compact('order','documents', 'order_details'));
        return $pdf->download('SA'.$order->id.'_'.ucwords($user->first_name) . ucwords($user->last_name).'_'.$booking_date.'.pdf');
    }

    

    public function service_agreement_email($id)
    {
        $order = Order::find($id);
        $customer = Clients::find($order->customerid);
        $user = $customer;
        $documents = ServiceAgreement::where('order_id', $id)->first();
        $order_details =DB::table('ordered_products')
                        ->join('products', 'products.id', '=', 'ordered_products.productid')
                        ->select('ordered_products.*','products.title')
                        ->where('ordered_products.orderid', $order->id)
                        ->get();
        view()->share('documents', $documents);
        view()->share('order', $order);
        view()->share('order_details', $order_details);
        $pdf = PDF::loadView('vendor.service_agreement_download',compact('order','documents', 'order_details'));


        $pdfContent = $pdf->output();

        // Save PDF to storage
        $booking_date = date('mdy', strtotime($order->booking_date));
        $pdfPath = storage_path('app/SA'.$order->id.'_'.ucwords($user->first_name) . ucwords($user->last_name).'_'.$booking_date.'.pdf');
        if(file_exists($pdfPath)){
            unlink($pdfPath);
        }
        file_put_contents($pdfPath, $pdfContent);
        try {
            Mail::to($user->email)->send(new ServiceAgreementPDFMail($order, $documents, $order_details, $pdfPath));
            return redirect()->back()->with('message', 'Email sent Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'Email sent Failed');
        }
        
    }

    public function upload_index($id)
    {
        $order_id = $id;
        $documents =DB::table('upload_documents')
                        ->join('orders', 'orders.doc_id', '=', 'upload_documents.id')
                        ->select('upload_documents.*')
                        ->get();
        return view('home.shop.documents.upload_index', compact('order_id','documents'));
    }

    public function delete_doc($id)
    {
        $document = Upload_document::find($id);
        if (Storage::exists($document->file_path)) {
            // File exists, delete it
            Storage::delete($document->file_path);
        }
        $document->delete();
        $order = Order::where('doc_id', $id);
        if(is_null($order)){
            $order->doc_id = "";
            $order->update();
        }
        
        return redirect()->back()->with('message', "Document deleted Successfully");
    }

    public function upload_doc(Request $request)
    {
        $request->validate([
            'order_number' => 'required',
            'order_date' => 'required|date',
            'document' => 'required|file',
        ]);
    
        // Process the uploaded document
        $file = $request->file('document');
        if($file->isValid()){

            // Save the file to storage
            $path = $file->store('document_uploads');

            // Save file information to the database
            $order = Order::find($request->order_number);
            $oldFile1 = Upload_document::where('order_id', $request->order_number)->first();
            if(is_null($oldFile1)){
                $newFile = new Upload_document;
                $newFile->order_id = $request->order_number;
                $newFile->order_date = $request->order_date;
                $newFile->doc_type = $file->getClientOriginalExtension();
                $newFile->file_name = $file->getClientOriginalName();
                $newFile->file_path = $path;
                $newFile->save();
                $doc_id = $newFile->id;
                $order->doc_id = $doc_id;
                $order->complete_date = $request->order_date;
                $order->update();
            }
            else {
                $oldFile = Upload_document::find($oldFile1->id);
                $oldFile->order_date = $request->order_date;
                $oldFile->doc_type = $file->getClientOriginalExtension();
                $oldFile->file_name = $file->getClientOriginalName();
                $oldFile->file_path = $path;
                $oldFile->update();
                $doc_id = $oldFile->id;
                $order->doc_id = $doc_id;
                $order->complete_date = $request->order_date;
                $order->update();
            }
            
            // Save it to storage, database, or perform other operations
            
            // Redirect back with a success message
            return redirect()->back()->with('message', 'Document uploaded successfully.');
        }
        else {
            return redirect()->back()->with('errors', ['Document upload failed.']);
        }

        
        
    }

    public function download_doc($id)
    {
        
        $file = Upload_document::find($id);
        $filePath = $file->file_path;
        // Check if the file exists
        if (Storage::exists($filePath)) {
            // File exists, return a response to download the file
            return Storage::download($filePath);
        } else {
            // File not found, return a 404 Not Found response
            abort(404);
        }
    }

    public function orderDownload($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            return false;
        }
        $model = DB::select("select * from ordered_products where orderid='$id'");
        $orderCheck=Order::where("id",$id)->where("order_type",3)->first();
        view()->share('model', $model);
        view()->share('order', $order);
        if($orderCheck){
            $orderinquiry=OrderInquiry::where("order_id",$id)->first();
            view()->share('orderinquiry', $orderinquiry);
            $pdf = PDF::loadView('vendor.order_pdf');
            return $pdf->download('order' . $order->id . '.pdf');
        }
        else {
            $pdf = PDF::loadView('vendor.order_pdf');
            return $pdf->download('order' . $order->id . '.pdf');
        }
        //return view('shop.order_pdf',compact('user','order','multiple_address'))->render();
    }

    public function customer_orderDownload($id)
    {
        $order = Order::findOrFail($id);
        if($order->order_type == 3){
            $products = OrderTemplateItem::where('order_template_id', $order->template_id)->get();
            // return view('vendor.custom_order_pdf', compact('order', 'products'));
            $pdf = PDF::loadview('vendor.customer_order_pdf', compact('order', 'products'));
            return $pdf->download('order#' . $order->id . '.pdf');
        }
        else {
            $products = OrderedProducts::where('orderid', $id)->get();
            // return view('vendor.ordertemplate-order-show', compact('order', 'products'));
            $pdf = PDF::loadview('vendor.customer_order2_pdf', compact('order', 'products'));
            return $pdf->download('order#' . $order->id . '.pdf');
        }
    }

    public function customer_orderPrint($id)
    {
        $order = Order::findOrFail($id);
        if($order->order_type == 3){
            $products = OrderTemplateItem::where('order_template_id', $order->template_id)->get();
            return view('vendor.customer_order_print', compact('order', 'products'));
            // $pdf = PDF::loadview('vendor.customer_order_pdf', compact('order', 'products'));
            // return $pdf->download('order#' . $order->id . '.pdf');
        }
        else {
            $products = OrderedProducts::where('orderid', $id)->get();
            return view('vendor.customer_order2_print', compact('order', 'products'));
            // $pdf = PDF::loadview('vendor.customer_order2_pdf', compact('order', 'products'));
            // return $pdf->download('order#' . $order->id . '.pdf');
        }
    }

}
